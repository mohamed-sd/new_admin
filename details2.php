<?php
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
    exit;
}
include 'config.php';

// جلب الـ id من الرابط
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM operations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("❌ لا يوجد بيانات لهذا الرقم");
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تقرير معدة</title>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
    body {
      font-family: "Tahoma", Arial, sans-serif;
      direction: rtl;
      background: #fff;
      margin: 40px;
    }
    .report {
      width: 100%;
      border: 2px solid #000;
      padding: 20px;
      box-sizing: border-box;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      text-decoration: underline;
    }
    .field {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #333;
      padding: 6px 0;
      font-size: 15px;
    }
    .field span {
      font-weight: bold;
      color: #000;
    }
    .print-btn {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      width: 120px;
      text-align: center;
    }
    .print-btn:hover { background: #0056b3; }
    @media print {
      .print-btn { display: none; }
      body { margin: 0; }
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
  
  <div class="icons"> 📑 </div>
</div>

<div class="report">
  <h2>تقرير معدة</h2>

  <div class="field"><span>🆔 رقم السجل:</span> <?= htmlspecialchars($data['id']) ?></div>
  <div class="field"><span>👨‍💼 مدخل البيانات:</span> <?= htmlspecialchars($data['entry_name']) ?></div>
  <div class="field"><span>📅 التاريخ:</span> <?= htmlspecialchars($data['entry_date']) ?></div>
  <div class="field"><span>🔧 اسم المعدة:</span> <?= htmlspecialchars($data['equipment_name']) ?></div>
  <div class="field"><span>⚙️ نوع المعدة:</span> <?= htmlspecialchars($data['equipment_type']) ?></div>
  <div class="field"><span>🏷️ نوع الملكية:</span> <?= htmlspecialchars($data['ownership_type']) ?></div>
  <div class="field"><span>👤 المالك:</span> <?= htmlspecialchars($data['owner_name']) ?></div>
  <div class="field"><span>🚜 رقم اللوحة:</span> <?= htmlspecialchars($data['plate_no']) ?></div>
  <div class="field"><span>🧑‍💼 العميل:</span> <?= htmlspecialchars($data['client_name']) ?></div>
  <div class="field"><span>🏗️ المشروع:</span> <?= htmlspecialchars($data['project_name']) ?></div>
  <div class="field"><span>📍 الموقع:</span> <?= htmlspecialchars($data['site_name']) ?></div>
  <div class="field"><span>🌙 الوردية:</span> <?= htmlspecialchars($data['shift']) ?></div>
  <div class="field"><span>⏱️ ساعات اليوم:</span> <?= htmlspecialchars($data['today_hours']) ?></div>
  <div class="field"><span>🛠️ ساعات العمل:</span> <?= htmlspecialchars($data['work_hours']) ?></div>
  <div class="field"><span>⏸️ ساعات التوقف:</span> <?= htmlspecialchars($data['standby_hours']) ?></div>
  <div class="field"><span>➕ ساعات إضافية:</span> <?= htmlspecialchars($data['overtime_hours']) ?></div>
  <div class="field"><span>📊 إجمالي الساعات:</span> <?= htmlspecialchars($data['total_work_hours']) ?></div>
  <div class="field"><span>🚚 عدد النقلات:</span> <?= htmlspecialchars($data['trips_count']) ?></div>
  <div class="field"><span>⚖️ الحمولة:</span> <?= htmlspecialchars($data['load_weight']) ?></div>
  <div class="field"><span>📦 إجمالي الوزن:</span> <?= htmlspecialchars($data['total_weight']) ?></div>
  <div class="field"><span>🔢 عداد البداية:</span> <?= htmlspecialchars($data['start_meter']) ?></div>
  <div class="field"><span>🔢 عداد النهاية:</span> <?= htmlspecialchars($data['end_meter']) ?></div>
  <div class="field"><span>📏 المسافة:</span> <?= htmlspecialchars($data['total_km']) ?></div>
  <div class="field"><span>⛽ الوقود:</span> <?= htmlspecialchars($data['fuel_consumption']) ?></div>
  <div class="field"><span>📉 معدل الاستهلاك:</span> <?= htmlspecialchars($data['avg_consumption']) ?></div>
  <div class="field"><span>❗ نوع العطل:</span> <?= htmlspecialchars($data['fault_type']) ?></div>
  <div class="field"><span>📂 القسم:</span> <?= htmlspecialchars($data['fault_section']) ?></div>
  <div class="field"><span>🔩 الجزء:</span> <?= htmlspecialchars($data['faulty_part']) ?></div>
  <div class="field"><span>📝 تفاصيل العطل:</span> <?= htmlspecialchars($data['fault_details']) ?></div>
  <div class="field"><span>📒 ملاحظات:</span> <?= htmlspecialchars($data['notes']) ?></div>
</div>
<a href="#" onclick="window.print()" class="print-btn">🖨️ طباعة</a>
</body>

</body>
</html>
