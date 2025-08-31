<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}
require_once 'config.php';

// دالة إدخال عامة
function insertData($table, $data) {
  global $conn;
  $columns = implode(", ", array_keys($data));
  $placeholders = implode(", ", array_fill(0, count($data), "?"));
  $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
  $stmt = $conn->prepare($sql);
  if (!$stmt) return false;
  $values = array_values($data);
  $types = str_repeat("s", count($values));
  $stmt->bind_param($types, ...$values);
  return $stmt->execute() ? $conn->insert_id : false;
}

// رسالة حفظ
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = $_POST;
  unset($data['submit']);
  $insertId = insertData("excavator", $data);
  $message = $insertId ? "<div class='success'>✅ تم الحفظ بنجاح</div>" : "<div class='error'>❌ فشل الحفظ</div>";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>🚜 إدخال بيانات الحفار</title>
<style>
  body{font-family:Tahoma,Arial;background:#f5f6fa;margin:0;padding:20px;}
  .box{max-width:900px;margin:auto;background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 6px #ccc;}
  h3{text-align:center;margin-bottom:20px}
  label{display:block;margin-top:10px;font-weight:bold}
  input,select,textarea{width:100%;padding:6px;margin-top:4px;border:1px solid #ccc;border-radius:4px}
  textarea{min-height:60px}
  button{margin-top:15px;width:100%;padding:12px;background:#ffc107;border:none;border-radius:6px;cursor:pointer;font-size:16px}
  .success{background:#d4edda;color:#155724;padding:10px;margin-bottom:10px;border-radius:6px}
  .error{background:#f8d7da;color:#721c24;padding:10px;margin-bottom:10px;border-radius:6px}
  .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
</style>
<script>
function validateForm(){
  const required = ["driver_name","machine_name","project_name","shift_hours"];
  for (let r of required){
    let el = document.forms["excavatorForm"][r];
    if (!el.value.trim()){
      alert("⚠️ برجاء إدخال: " + r);
      el.focus();
      return false;
    }
  }
  let numbers = document.querySelectorAll("input[type=number]");
  for (let n of numbers){
    if (n.value && n.value < 0){
      alert("⚠️ لا يمكن أن تكون القيمة سالبة: " + n.name);
      n.focus();
      return false;
    }
  }
  return true;
}
</script>
</head>
<body>
<div class="box">
  <h3>🚜 إدخال بيانات الحفار</h3>
  <?php if($message) echo $message; ?>
  <form method="POST" name="excavatorForm" onsubmit="return validateForm()">

    <div class="grid">
      <div><label>الكود</label><input type="text" name="cost_code"></div>
      <div><label>اسم الإدخال</label><input type="text" name="entry_name"></div>
      <div><label>اسم المعدة *</label><input type="text" name="machine_name" required></div>
      <div><label>المشروع *</label><input type="text" name="project_name" required></div>
      <div><label>المالك</label><input type="text" name="owner_name"></div>
      <div><label>اسم السائق *</label><input type="text" name="driver_name" required></div>
      <div><label>الوردية</label>
        <select name="shift">
          <option value="D">صباحية</option>
          <option value="N">مسائية</option>
        </select>
      </div>
      <div><label>ساعات الوردية *</label><input type="number" step="0.1" name="shift_hours" required></div>
      <div><label>عداد البداية</label><input type="number" name="counter_start"></div>
      <div><label>ساعات منفذة</label><input type="number" step="0.1" name="executed_hours"></div>
      <div><label>ساعات جردل</label><input type="number" step="0.1" name="bucket_hours"></div>
      <div><label>ساعات دكاك</label><input type="number" step="0.1" name="jackhammer_hours"></div>
      <div><label>ساعات إضافية</label><input type="number" step="0.1" name="extra_hours"></div>
      <div><label>إجمالي الإضافي</label><input type="number" step="0.1" name="extra_hours_total"></div>
      <div><label>ساعات استعداد</label><input type="number" step="0.1" name="standby_hours"></div>
      <div><label>ساعات اعتماد</label><input type="number" step="0.1" name="dependence_hours"></div>
      <div><label>إجمالي عمل</label><input type="number" step="0.1" name="total_work_hours"></div>
      <div><label>ملاحظات عمل</label><input type="text" name="work_notes"></div>
      <div><label>خطأ مشغل</label><input type="number" step="0.1" name="hr_fault"></div>
      <div><label>خطأ صيانة</label><input type="number" step="0.1" name="maintenance_fault"></div>
      <div><label>خطأ تسويق</label><input type="number" step="0.1" name="marketing_fault"></div>
      <div><label>خطأ موافقات</label><input type="number" step="0.1" name="approval_fault"></div>
      <div><label>ساعات خطأ أخرى</label><input type="number" step="0.1" name="other_fault_hours"></div>
      <div><label>إجمالي أخطاء</label><input type="number" step="0.1" name="total_fault_hours"></div>
      <div><label>ملاحظات الأخطاء</label><input type="text" name="fault_notes"></div>
      <div><label>عداد النهاية</label><input type="number" name="counter_end"></div>
      <div><label>فرق العداد</label><input type="number" step="0.1" name="counter_diff"></div>
      <div><label>نوع العطل</label><input type="text" name="fault_type"></div>
      <div><label>قسم العطل</label><input type="text" name="fault_department"></div>
      <div><label>جزء العطل</label><input type="text" name="fault_part"></div>
      <div><label>تفاصيل العطل</label><input type="text" name="fault_details"></div>
      <div><label>ملاحظات عامة</label><input type="text" name="general_notes"></div>
      <div><label>ساعات مشغل</label><input type="number" step="0.1" name="operator_hours"></div>
      <div><label>ساعات استعداد المعدة</label><input type="number" step="0.1" name="machine_standby_hours"></div>
      <div><label>ساعات استعداد دكاك</label><input type="number" step="0.1" name="jackhammer_standby_hours"></div>
      <div><label>ساعات استعداد جردل</label><input type="number" step="0.1" name="bucket_standby_hours"></div>
      <div><label>ساعات إضافية مشغل</label><input type="number" step="0.1" name="extra_operator_hours"></div>
      <div><label>ساعات استعداد مشغل</label><input type="number" step="0.1" name="operator_standby_hours"></div>
      <div><label>ملاحظات المشغل</label><input type="text" name="operator_notes"></div>
    </div>

    <button type="submit" name="submit">💾 حفظ</button>
  </form>
</div>
</body>
<script>
// ✅ دالة التحقق من صحة الإدخال
function validateForm(e) {
  let errors = [];

  // التحقق من الحقول المطلوبة
  let costCode = document.querySelector("select[name='cost_code']").value.trim();
  let driverName = document.querySelector("input[name='driver_name']").value.trim();
  let shift = document.querySelector("select[name='shift']").value.trim();

  if (costCode === "") errors.push("⚠️ برجاء اختيار المعدة.");
  if (driverName === "") errors.push("⚠️ برجاء إدخال اسم السائق.");
  if (shift === "") errors.push("⚠️ برجاء اختيار الوردية.");

  // التحقق من القيم الرقمية
  let executed = parseFloat(document.querySelector("input[name='executed_hours']").value) || 0;
  let extra = parseFloat(document.querySelector("input[name='extra_hours_total']").value) || 0;
  let shiftHours = parseFloat(document.querySelector("input[name='shift_hours']").value) || 0;

  if (executed < 0) errors.push("⚠️ الساعات المنفذة لا يمكن أن تكون سالبة.");
  if (extra < 0) errors.push("⚠️ الساعات الإضافية لا يمكن أن تكون سالبة.");

  // التأكد أن الساعات لا تتجاوز الوردية
  if ((executed + extra) > shiftHours) {
    errors.push("⚠️ مجموع الساعات المنفذة + الإضافية أكبر من ساعات الوردية.");
  }

  // التحقق من فرق العداد
  let diff = document.getElementById("counter_diff").value;
  if (isNaN(diff) || diff < 0) {
    errors.push("⚠️ فرق العداد غير صالح.");
  }

  // إظهار الأخطاء أو السماح بالإرسال
  if (errors.length > 0) {
    e.preventDefault(); // منع الإرسال
    alert(errors.join("\n"));
    return false;
  }
  return true;
}

// ربط الدالة بالـ submit
document.querySelector("form").addEventListener("submit", validateForm);
</script>

</html>
