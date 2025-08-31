<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include "config.php";

// =======================
// إحصائيات أساسية
// =======================
$stats = [
  "total_reports" => 0,
  "total_executed" => 0,
  "total_fault" => 0,
  "total_work" => 0
];

$sql = "SELECT 
          COUNT(*) as total_reports,
          SUM(executed_hours) as total_executed,
          SUM(total_fault_hours) as total_fault,
          SUM(total_work_hours) as total_work
        FROM excavator";
$res = $conn->query($sql);
if($res && $res->num_rows>0){
  $stats = $res->fetch_assoc();
}

// =======================
// المشاريع الأكثر ساعات عمل
// =======================
$projects = [];
$sql = "SELECT project_name, SUM(total_work_hours) as total_hours 
        FROM excavator 
        GROUP BY project_name 
        ORDER BY total_hours DESC LIMIT 5";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
  $projects[] = $row;
}

// =======================
// الأعطال حسب النوع
// =======================
$faultTypes = [];
$sql = "SELECT fault_type, COUNT(*) as count 
        FROM excavator 
        WHERE fault_type <> '' 
        GROUP BY fault_type";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
  $faultTypes[] = $row;
}

// =======================
// الأعطال حسب القسم
// =======================
$faultDepts = [];
$sql = "SELECT fault_department, COUNT(*) as count 
        FROM excavator 
        WHERE fault_department <> '' 
        GROUP BY fault_department";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
  $faultDepts[] = $row;
}

// =======================
// الشيفتات (نهار/ليل)
// =======================
$shifts = [];
$sql = "SELECT shift, COUNT(*) as count 
        FROM excavator 
        GROUP BY shift";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
  $shifts[] = $row;
}

// =======================
// عدد التقارير حسب الشهر
// =======================
$months = [];
$sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
        FROM excavator
        GROUP BY month ORDER BY month ASC";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
  $months[] = $row;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>📊 لوحة التحكم - تقارير الحفارات</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {font-family:'Cairo', sans-serif; background:#f8f9fa; margin:0; padding:20px;}
    h2 {text-align:center; margin-bottom:20px;}
    .cards {display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:15px; margin-bottom:20px;}
    .card {background:#fff; padding:20px; border-radius:12px; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,.1);}
    .card h3 {margin:10px 0; font-size:22px;}
    canvas {background:#fff; padding:15px; border-radius:12px; margin-bottom:20px; box-shadow:0 2px 6px rgba(0,0,0,.1);}
  </style>
</head>
<body>

<h2>📊 لوحة التحكم - إحصائيات تقارير الحفارات</h2>

<!-- Cards -->
<div class="cards">
  <div class="card"><h3><?php echo $stats['total_reports']; ?></h3><p>إجمالي التقارير</p></div>
  <div class="card"><h3><?php echo $stats['total_executed']; ?></h3><p>إجمالي الساعات المنفذة</p></div>
  <div class="card"><h3><?php echo $stats['total_work']; ?></h3><p>إجمالي ساعات العمل</p></div>
  <div class="card"><h3><?php echo $stats['total_fault']; ?></h3><p>إجمالي ساعات الأعطال</p></div>
</div>

<!-- Charts -->
<canvas id="projectsChart"></canvas>
<canvas id="faultTypesChart"></canvas>
<canvas id="faultDeptsChart"></canvas>
<canvas id="shiftsChart"></canvas>
<canvas id="monthsChart"></canvas>

<script>
// مشاريع الأكثر ساعات عمل
new Chart(document.getElementById('projectsChart'), {
  type: 'bar',
  data: {
    labels: <?php echo json_encode(array_column($projects,"project_name")); ?>,
    datasets: [{
      label: 'ساعات العمل',
      data: <?php echo json_encode(array_column($projects,"total_hours")); ?>,
      backgroundColor: 'rgba(54, 162, 235, 0.6)'
    }]
  }
});

// الأعطال حسب النوع
new Chart(document.getElementById('faultTypesChart'), {
  type: 'pie',
  data: {
    labels: <?php echo json_encode(array_column($faultTypes,"fault_type")); ?>,
    datasets: [{
      label: 'عدد الأعطال',
      data: <?php echo json_encode(array_column($faultTypes,"count")); ?>,
      backgroundColor: ['#FF6384','#36A2EB','#FFCE56','#8BC34A','#9C27B0']
    }]
  }
});

// الأعطال حسب القسم
new Chart(document.getElementById('faultDeptsChart'), {
  type: 'doughnut',
  data: {
    labels: <?php echo json_encode(array_column($faultDepts,"fault_department")); ?>,
    datasets: [{
      label: 'عدد الأعطال',
      data: <?php echo json_encode(array_column($faultDepts,"count")); ?>,
      backgroundColor: ['#FF9800','#4CAF50','#2196F3','#E91E63','#9C27B0']
    }]
  }
});

// الشيفتات
new Chart(document.getElementById('shiftsChart'), {
  type: 'pie',
  data: {
    labels: <?php echo json_encode(array_column($shifts,"shift")); ?>,
    datasets: [{
      label: 'عدد الشيفتات',
      data: <?php echo json_encode(array_column($shifts,"count")); ?>,
      backgroundColor: ['#03A9F4','#FFC107']
    }]
  }
});

// تقارير حسب الشهر
new Chart(document.getElementById('monthsChart'), {
  type: 'line',
  data: {
    labels: <?php echo json_encode(array_column($months,"month")); ?>,
    datasets: [{
      label: 'عدد التقارير',
      data: <?php echo json_encode(array_column($months,"count")); ?>,
      borderColor: 'rgba(75,192,192,1)',
      fill: false,
      tension: 0.3
    }]
  }
});
</script>

</body>
</html>
