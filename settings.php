<?php 
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إعدادات النظام | ايكوبيشن </title>

  <!-- خطوط وأيقونات -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>

  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: #f5f7fa;
    }
    .settings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
      margin-top: 2rem;
    }
    .setting-card {
      background: #fff;
      border-radius: 12px;
      padding: 25px 15px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
    }
    .setting-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .setting-card i {
      font-size: 2rem;
      margin-bottom: 12px;
      color: #CCAC00;
    }
    .setting-card h4 {
      margin: 0;
      font-size: 1.1rem;
      color: #333;
    }
    .setting-card a {
      display: block;
      margin-top: 8px;
      text-decoration: none;
      color: #CCAC00;
      font-weight: bold;
      transition: color 0.2s;
    }
    .setting-card a:hover {
      color: #aaAC00;
    }
  </style>
</head>
<body>

  <!-- القائمة الجانبية -->
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
      <div class="icons">⚙️ 👤</div>
    </div>

    <!-- محتوى الصفحة -->
    <div class="card" style="margin-top:2rem; padding:20px;">
      <h3 style="text-align:right; margin-bottom:1.5rem;">⚙️ إعدادات التايم شيت</h3>
      
      <div class="settings-grid">

        <div class="setting-card">
          <i class="fa-solid fa-cog"></i>
          <h4 style="color: red;">إدارة الماستر</h4>
          <a href="master.php">إدارة</a>
        </div>

         <div class="setting-card">
          <i class="fa-solid fa-users"></i>
          <h4 style="color: red;">إدارة المشرفين</h4>
          <a href="supervisors.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-user-tie"></i>
          <h4>إدارة الموردين</h4>
          <a href="owners.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-industry"></i>
          <h4>إدارة انواع المعدات</h4>
          <a href="equipment_types.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-tractor"></i>
          <h4>إدارة المعدات</h4>
          <a href="equipments.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-user-tie"></i>
          <h4>إدارة المشغلين</h4>
          <a href="#">إدارة</a>
        </div>


        <div class="setting-card">
          <i class="fa-solid fa-users"></i>
          <h4>إدارة المستخدمين</h4>
          <a href="supervisors.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-chart-line"></i>
          <h4 style="color: red;">إدارة المشاريع</h4>
          <a href="projects.php">إدارة</a>
        </div>



        <!-- <div class="setting-card">
          <i class="fa-solid fa-percent"></i>
          <h4>تغيير نسبة الضريبة</h4>
          <a href="tax_settings.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-database"></i>
          <h4>النسخ الاحتياطي</h4>
          <a href="backup.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-chart-line"></i>
          <h4>تحديد سقف المعاملات</h4>
          <a href="limits.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-user-shield"></i>
          <h4>صلاحيات النظام</h4>
          <a href="roles.php">إدارة</a>
        </div>

        <div class="setting-card">
          <i class="fa-solid fa-bolt"></i>
          <h4>سجلات النظام</h4>
          <a href="system_logs.php">إدارة</a>
        </div> -->

      </div>
    </div>
  </div>

  <script>
    function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }
  </script>
</body>
</html>
