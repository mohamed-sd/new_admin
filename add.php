<?php
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
    exit;
}
include 'config.php';
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>إضافة بيانات</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    body {
      background: #f7f9fc;
      font-family: 'Tahoma', sans-serif;
    }
    .container {
      max-width: 100%;
      margin-top: 30px;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-primary {
      border-radius: 10px;
      padding: 10px;
      font-size: 18px;
    }
  </style>
</head>
<body>

  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>


    <!-- المحتوى الرئيسي -->
  <div class="main full" id="main">


  <div class="topbar">
  <span class="menu-btn" onclick="toggleSidebar()">☰</span>
  اضافة تايم شيت جديد
  <div class="icons"> 📑 </div>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $stmt = $conn->prepare("INSERT INTO operations (
        entry_name , entry_date, equipment_name, equipment_type, ownership_type, owner_name, plate_no, client_name, project_name, site_name, shift, today_hours, work_hours, standby_hours, overtime_hours, total_work_hours, 
        hr_fault, maintenance_fault, excavator_fault, other_hours, total_downtime_hours,
        trips_count, load_weight, total_weight, start_meter, end_meter, total_km, fuel_consumption, avg_consumption, fault_type, fault_section, faulty_part, fault_details, notes
    ) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
    // ✅ 33 علامة استفهام

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssssss",
        $_POST['entry_name'],
        $_POST['entry_date'],
        $_POST['equipment_name'], 
        $_POST['equipment_type'], 
        $_POST['ownership_type'],
        $_POST['owner_name'], 
        $_POST['plate_no'], 
        $_POST['client_name'], 
        $_POST['project_name'],
        $_POST['site_name'], 
        $_POST['shift'], 
        $_POST['today_hours'], 
        $_POST['work_hours'],
        $_POST['standby_hours'], 
        $_POST['overtime_hours'], 
        $_POST['total_work_hours'],
        $_POST['hr_fault'], 
        $_POST['maintenance_fault'], 
        $_POST['excavator_fault'],
        $_POST['other_hours'],
        $_POST['total_downtime_hours'],
        $_POST['trips_count'], 
        $_POST['load_weight'], 
        $_POST['total_weight'], 
        $_POST['start_meter'],
        $_POST['end_meter'], 
        $_POST['total_km'], 
        $_POST['fuel_consumption'], 
        $_POST['avg_consumption'],
        $_POST['fault_type'], 
        $_POST['fault_section'], 
        $_POST['faulty_part'],
        $_POST['fault_details'], 
        $_POST['notes']
    );

    if ($stmt->execute()) {
        $msg = "✅ تم ارسال التايم شييت بنجاح";
    } else {
        $msg = "❌ خطأ: " . $stmt->error;
    }
}
?>

<div class="container">
  <div class="card p-4">
    <h3 class="mb-4 text-center">📋 إضافة بيانات المعدة</h3>
    <?php if (!empty($msg)) { ?>
      <div class="alert alert-info"><?= $msg ?></div>
    <?php } ?>
    <form method="POST">
      <div class="row">

                <?php
include 'config.php';
$user = $_SESSION['user_id'];
$machines = $conn->query("SELECT id, plant_no, contract_type, yom, plate_no, supplier_code, owner, owner_toc, contact_no, project_name FROM master WHERE `status` LIKE '1' and  user LIKE '$user' ");
?>
<div class="col-lg-4 col-md-6 col-12 mb-3">
<div class="form-group">
  <label>⚙️ اسم المعدة / Cost Code</label>
  <select name="cost_code" id="cost_code" class="form-control" onchange="loadMachineData()">
    <option value="">-- اختر المعدة --</option>
    <?php while($m = $machines->fetch_assoc()): ?>
      <option value="<?php echo $m['id']; ?>">
        <?php echo $m['plant_no']; ?>
      </option>
    <?php endwhile; ?>
  </select>
</div>
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
<div class="mb-3">
  <label class="form-label">📅 التاريخ</label>
  <input type="date" name="entry_date" class="form-control" required>
</div>
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
  <div class="mb-3">
  <label class="form-label">👤 اسم مدخل البيانات / Data Entry Name</label>
  <input class="form-control" type="text" name="entry_name" value="<?php echo $_SESSION['username']; ?>"/>
