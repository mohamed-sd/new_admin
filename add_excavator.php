<?php
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
  exit;
}
require_once 'config.php';

// اظهار الأخطاء أثناء التطوير (احذف السطرين في الإنتاج)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = ""; // رسائل النجاح/الفشل

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $table = isset($_POST['table']) ? $_POST['table'] : 'excavator';

  // حماية بسيطة لاسم الجدول
  if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
    $message = "<div class='error'>❌ اسم جدول غير صالح.</div>";
  } else {
    // إزالة الحقول غير اللازمة
    unset($_POST['submit'], $_POST['table']);

    // تنظيف القيم
    $data = array();
    foreach ($_POST as $k => $v) {
      $v = is_array($v) ? $v : trim($v);
      // لو الحقل رقمي وفاضي → خليه 0
      if (
        $v === "" && in_array($k, [
          'shift_hours',
          'counter_start',
          'executed_hours',
          'bucket_hours',
          'jackhammer_hours',
          'extra_hours',
          'extra_hours_total',
          'standby_hours',
          'total_work_hours',
          'other_fault_hours',
          'counter_end',
          'counter_diff'
        ])
      ) {
        $v = 0;
      }
      $data[$k] = $v;
    }

    // ✅ دمج القيم لعداد البداية (بدون استخدام ??)
    $start_h = (int) (isset($_POST['start_hours']) ? $_POST['start_hours'] : 0);
    $start_m = (int) (isset($_POST['start_minutes']) ? $_POST['start_minutes'] : 0);
    $start_s = (int) (isset($_POST['start_seconds']) ? $_POST['start_seconds'] : 0);
    $data['counter_start'] = sprintf("%d:%02d:%02d", $start_h, $start_m, $start_s);

    // ✅ دمج القيم لعداد النهاية (بدون استخدام ??)
    $end_h = (int) (isset($_POST['end_hours']) ? $_POST['end_hours'] : 0);
    $end_m = (int) (isset($_POST['end_minutes']) ? $_POST['end_minutes'] : 0);
    $end_s = (int) (isset($_POST['end_seconds']) ? $_POST['end_seconds'] : 0);
    $data['counter_end'] = sprintf("%d:%02d:%02d", $end_h, $end_m, $end_s);

    // 🗑️ احذف الحقول اللي مش موجودة في الجدول
    unset($data['start_hours'], $data['start_minutes'], $data['start_seconds']);
    unset($data['end_hours'], $data['end_minutes'], $data['end_seconds']);

    // تحقق أساسي من الحقول المهمة
    if (!isset($data['driver_name']) || $data['driver_name'] === '') {
      $message = "<div class='error'>⚠️ برجاء إدخال اسم السائق.</div>";
    } elseif (!isset($data['cost_code']) || $data['cost_code'] === '') {
      $message = "<div class='error'>⚠️ برجاء اختيار المعدة.</div>";
    } else {
      // محاولة الإضافة
      $insertId = insertData($table, $data);
      if ($insertId) {
        $message = "<div class='success'>✅ تمت إضافة البيانات بنجاح برقم: " . (int) $insertId . "</div>";
        $data = array(); // reset
      } else {
        $message = "<div class='error'>❌ فشل في إضافة البيانات. تأكد من أسماء الأعمدة وتوافقها مع الجدول.</div>";
      }
    }
  }
}

