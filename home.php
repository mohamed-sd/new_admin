<?php 
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include "config.php";

// اسم المستخدم
$username = $_SESSION['username'];

// فلترة البيانات (Admin يشوف الكل، غيره يشوف شغله فقط)
if($_SESSION['role'] == "admin"){ 
  $sql = "SELECT * FROM operations";
}else{ 
  $sql = "SELECT * FROM operations WHERE entry_name = '$username' ";
}

$result = $conn->query($sql);

// إحصائيات اليوم
$total_hours = 0;
$down_hours  = 0;
$executed_hours = 0;
$excavators = 0;
$dumpers = 0;

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $total_hours += $row["today_hours"];
        $down_hours  += isset($row["down_hours"]) ? $row["down_hours"] : 0; 
        $executed_hours += isset($row["executed_hours"]) ? $row["executed_hours"] : $row["today_hours"]; 

        if(strpos($row["equipment_name"], "حفار") !== false){ $excavators++; }
        if(strpos($row["equipment_name"], "قلاب") !== false){ $dumpers++; }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم | شركة دهب</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    body {font-family:'Cairo', sans-serif; margin:0; background:#f8f9fa;}
    .main {padding:20px;}
    .cards {display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:15px; margin-bottom:2rem;}
    .card {background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); text-align:center;}
    .card h3 {margin:0; font-size:18px; color:#333;}
    .card p {margin:10px 0 0; font-size:20px; font-weight:bold; color:#FFD700;}
    .two-cards {display:grid; grid-template-columns:1fr 1fr; gap:20px; max-width:800px; margin:auto;}
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <div id="main" class="main full">

    <!-- الشريط العلوي -->
    <div class="topbar">
     <span class="menu-btn" onclick="toggleSidebar()">☰</span>
     مرحبا بك : <?php echo $_SESSION['name']; ?> 
    </div>

    <!-- عنوان -->
    <h2 style="text-align:center; margin:20px 0;">📊 التايم شيت (إحصائيات اليوم)</h2>

    <!-- كروت الإحصائيات -->
    <div class="cards">
      <div class="card"><h3>⏱️ إجمالي الساعات</h3><p><?php echo $total_hours; ?></p></div>
      <div class="card"><h3>⚠️ ساعات التعطل</h3><p><?php echo $down_hours; ?></p></div>
      <div class="card"><h3>✅ الساعات المنفذة</h3><p><?php echo $executed_hours; ?></p></div>
      <div class="card"><h3>🛠 عدد المعدات</h3><p><?php echo $excavators + $dumpers; ?></p></div>
    </div>

    <!-- كاردين المعدات -->
    <div class="two-cards">
      <a href="display_excavator.php"><div class="card">
        <h3>🚜 الحفارات</h3>
        <!-- <p><?php echo $excavators; ?> معدة</p> -->
      </div></a>
      <a href="display_tipper.php"><div class="card">
        <h3>🚚 القلابات</h3>
        <!-- <p><?php echo $dumpers; ?> معدة</p> -->
      </div></a>
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
