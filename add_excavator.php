<?php
session_start();
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
            if ($v === "" && in_array($k, [
                'shift_hours','counter_start','executed_hours','bucket_hours','jackhammer_hours',
                'extra_hours','extra_hours_total','standby_hours','total_work_hours',
                'other_fault_hours','counter_end','counter_diff'
            ])) {
                $v = 0;
            }
            $data[$k] = $v;
        }

        // تحقق أساسي من الحقول المهمة
        if (!isset($data['driver_name']) || $data['driver_name'] === '') {
            $message = "<div class='error'>⚠️ برجاء إدخال اسم السائق.</div>";
        } elseif (!isset($data['cost_code']) || $data['cost_code'] === '') {
            $message = "<div class='error'>⚠️ برجاء اختيار المعدة.</div>";
        } else {
            // محاولة الإضافة
            $insertId = insertData($table, $data);
            if ($insertId) {
                $message = "<div class='success'>✅ تمت إضافة البيانات بنجاح برقم: " . (int)$insertId . "</div>";
                $data = array(); // reset
            } else {
                $message = "<div class='error'>❌ فشل في إضافة البيانات. تأكد من أسماء الأعمدة وتوافقها مع الجدول.</div>";
            }
        }
    }
}

// دالة صغيرة لإعادة ملء الحقول بعد الفشل
function old($key, $default = '') {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : $default;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إضافة بيانات الحفار (Excavator)</title>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    body { font-family: Tahoma, Arial; background:#f4f6f9; margin:0; }
    .container { width: 90%; max-width: 980px; margin: 30px auto; background:#fff; padding:24px 28px; border-radius:12px; box-shadow:0 3px 12px rgba(0,0,0,.08); }
    h2 { text-align:center; color:#333; margin:0 0 18px; }
    .grid { display:grid; grid-template-columns: repeat(2, 1fr); gap:14px 18px; }
    label { font-weight:bold; color:#444; font-size:14px; display:block; margin-bottom:6px; }
    input[type="text"], input[type="number"], textarea, select {
      width:100%; padding:9px 10px; border:1px solid #ccd1d9; border-radius:8px; box-sizing:border-box;
    }
    textarea { min-height:70px; resize:vertical; }
    .full { grid-column: 1 / -1; }
    .actions { margin-top:18px; }
    button {
      width:100%; background:#007bff; color:#fff; border:none; padding:12px 14px; font-size:16px;
      border-radius:10px; cursor:pointer;
    }
    button:hover { background:#005ec4; }
    .success, .error {
      padding:12px; margin:0 0 14px; border-radius:8px; border:1px solid transparent;
    }
    .success { background:#d4edda; color:#155724; border-color:#c3e6cb; }
    .error { background:#f8d7da; color:#721c24; border-color:#f5c6cb; }
    .note { color:#666; font-size:13px; margin:6px 0 0; }
    @media (max-width: 720px) { .grid { grid-template-columns: 1fr; } }
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

    <?php if ($message) echo $message; ?>

    <form action="" method="POST" novalidate>
      <input type="hidden" name="table" value="excavator">

      <div class="grid">
<?php
$user = $_SESSION['user_id'];
$machines = $conn->query("SELECT id, plant_no FROM master WHERE `status`='1' AND user='$user'");
?>
<div class="full">
  <label>⚙️ اسم المعدة / Cost Code</label>
  <select name="cost_code" id="cost_code" required>
    <option value="">-- اختر المعدة --</option>
    <?php while($m = $machines->fetch_assoc()): ?>
      <option value="<?php echo $m['id']; ?>" <?php echo old('cost_code')==$m['id']?'selected':''; ?>>
        <?php echo $m['plant_no']; ?>
      </option>
    <?php endwhile; ?>
  </select>
</div>

        <div class="full">
          <label>اسم مدخل البيانات *</label>
          <input type="text" name="entry_name" required value="<?php echo $_SESSION['username']; ?>">
        </div>

        <div class="full">
          <label>اسم السائق *</label>
          <input type="text" name="driver_name" required value="<?php echo old('driver_name'); ?>">
        </div>

        <div>
          <label>الوردية</label>
          <input type="text" name="shift" value="<?php echo old('shift'); ?>">
        </div>

        <div>
          <label>ساعات الوردية</label>
          <input type="number" name="shift_hours" value="<?php echo old('shift_hours',0); ?>">
        </div>

        <div>
          <label>عداد البداية</label>
          <input type="number" name="counter_start" value="<?php echo old('counter_start',0); ?>">
        </div>

        <div>
          <label>الساعات المنفذة</label>
          <input type="number" name="executed_hours" value="<?php echo old('executed_hours',0); ?>">
        </div>

        <div>
          <label>ساعات جردل</label>
          <input type="number" name="bucket_hours" value="<?php echo old('bucket_hours',0); ?>">
        </div>

        <div>
          <label>ساعات جاك همر</label>
          <input type="number" name="jackhammer_hours" value="<?php echo old('jackhammer_hours',0); ?>">
        </div>

        <div>
          <label>ساعات إضافية</label>
          <input type="number" name="extra_hours" value="<?php echo old('extra_hours',0); ?>">
        </div>

        <div>
          <label>مجموع الساعات الإضافية</label>
          <input type="number" name="extra_hours_total" value="<?php echo old('extra_hours_total',0); ?>">
        </div>

        <div>
          <label>ساعات الاستعداد</label>
          <input type="number" name="standby_hours" value="<?php echo old('standby_hours',0); ?>">
        </div>

        <div>
          <label>مجموع ساعات العمل</label>
          <input type="number" name="total_work_hours" value="<?php echo old('total_work_hours',0); ?>">
        </div>

        <div class="full">
          <label>ملاحظات ساعات العمل</label>
          <textarea name="work_notes"><?php echo old('work_notes'); ?></textarea>
        </div>

        <div>
          <label>عطل HR</label>
          <input type="text" name="hr_fault" value="<?php echo old('hr_fault'); ?>">
        </div>

        <div>
          <label>عطل صيانة</label>
          <input type="text" name="maintenance_fault" value="<?php echo old('maintenance_fault'); ?>">
        </div>

        <div>
          <label>عطل تسويق</label>
          <input type="text" name="marketing_fault" value="<?php echo old('marketing_fault'); ?>">
        </div>

        <div>
          <label>عطل اعتماد</label>
          <input type="text" name="approval_fault" value="<?php echo old('approval_fault'); ?>">
        </div>

        <div>
          <label>ساعات أعطال أخرى</label>
          <input type="number" name="other_fault_hours" value="<?php echo old('other_fault_hours',0); ?>">
        </div>

        <div class="full">
          <label>ملاحظات ساعات الأعطال</label>
          <textarea name="fault_notes"><?php echo old('fault_notes'); ?></textarea>
        </div>

        <div>
          <label>عداد النهاية</label>
          <input type="number" name="counter_end" value="<?php echo old('counter_end',0); ?>">
        </div>

        <div>
          <label>فرق العداد</label>
          <input type="number" name="counter_diff" value="<?php echo old('counter_diff',0); ?>">
        </div>

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
          <p class="note">الحقول المعلّمة بـ * مطلوبة.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-12 mb-3">
  <label>⏱️ ساعات عمل المشغل</label>
  <input type="text" name="operator_hours" class="form-control" value="<?php echo old('operator_hours'); ?>">
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
  <label>⚙️ ساعات استعداد الآلية</label>
  <input type="text" name="machine_standby_hours" class="form-control" value="<?php echo old('machine_standby_hours'); ?>">
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
  <label>➕ الساعات الإضافية</label>
  <input type="text" name="extra_operator_hours" class="form-control" value="<?php echo old('extra_operator_hours'); ?>">
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
  <label>👷 ساعات استعداد المشغل</label>
  <input type="text" name="operator_standby_hours" class="form-control" value="<?php echo old('operator_standby_hours'); ?>">
</div>

<div class="col-12 mb-3">
  <label>📝 ملاحظات المشغل</label>
  <textarea name="operator_notes" class="form-control"><?php echo old('operator_notes'); ?></textarea>
</div>

      <div class="actions">
        <button type="submit" name="submit">💾 حفظ</button>
      </div>
    </form>
  </div>
<script>
    
    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }

</script>
</div>
</body>
</html>