</div>
</div>

      <?php
      $fields = [
  "equipment_name" => "إسم المعدة",
  "equipment_type" => "نوع المعدة",
  "ownership_type" => "نوع الملكية",
  "owner_name" => "اسم المالك",
  "plate_no" => "رقم اللوحة",
  "client_name" => "تسمية العميل",
  "project_name" => "اسم المشروع",
  "site_name" => "اسم الموقع",
  "shift" => "الوردية",
  "today_hours" => "ساعات اليوم",
  "work_hours" => "ساعات العمل",
  "standby_hours" => "ساعات الاستعداد",
  "overtime_hours" => "الساعات الاضافية",
  "total_work_hours" => "مجموع ساعات العمل",
  "hr_fault" => "عطل HR",
  "maintenance_fault" => "عطل صيانة",
  "excavator_fault" => "عطل حفار",
  "other_hours" => "ساعات أخرى",
  "total_downtime_hours" => "مجموع ساعات التعطل",
  "trips_count" => "عدد النقلات",
  "load_weight" => "وزن الحمولة",
  "total_weight" => "الوزن الكلى",
  "start_meter" => "عداد البداية",
  "end_meter" => "عداد النهاية",
  "total_km" => "مجموع الكيلومترات",
  "fuel_consumption" => "استهلاك الوقود",
  "avg_consumption" => "متوسط الاستهلاك",
  "fault_type" => "نوع العطل",
  "fault_section" => "قسم العطل",
  "faulty_part" => "الجزء المعطل",
  "fault_details" => "تفاصيل العطل",
  "notes" => "ملاحظات"
];
foreach ($fields as $name => $label) {
    if ($name == "shift") {
        // ✅ Dropdown خاص بالوردية
        echo '<div class="col-lg-3 col-md-6 col-12 mb-3">
                <label class="form-label">'.$label.'</label>
                <select name="shift" class="form-control" required>
                    <option value="">-- اختر الوردية --</option>
                    <option value="D">صباحية</option>
                    <option value="N">مسائية</option>
                </select>
              </div>';
    } else {
        // ✅ باقي الحقول Input Text
        echo '<div class="col-lg-3 col-md-6 col-12 mb-3">
                <label class="form-label">'.$label.'</label>
                <input type="text" name="'.$name.'" class="form-control">
              </div>';
    }
}
      ?>

      <button type="submit" class="btn btn-warning w-100"> ➡️ ارسال</button>
    </div>
    </form>
  </div>
</div>

</div>

<script>
         function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }

function loadMachineData() {
  let id = document.getElementById("cost_code").value;
  if(id === "") return;

  fetch("get_machine.php?id=" + id)
    .then(res => res.json())
    .then(data => {
      if(data){
        document.querySelector("input[name='equipment_name']").value = data.plant_no || "";
        document.querySelector("input[name='equipment_type']").value = data.type || "";
        document.querySelector("input[name='plate_no']").value = data.plate_no || "";
        document.querySelector("input[name='owner_name']").value = data.owner || "";
        document.querySelector("input[name='ownership_type']").value = data.contract_type || "";
        document.querySelector("input[name='client_name']").value = data.supplier_code || "";
        document.querySelector("input[name='project_name']").value = data.project_name || "";
        document.querySelector("input[name='today_hours']").value = data.hours || "";
      }
    })
    .catch(err => console.error("خطأ في جلب البيانات:", err));
}
function calculateTotals(){
  let work = parseFloat(document.querySelector("input[name='work_hours']").value) || 0;
  let standby = parseFloat(document.querySelector("input[name='standby_hours']").value) || 0;
  let overtime = parseFloat(document.querySelector("input[name='overtime_hours']").value) || 0;
  let trips = parseFloat(document.querySelector("input[name='trips_count']").value) || 0;
  let loadWeight = parseFloat(document.querySelector("input[name='load_weight']").value) || 0;
  let startMeter = parseFloat(document.querySelector("input[name='start_meter']").value) || 0;
  let endMeter = parseFloat(document.querySelector("input[name='end_meter']").value) || 0;

  // مجموع ساعات العمل
  let totalWork = work + standby + overtime;
  document.querySelector("input[name='total_work_hours']").value = totalWork;

  // الوزن الكلي
  let totalWeight = trips * loadWeight;
  document.querySelector("input[name='total_weight']").value = totalWeight;

  // مجموع الكيلومترات
  let totalKm = endMeter - startMeter;
  document.querySelector("input[name='total_km']").value = totalKm >= 0 ? totalKm : 0;
}

// ربط الدوال بالحقول عند التغيير
document.addEventListener("DOMContentLoaded", function(){
  let fields = ["work_hours","standby_hours","overtime_hours","trips_count","load_weight","start_meter","end_meter"];
  fields.forEach(f=>{
    document.querySelector("input[name='"+f+"']").addEventListener("input", calculateTotals);
  });
});
</script>
</body>
</html>
