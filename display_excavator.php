<?php 
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include "config.php";

// فلترة حسب الصلاحية (Admin يشوف الكل / مستخدم يشوف إدخالاته فقط)
$username = $_SESSION['username'];
if($_SESSION['role'] == "admin"){ 
    $sql = "SELECT id, created_at, shift, project_name, standby_hours, dependence_hours, total_work_hours, total_fault_hours , owner_name ,executed_hours
            FROM excavator ORDER BY created_at DESC";
}else{ 
    $sql = "SELECT id, created_at, shift, project_name, standby_hours, dependence_hours, total_work_hours, total_fault_hours , owner_name ,executed_hours 
            FROM excavator WHERE entry_name = '$username' ORDER BY created_at DESC";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>📋 ملخص تقارير الحفارات</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    body {font-family:'Cairo', sans-serif; background:#f8f9fa; margin:0;}
    .main {padding:20px;}
    h2 {text-align:center; margin-bottom:20px;}
    .btn {padding:5px 10px; border:none; border-radius:5px; cursor:pointer;}
    .btn-details {background:#007bff; color:#fff;}
    .btn-delete {background:#dc3545; color:#fff;}
    .report-card{
      width: 20%;
      padding: 10px;
      margin : 10px;
      float : right;
      background-color : #fff;

    }
    @media (max-width: 600px) {
      .report-card{
        width: 100%;
      }
    }
  </style>
</head>
<body>


<?php
$stats = [
  "executed_today" => 0,
  "fault_today" => 0,
  "standby_today" => 0,
  "extra_today" => 0,
  "machines_today" => 0,
];

// فلترة الشرط حسب المستخدم
$whereUser = ($_SESSION['role'] == "admin") 
    ? "" 
    : " AND entry_name = '".$conn->real_escape_string($username)."' ";

// ============ إحصائيات يومية ============

// ساعات العمل اليوم
$sql = "SELECT SUM(executed_hours) as total 
        FROM excavator 
        WHERE DATE(created_at) = CURDATE() $whereUser";
$res = $conn->query($sql);
if($res && $row = $res->fetch_assoc()){ $stats['executed_today'] = $row['total'] ?: 0; }

// ساعات الأعطال اليوم
$sql = "SELECT SUM(total_fault_hours) as total 
        FROM excavator 
        WHERE DATE(created_at) = CURDATE() $whereUser";
$res = $conn->query($sql);
if($res && $row = $res->fetch_assoc()){ $stats['fault_today'] = $row['total'] ?: 0; }

// ساعات الاستعداد اليوم
$sql = "SELECT SUM(standby_hours) as total 
        FROM excavator 
        WHERE DATE(created_at) = CURDATE() $whereUser";
$res = $conn->query($sql);
if($res && $row = $res->fetch_assoc()){ $stats['standby_today'] = $row['total'] ?: 0; }

// عدد المعدات التي عملت اليوم
$sql = "SELECT COUNT(DISTINCT machine_name) as total 
        FROM excavator 
        WHERE DATE(created_at) = CURDATE() 
          AND executed_hours > 0 $whereUser";
$res = $conn->query($sql);
if($res && $row = $res->fetch_assoc()){ 
    $stats['machines_today'] = $row['total'] ?: 0; 
}
?>

  <?php include 'sidebar.php'; ?>
  <div class="main full" id="main">
    <h2>📋 ملخص تقارير الحفارات</h2>

<!-- احصائيات اليوم -->
<div class="report-card">⏱️ ساعات العمل اليوم<hr><?php echo $stats['executed_today']; ?> ساعة</div>
<div class="report-card">🚨 ساعات الأعطال اليوم<hr><?php echo $stats['fault_today']; ?> ساعة</div>
<div class="report-card">⏳ ساعات الاستعداد اليوم (العميل) <hr><?php echo $stats['standby_today']; ?> ساعة</div>
<div class="report-card">
    🛠️ عدد المعدات التي عملت اليوم
    <hr>
    <?php echo $stats['machines_today']; ?>
</div>


    <div style="overflow-x:auto;clear:both">
      <table id="excavatorTable" class="display nowrap" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>🏗️ المشروع</th>
            <th>👷‍♂️ المالك</th>
            <th>📅 التاريخ</th>
            <th>👷‍♂️ الشيفت</th>
            <th>⚡ الاستعداد</th>
            <th>✅ الاعتماد</th>
            <th>⏱️ ساعات العمل</th>
            <th>🚨 مجموع ساعات الأعطال</th>
            <th>الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if($result && $result->num_rows > 0){
              while($row = $result->fetch_assoc()){
                  echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['project_name']."</td>
                    <td>".$row['owner_name']."</td>
                    <td>".$row['created_at']."</td>
                    <td>".$row['shift']."</td>
                    <td>".$row['standby_hours']."</td>
                    <td>".$row['dependence_hours']."</td>
                    <td>".$row['executed_hours']."</td>
                    <td>".$row['total_fault_hours']."</td>
                    <td>
                      <a href='excavator_details.php?id=".$row['id']."' target='_blank'>
                        <button class='btn btn-details'>عرض</button>
                      </a>
                      <a href='delete.php?id=".$row['id']."' onclick=\"return confirm('هل أنت متأكد من الحذف؟');\">
                        <button class='btn btn-delete'>حذف</button>
                      </a>
                    </td>
                  </tr>";
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- مكتبات DataTables -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
   $(document).ready(function () {
      $('#excavatorTable').DataTable({
        responsive: true,
        scrollX: true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
        },
        "order": [[0, "desc"]]
      });
    });
  </script>
</body>
</html>
