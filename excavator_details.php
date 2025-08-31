<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include "config.php";

// جلب السجل المطلوب
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM excavator WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        die("❌ لم يتم العثور على السجل");
    }
    $row = $result->fetch_assoc();
} else {
    die("❌ رقم السجل غير موجود");
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>📝 تقرير الحفار - <?php echo $row['machine_name']; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    body {font-family:'Cairo', sans-serif; background:#fff; padding:20px;}
    h2 {text-align:center; margin-bottom:20px;}
    .info-table {width:100%; border-collapse:collapse; margin-bottom:20px;}
    .info-table th, .info-table td {
        border:1px solid #ccc; padding:10px; text-align:right;
    }
    .info-table th {background:#f8f9fa;}
    .print-btn {
        display:inline-block; padding:10px 20px; background:#FFD700; 
        border-radius:6px; text-decoration:none; color:#000; font-weight:bold;
    }
    .section-title {margin:20px 0 10px; font-size:18px; color:#333; border-bottom:2px solid #FFD700; padding-bottom:5px;}
    @media print {
      .print-btn {display:none;}
    }
  </style>
</head>
<body>



<?php include 'sidebar.php'; ?>

  <div class="main" id="main">

  <h2>📝 تقرير تفصيلي لساعات عمل الحفار</h2>
  <a href="#" onclick="window.print()" class="print-btn">🖨️ طباعة</a>

  <div class="section-title">📌 بيانات أساسية</div>
  <table class="info-table">
    <tr><th>كود التكلفة</th><td><?php echo $row['cost_code']; ?></td></tr>
    <tr><th>المعدة</th><td><?php echo $row['machine_name']; ?></td></tr>
    <tr><th>المشروع</th><td><?php echo $row['project_name']; ?></td></tr>
    <tr><th>المالك</th><td><?php echo $row['owner_name']; ?></td></tr>
    <tr><th>السائق</th><td><?php echo $row['driver_name']; ?></td></tr>
    <tr><th>الوردية</th><td><?php echo $row['shift']; ?> (<?php echo $row['shift_hours']; ?> ساعات)</td></tr>
    <tr><th>تاريخ الإدخال</th><td><?php echo $row['created_at']; ?></td></tr>
  </table>

  <div class="section-title">⏱️ ساعات العمل</div>
  <table class="info-table">
    <tr><th>عداد البداية</th><td><?php echo $row['counter_start']; ?></td></tr>
    <tr><th>عداد النهاية</th><td><?php echo $row['counter_end']; ?></td></tr>
    <tr><th>فرق العداد</th><td><?php echo $row['counter_diff']; ?></td></tr>
    <tr><th>الساعات المنفذة</th><td><?php echo $row['executed_hours']; ?></td></tr>
    <tr><th>ساعات البكت</th><td><?php echo $row['bucket_hours']; ?></td></tr>
    <tr><th>ساعات الهامر</th><td><?php echo $row['jackhammer_hours']; ?></td></tr>
    <tr><th>الإضافي</th><td><?php echo $row['extra_hours']." (الإجمالي ".$row['extra_hours_total'].")"; ?></td></tr>
    <tr><th>ساعات الاستعداد</th><td><?php echo $row['standby_hours']; ?></td></tr>
    <tr><th>ساعات الاعتماد</th><td><?php echo $row['dependence_hours']; ?></td></tr>
    <tr><th>إجمالي ساعات العمل</th><td><?php echo $row['total_work_hours']; ?></td></tr>
  </table>

  <div class="section-title">⚠️ الأعطال</div>
  <table class="info-table">
    <tr><th>HR</th><td><?php echo $row['hr_fault']; ?></td></tr>
    <tr><th>الصيانة</th><td><?php echo $row['maintenance_fault']; ?></td></tr>
    <tr><th>التسويق</th><td><?php echo $row['marketing_fault']; ?></td></tr>
    <tr><th>الموافقات</th><td><?php echo $row['approval_fault']; ?></td></tr>
    <tr><th>أخرى</th><td><?php echo $row['other_fault_hours']; ?></td></tr>
    <tr><th>الإجمالي</th><td><?php echo $row['total_fault_hours']; ?></td></tr>
    <tr><th>ملاحظات</th><td><?php echo $row['fault_notes']; ?></td></tr>
    <tr><th>النوع</th><td><?php echo $row['fault_type']; ?></td></tr>
    <tr><th>القسم</th><td><?php echo $row['fault_department']; ?></td></tr>
    <tr><th>الجزء</th><td><?php echo $row['fault_part']; ?></td></tr>
    <tr><th>التفاصيل</th><td><?php echo $row['fault_details']; ?></td></tr>
  </table>

  <div class="section-title">👷 المشغل</div>
  <table class="info-table">
    <tr><th>ساعات المشغل</th><td><?php echo $row['operator_hours']; ?></td></tr>
    <tr><th>استعداد المعدة</th><td><?php echo $row['machine_standby_hours']; ?></td></tr>
    <tr><th>استعداد الهامر</th><td><?php echo $row['jackhammer_standby_hours']; ?></td></tr>
    <tr><th>استعداد البكت</th><td><?php echo $row['bucket_standby_hours']; ?></td></tr>
    <tr><th>إضافي مشغل</th><td><?php echo $row['extra_operator_hours']; ?></td></tr>
    <tr><th>استعداد المشغل</th><td><?php echo $row['operator_standby_hours']; ?></td></tr>
    <tr><th>ملاحظات المشغل</th><td><?php echo $row['operator_notes']; ?></td></tr>
  </table>

  <div class="section-title">📝 ملاحظات عامة</div>
  <p><?php echo nl2br($row['general_notes']); ?></p>
</div>


<script>
           function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }
</script>

</body>
</html>