// دالة صغيرة لإعادة ملء الحقول بعد الفشل
function old($key, $default = '')
{
  return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : $default;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <title>إضافة بيانات الحفار (Excavator)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <style>
    body {
      font-family: Tahoma, Arial;
      background: #f4f6f9;
      margin: 0;
    }

    .container {
      width: 90%;
      max-width: 980px;
      margin: 30px auto;
      background: #fff;
      padding: 24px 28px;
      border-radius: 12px;
      box-shadow: 0 3px 12px rgba(0, 0, 0, .08);
    }

    h2 {
      text-align: center;
      color: #333;
      margin: 0 0 18px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px 18px;
    }

    label {
      font-weight: bold;
      color: #444;
      font-size: 14px;
      display: block;
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select {
      width: 100%;
      padding: 9px 10px;
      border: 1px solid #ccd1d9;
      border-radius: 8px;
      box-sizing: border-box;
    }

    textarea {
      min-height: 70px;
      resize: vertical;
    }

    .full {
      grid-column: 1 / -1;
    }

    .actions {
      margin-top: 18px;
    }

    button {
      width: 100%;
      background: #d5d567ff;
      color: #000;
      border: none;
      padding: 12px 14px;
      font-size: 16px;
      border-radius: 10px;
      cursor: pointer;
    }

    button:hover {
      background: #e3e348ff;
    }

    .success,
    .error {
      padding: 12px;
      margin: 0 0 14px;
      border-radius: 8px;
      border: 1px solid transparent;
    }

    .success {
      background: #d4edda;
      color: #155724;
      border-color: #c3e6cb;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
      border-color: #f5c6cb;
    }

    .note {
      color: #666;
      font-size: 13px;
      margin: 6px 0 0;
    }

    @media (max-width: 720px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>


  <!-- المحتوى الرئيسي -->
  <div class="main" id="main">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>

    <div class="container">
      <h2>إضافة بيانات الحفار (Excavator)</h2>

      <?php if ($message)
        echo $message; ?>

      <form action="" method="POST" novalidate>
        <input type="hidden" name="table" value="excavator">

        <div class="grid">
          <?php
          $user = $_SESSION['user_id'];
          $machines = $conn->query("SELECT id, plant_no FROM master WHERE `status`='1' AND user='$user'");
          ?>
          <div class="full">
            <label>⚙️ اسم المعدة / Cost Code</label>
            <select name="cost_code" id="cost_code" onchange="loadMachineData()" required>
              <option value="">-- اختر المعدة --</option>
              <?php while ($m = $machines->fetch_assoc()): ?>
                <option value="<?php echo $m['id']; ?>" <?php echo old('cost_code') == $m['id'] ? 'selected' : ''; ?>>
                  <?php echo $m['plant_no']; ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="full">
            <!-- <label>اسم مدخل البيانات *</label> -->
            <input type="hidden" name="entry_name" required value="<?php echo $_SESSION['username']; ?>" readonly>
          </div>

           <div>
            <input type="hidden" name="machine_name" value="<?php echo old('machine_name', 0); ?>" readonly>
          </div>

           <div>
            <input type="hidden" name="project_name" value="<?php echo old('project_name', 0); ?>" readonly>
          </div>

           <div>
            <input type="hidden" name="owner_name" value="<?php echo old('owner_name', 0); ?>" readonly>
          </div>

          <div>
            <label>اسم السائق *</label>
            <input type="text" name="driver_name" required value="<?php echo old('driver_name'); ?>">
          </div>

          <div>
            <label>الوردية</label>
            <select name="shift" class="form-control" required>
              <option value="">-- اختر الوردية --</option>
              <option value="D">صباحية</option>
              <option value="N">مسائية</option>
            </select>
          </div>

          <div>
            <label>ساعات الوردية</label>
            <input type="number" name="shift_hours" value="<?php echo old('shift_hours', 0); ?>" readonly>
          </div>

          <div><br /></div>
          <div></div>
          <div></div>
          <label>
            <h5>⏱️ عداد البداية</h5>
          </label>
          <div class="row">

            <div class="col-lg-3">
              <label>ثواني</label>
              <input type="number" id="start_seconds" name="start_seconds" value="0" min="0" max="59" required>
            </div>
            <div class="col-lg-3">
              <label>دقائق</label>
              <input type="number" id="start_minutes" name="start_minutes" value="0" min="0" max="59" required>
            </div>
            <div class="col-lg-5">
              <label>ساعات</label>
              <input type="number" id="start_hours" name="start_hours" value="0">
            </div>
          </div>

          <div> </div>

          <div>
            <label>
              <h5>⏱️ الساعات </h5>
            </label>
          </div>

          <div> </div>

          <div> </div>

          <div>
            <label>الساعات المنفذة</label>
            <input type="number" name="executed_hours" value="<?php echo old('executed_hours', 0); ?>">
          </div>

          <div>
            <label>ساعات جردل</label>
            <input type="number" name="bucket_hours" value="<?php echo old('bucket_hours', 0); ?>">
          </div>

          <div>
            <label>ساعات جاك همر</label>
            <input type="number" name="jackhammer_hours" value="<?php echo old('jackhammer_hours', 0); ?>">
          </div>

          <div>
            <label>ساعات إضافية</label>
            <input type="number" name="extra_hours" value="<?php echo old('extra_hours', 0); ?>">
          </div>

          <div>
            <label>مجموع الساعات الإضافية</label>
            <input type="number" name="extra_hours_total" value="<?php echo old('extra_hours_total', 0); ?>">
          </div>

          <div>
            <label>ساعات الاستعداد (بسبب العميل)</label>
            <input type="number" name="standby_hours" value="<?php echo old('standby_hours', 0); ?>">
          </div>

          <div>
            <label>ساعات الاستعداد ( اعتماد )</label>
            <input type="number" name="dependence_hours" value="<?php echo old('dependence_hours', 0); ?>">
          </div>

          <div>
            <label>مجموع ساعات العمل</label>
            <input type="number" name="total_work_hours" value="<?php echo old('total_work_hours', 0); ?>" readonly>
          </div>

          <div class="full">
            <label>ملاحظات ساعات العمل</label>
            <textarea name="work_notes"><?php echo old('work_notes'); ?></textarea>
          </div>

          <div>
            <label>
              <br />
              <h5>⏱️ ساعات الاعطال </h5>
            </label>
          </div>

          <div> </div>

          <div> </div>

          <div>
            <label>عطل HR</label>
            <input type="number" name="hr_fault" value="<?php echo old('hr_fault' ,0); ?>">
          </div>

          <div>
            <label>عطل صيانة</label>
            <input type="number" name="maintenance_fault" value="<?php echo old('maintenance_fault',0); ?>">
          </div>

          <div>
            <label>عطل تسويق</label>
            <input type="number" name="marketing_fault" value="<?php echo old('marketing_fault',0); ?>">
          </div>

          <div>
            <label>عطل اعتماد</label>
            <input type="number" name="approval_fault" value="<?php echo old('approval_fault',0); ?>">
          </div>

          <div>
            <label>ساعات أعطال أخرى</label>
            <input type="number" name="other_fault_hours" value="<?php echo old('other_fault_hours', 0); ?>">
          </div>

          <div>
            <label> مجموع ساعات التعطل</label>
            <input type="number" name="total_fault_hours" value="<?php echo old('total_fault_hours', 0); ?>" readonly>
          </div>

          <div class="full">
            <label>ملاحظات ساعات الأعطال</label>
            <textarea name="fault_notes"><?php echo old('fault_notes'); ?></textarea>
          </div>

          <!-- <div>
          <label>عداد النهاية</label>
          <input type="number" name="counter_end" value="<?php echo old('counter_end', 0); ?>">
        </div> -->

          <div> <label>
              <h5>⏱️ عداد النهاية</h5>
            </label> </div>

          <div class="row">

            <div class="col-lg-3">
              <label>ثواني</label>
              <input type="number" id="end_seconds" name="end_seconds" value="0">
            </div>
            <div class="col-lg-4">
              <label>دقائق</label>
              <input type="number" id="end_minutes" name="end_minutes" value="0">
            </div>
            <div class="col-lg-5">
              <label>ساعات</label>
              <input type="number" id="end_hours" name="end_hours" value="0">
            </div>
          </div>

          <div>
            <label>⚡ فرق العداد</label>
            <input type="text" name="counter_diff" id="counter_diff_display" readonly>
            <input type="hidden" id="counter_diff" />
          </div>

          <div>
            <label>
              <br />
              <h5> الاعطال </h5>
            </label>
          </div>

          <div> </div>

          <div> </div>

          <div>
            <label>نوع العطل</label>
            <input type="text" name="fault_type" value="<?php echo old('fault_type'); ?>">
          </div>

          <div>
            <label>قسم العطل</label>
            <input type="text" name="fault_department" value="<?php echo old('fault_department'); ?>">
          </div>

          <div>
            <label>الجزء المعطل</label>
            <input type="text" name="fault_part" value="<?php echo old('fault_part'); ?>">
          </div>

          <div class="full">
            <label>تفاصيل العطل</label>
            <textarea name="fault_details"><?php echo old('fault_details'); ?></textarea>
          </div>

          <div class="full">
            <label>ملاحظات عامة</label>
            <textarea name="general_notes"><?php echo old('general_notes'); ?></textarea>
          </div>

          <div>
            <label>
              <br />
              <h5> ساعات عمل المشغل </h5>
            </label>
          </div>

          <div> </div>

          <div>k </div>

          <div>
            <label>⏱️ ساعات عمل المشغل</label>
            <input type="text" name="operator_hours" value="<?php echo old('operator_hours'); ?>">
          </div>

          <div>
            <label>⚙️ ساعات استعداد الآلية</label>
            <input type="text" name="machine_standby_hours" value="<?php echo old('machine_standby_hours'); ?>" readonly>
          </div>

          <div>
            <label>⚙️ ساعات استعداد الجاك همر</label>
            <input type="text" name="jackhammer_standby_hours" value="<?php echo old('jackhammer_standby_hours'); ?>">
          </div>

          <div>
            <label>⚙️ ساعات استعداد الجردل</label>
            <input type="text" name="bucket_standby_hours" value="<?php echo old('bucket_standby_hours'); ?>">
          </div>

          <div>
            <label>➕ الساعات الإضافية</label>
            <input type="text" name="extra_operator_hours" class="form-control"
              value="<?php echo old('extra_operator_hours'); ?>">
          </div>

          <div>
            <label>👷 ساعات استعداد المشغل</label>
            <input type="text" name="operator_standby_hours" class="form-control"
              value="<?php echo old('operator_standby_hours'); ?>">
          </div>

        </div>

        <div class="col-12 mb-3">
          <label>📝 ملاحظات المشغل</label>
          <textarea name="operator_notes" class="form-control"><?php echo old('operator_notes'); ?></textarea>
        </div>

        <div class="actions">
          <button class="btn btn-warning w-100" type="submit" name="submit">💾 حفظ</button>
        </div>

      </form>
    </div>
    <script>



      function loadMachineData() {
        let id = document.getElementById("cost_code").value;
        if (id === "") return;
        fetch("get_machine.php?id=" + id)
          .then(res => res.json())
          .then(data => {
            if (data) {
              document.querySelector("input[name='shift_hours']").value = data.hours / 2 || "";
              document.querySelector("input[name='machine_name']").value = data.plant_no|| "";
              document.querySelector("input[name='project_name']").value = data.project_name|| "";
              document.querySelector("input[name='owner_name']").value = data.owner|| "";
            }
          })
          .catch(err => console.error("خطأ في جلب البيانات:", err));
      }

      function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("hide");
        document.getElementById("main").classList.toggle("full");
      }


      document.querySelectorAll("#start_minutes, #start_seconds, #end_minutes, #end_seconds")
        .forEach(inp => {
          inp.addEventListener("input", function () {
            let max = 59, min = 0;
            if (this.value > max) this.value = max;
            if (this.value < min) this.value = min;
          });
        });


          // ✅ دالة لحساب العمليات الثلاثة
  function calculateCustomHours() {
    let dependence = parseFloat(document.querySelector("input[name='dependence_hours']").value) || 0;
    let executed = parseFloat(document.querySelector("input[name='executed_hours']").value) || 0;
    let extraTotal = parseFloat(document.querySelector("input[name='extra_hours_total']").value) || 0;
    let standby = parseFloat(document.querySelector("input[name='standby_hours']").value) || 0;
    let shift = parseFloat(document.querySelector("input[name='shift_hours']").value) || 0;
    let maintenance = parseFloat(document.querySelector("input[name='maintenance_fault']").value) || 0;
    let marketing = parseFloat(document.querySelector("input[name='marketing_fault']").value) || 0;

    // العملية الأولى: مجموع ساعات العمل
    let totalWork = executed + extraTotal + standby;
    document.querySelector("input[name='total_work_hours']").value = totalWork;

    // العملية الثانية: ساعات أعطال أخرى
    let otherFault = shift - executed - standby - dependence;
    if (otherFault < 0) otherFault = 0;
    document.querySelector("input[name='total_fault_hours']").value = otherFault;

    // العملية الثالثة: ساعات استعداد المشغل
    let operatorStandby = 0;
    if (executed < shift) {
      operatorStandby = maintenance + marketing + dependence;
    }
    document.querySelector("input[name='operator_standby_hours']").value = operatorStandby;

    // اسناد قيمة استعدات الاليه 
    document.querySelector("input[name='machine_standby_hours']").value = standby;
  }

  // شغل الحساب عند أي تغيير في الحقول
  document.querySelectorAll("input[name='executed_hours'], input[name='extra_hours_total'], input[name='standby_hours'], input[name='shift_hours'], input[name='maintenance_fault'], input[name='marketing_fault'] , input[name='dependence_hours'] , input[name='machine_standby_hours']  ")
    .forEach(el => el.addEventListener("input", calculateCustomHours));

  // ✅ استدعاء أول مرة
  calculateCustomHours();

      function calculateDiff() {
        // اجمع البداية
        let start =
          (parseInt(document.getElementById("start_hours").value || 0) * 3600) +
          (parseInt(document.getElementById("start_minutes").value || 0) * 60) +
          (parseInt(document.getElementById("start_seconds").value || 0));

        // اجمع النهاية
        let end =
          (parseInt(document.getElementById("end_hours").value || 0) * 3600) +
          (parseInt(document.getElementById("end_minutes").value || 0) * 60) +
          (parseInt(document.getElementById("end_seconds").value || 0));

        let executed = parseFloat(document.querySelector("input[name='executed_hours']").value) || 0;
        let extraTotal = parseFloat(document.querySelector("input[name='extra_hours_total']").value) || 0;

        let diff = end - start;
        if (diff < 0) diff = 0; // حماية

        // حوّل الفرق إلى ساعات/دقائق/ثواني
        let hours = (executed + extraTotal) - Math.floor(diff / 3600);
        let minutes = Math.floor((diff % 3600) / 60);
        let seconds = diff % 60;

        // عرض الفرق
        document.getElementById("counter_diff_display").value =
          hours + " ساعة " + minutes + " دقيقة " + seconds + " ثانية";

        // حفظ القيمة (بالثواني) للإرسال
        document.getElementById("counter_diff").value = diff;
      }

      // شغل الحساب عند أي تغيير
      document.querySelectorAll("#start_hours, #start_minutes, #start_seconds, #end_hours, #end_minutes, #end_seconds")
        .forEach(el => el.addEventListener("input", calculateDiff));

      calculateDiff(); // تشغيل أول مرة



    </script>
  </div>
</body>

</html>