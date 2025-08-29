<?php
session_start();
include 'config.php'; // الاتصال بقاعدة البيانات

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // تنظيف المدخلات
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // استخدام Prepared Statement ضد SQL Injection
    $stmt = $conn->prepare("SELECT id, username, name, password, role FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // مقارنة كلمة المرور (بدون تشفير)
        if ($password === $user['password']) {
            // إنشاء جلسة آمنة
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name']     = $user['name'];
            $_SESSION['role']     = $user['role'];

            header("Location: dashbourd.php");
            exit;
        } else {
            $error = "❌ كلمة المرور غير صحيحة.";
        }
    } else {
        $error = "❌ اسم المستخدم غير موجود.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> نظام التايم شيت </title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background: linear-gradient(135deg, #FFD700, #0E0F12);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      width: 100%;
      max-width: 400px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0px 4px 20px rgba(0,0,0,0.2);
      padding: 30px;
    }
    .login-card h3 {
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h3> 📑 نظام التايم شيت</h3>
    <h5> 🔐 تسجيل الدخول </h5>
    
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">اسم المستخدم</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label">كلمة المرور</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button style="background-color: gold;color: #333;" type="submit" class="btn btn-primary w-100">دخول</button>
    </form>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
