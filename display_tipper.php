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
    $sql = "SELECT id, project_name, owner_name, driver_name, shift, shift_hours, executed_hours, extra_hours_total, standby_hours, dependence_hours, total_work_hours, total_fault_hours, created_at 
            FROM tipper ORDER BY created_at DESC";
}else{ 
    $sql = "SELECT id, project_name, owner_name, driver_name, shift, shift_hours, executed_hours, extra_hours_total, standby_hours, dependence_hours, total_work_hours, total_fault_hours, created_at 
            FROM tipper WHERE entry_name = '$username' ORDER BY created_at DESC";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🚛 ملخص تقارير القلابات</title>
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
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <div class="main full" id="main">
    <h2>🚛 ملخص تقارير القلابات</h2>

    <div style="overflow-x:auto;">
      <table id="tipperTable" class="display nowrap" style="width:100%">
        <thead>
          <tr>
            <th>#</th>
            <th>🏗️ المشروع</th>
            <th>👷‍♂️ المالك</th>
            <th>🚜 السائق</th>
            <th>📅 التاريخ</th>
            <th>👷‍♂️ الشيفت</th>
            <th>⏱️ ساعات الشيفت</th>
            <th>✅ ساعات التنفيذ</th>
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
                    <td>".$row['driver_name']."</td>
                    <td>".$row['created_at']."</td>
                    <td>".$row['shift']."</td>
                    <td>".$row['shift_hours']."</td>
                    <td>".$row['executed_hours']."</td>
                    <td>
                      <a href='tipper_details.php?id=".$row['id']."' target='_blank'>
                        <button class='btn btn-details'>عرض</button>
                      </a>
                      <a href='delete_tipper.php?id=".$row['id']."' onclick=\"return confirm('هل أنت متأكد من الحذف؟');\">
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
      $('#tipperTable').DataTable({
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
