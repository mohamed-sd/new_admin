<?php 
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم | شركة دهب</title>

  <!-- خطوط وأيقونات -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>

  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- المحتوى الرئيسي -->
  <div class="main" id="main">
    <!-- الشريط العلوي -->
    <div class="topbar">
     <span class="menu-btn" onclick="toggleSidebar()">☰</span>
     مرحبا بك : <?php echo $_SESSION['name']; ?> 
      <div class="search">
        <input type="text" placeholder="🔍 بحث...">
      </div>
      <div class="icons">🔔 👤</div>
    </div>

    <?php

    include "config.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // تأمين المدخلات

    $sql = "DELETE FROM operations WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // بعد الحذف يرجع للصفحة الرئيسية
        echo "<script>
        alert('تم الحذف بنجاح ✅');
        window.location.href='dashbourd.php';
      </script>";
        exit;
    } else {
        echo "خطأ في الحذف: " . $conn->error;
    }
} else {
  //  echo "معرّف السجل غير موجود.";
}

    ?>

    <!-- الكروت -->
    <!-- <div class="cards">
      <div class="card"><h3>📁 المشاريع</h3><p>15</p></div>
      <div class="card"><h3>📑 العقود</h3><p>8</p></div>
      <div class="card"><h3>⛽ استهلاك الوقود</h3><p>1200 لتر</p></div>
      <div class="card"><h3>🛠 الأعطال</h3><p>3</p></div>
    </div> -->

    <!-- الجدول -->
    <div class="card" style="margin-top:2rem; overflow-x:auto;">
      <h3 style="text-align:right; margin-bottom:1rem;">📊 بيانات التايم شييت</h3>
      <table id="dataTable" class="display nowrap" style="width:100%">
        <thead>
          <tr>
            <th>رقم</th>
            <th>اسم المدخل</th>
            <th>اسم المعدة</th>
            <th> الوردية </th>
            <th> عدد ساعات العمل </th>
            <th> المشروع </th>
            <th>  تسمية العميل </th>
            <th> العمليات</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include "config.php"; 
            $username = $_SESSION['username'];
            if($_SESSION['role'] == "admin"){ // if manager show all data
            $sql = "SELECT * FROM `operations`";
            }else{ // if user show just thier data  
            $sql = "SELECT * FROM `operations` where entry_name = '$username' ";
            }
            


            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr>
                  <td>".$row["id"]."</td>
                  <td>".$row["entry_name"]."</td>
                  <td>".$row["equipment_name"]."</td>
                  <td>".$row["shift"]."</td>
                  <td>".$row["today_hours"]."</td>
                  <td>".$row["project_name"]."</td>
                  <td>".$row["client_name"]."</td>
                  <td><a href='details.php?id=".$row["id"]."' style='color:#FFD700; font-weight:bold;'>عرض</a> | 
                   <a href='dashbourd.php?id=".$row["id"]."' 
                   onclick=\"return confirm('هل أنت متأكد من الحذف؟');\" 
                   style='color:red; font-weight:bold;'>
                   🗑️ حذف
                </a></td>
                </tr>";
              }
            }
          ?>
        </tbody>
      </table>
      <br>
      <a href="export.php" class="btn-export" style="background:#FFD700; padding:10px 20px; border-radius:8px; text-decoration:none; color:#000; font-weight:bold;">
        ⬇️ تحميل إكسل كامل
      </a>
    </div>
  </div>

  <!-- مكتبات جافاسكربت -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

  <script>
   $(document).ready(function () {
  $('#dataTable').DataTable({
    responsive: true,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
    },
    "order": [[0, "desc"]] // ترتيب العمود الأول (id) تنازلياً
  });
});

    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }
  </script>
</body>
</html>
