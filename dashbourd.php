<?php 
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); 
    exit;
}
    include 'config.php';
    // اجلب عدد المعدات
$result = $conn->query("SELECT COUNT(*) AS total FROM equipments");
$row = $result->fetch_assoc();
$total_equipment = $row['total'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة الإحصائيات | شركة دهب</title>

  <!-- خطوط وأيقونات -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1rem;
      margin-top: 2rem;
    }
    .card {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }
    .card h3 {
      margin-bottom: 0.5rem;
      font-size: 1.2rem;
      color: #444;
    }
    .card p {
      font-size: 1.5rem;
      font-weight: bold;
      color: #555555;
    }
    .section-title {
      margin-top: 2rem;
      margin-bottom: 1rem;
      font-size: 1.3rem;
      font-weight: bold;
      color: #333;
    }
  </style>
</head>
<body>

  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>

  <div class="main full" id="main">
    <!-- الشريط العلوي -->
    <div class="topbar">
     <span class="menu-btn" onclick="toggleSidebar()">☰</span>
     مرحبا بك : <?php echo $_SESSION['name']; ?> 
     <div class="icons">📊 👤</div>
    </div>

    <!-- الكروت الأساسية -->
    <div class="cards">
      <div class="card"><h3>عدد المعدات</h3><p><?php echo $total_equipment; ?></p></div>
      <div class="card"><h3>إجمالي ساعات العمل</h3><p> 0 ⏱</p></div>
      <div class="card"><h3>إجمالي الإنتاج</h3><p> 0 🚜</p></div>
      <div class="card"><h3>إجمالي الكيلومترات</h3><p> 0 كم</p></div>
    </div>

  </div>

  <!-- مكتبات جافاسكربت -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }
  </script>
</body>
</html>
