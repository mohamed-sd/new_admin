<?php
session_start();
// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
    exit;
}
include 'config.php'; // الاتصال بقاعدة البيانات

// معالجة الإضافة
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $name     = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password']; // يفضل تشفيره لاحقاً
    $phone    = $_POST['phone'];
    $role     = $_POST['role']; // إضافة الدور

    $sql = "INSERT INTO users (name, username, password, phone, role, created_at, updated_at) 
            VALUES ('$name', '$username', '$password', '$phone', '$role', NOW(), NOW())";
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: supervisors.php"); // تحديث الصفحة بعد الحذف
    exit;
}

// التعديل
if (isset($_POST['update'])) {
    $id       = intval($_POST['edit_id']);
    $name     = $_POST['edit_name'];
    $username = $_POST['edit_username'];
    $phone    = $_POST['edit_phone'];
    $role     = $_POST['edit_role'];

    if (!empty($_POST['edit_password'])) {
        $password = $_POST['edit_password'];
        $conn->query("UPDATE users 
                      SET name='$name', username='$username', phone='$phone', role='$role', password='$password', updated_at=NOW() 
                      WHERE id=$id");
    } else {
        $conn->query("UPDATE users 
                      SET name='$name', username='$username', phone='$phone', role='$role', updated_at=NOW() 
                      WHERE id=$id");
    }
    header("Location: supervisors.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم | المستخدمين </title>
  <!-- خطوط وأيقونات -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

  
  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- المحتوى الرئيسي -->
  <div class="main full" id="main">
    <!-- الشريط العلوي -->
    <div class="topbar">
     <span class="menu-btn" onclick="toggleSidebar()">☰</span>
      <h2>إدارة المستخدمين</h2>
      <div class="icons"> 👤</div>
    </div>

    <!-- زر إظهار / إخفاء الفورم -->
<div class="text-end m-3">
  <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#addUserForm" aria-expanded="false" aria-controls="addUserForm">
    ➕ إضافة مستخدم
  </button>
</div>

<!-- فورم إضافة المستخدم -->
<div class="collapse" id="addUserForm">
  <div class="card shadow-sm border-0 m-3">
    <div class="card-body">
      <h5 class="card-title mb-3">إضافة مستخدم جديد</h5>
      <form method="POST" action="">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">الاسم الكامل</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">اسم المستخدم</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="col-md-6">
  <label class="form-label">الدور / الصلاحية</label>
  <select name="role" class="form-control" required>
    <option value="admin">مدير (Admin)</option>
    <option value="user">مشرف (User)</option>
  </select>
</div>
        </div>
        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-success px-4">💾 حفظ</button>
        </div>
      </form>
    </div>
  </div>
</div>

    <!-- جدول المستخدمين -->
    <div class="card" style="margin:20px; padding:20px; background:#fff; border-radius:10px;">
      <h3>📋 قائمة المستخدمين</h3>
      <table id="usersTable" class="display nowrap table table-bordered table-striped" style="width:100%">
  <thead>
    <tr>
      <th>#</th>
      <th>الاسم</th>
      <th>اسم المستخدم</th>
      <th>رقم الهاتف</th>
      <th> الدور </th>
      <th>تاريخ الإنشاء</th>
      <th>آخر تحديث</th>
      <th>الإجراءات</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $result = $conn->query("SELECT id, name, username, phone, role , created_at, updated_at FROM users ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['username']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['role']}</td>
                <td>{$row['created_at']}</td>
                <td>{$row['updated_at']}</td>
                <td>
                  <button class='btn btn-sm btn-warning editBtn' 
        data-id='{$row['id']}' 
        data-name='{$row['name']}' 
        data-username='{$row['username']}' 
        data-phone='{$row['phone']}'
        data-role='{$row['role']}'>
        ✏️ تعديل
</button>
                  <a href='supervisors.php?delete={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"هل أنت متأكد من الحذف؟\")'>
                          🗑 حذف
                  </a>
                </td>
              </tr>";
    }
    ?>
  </tbody>
</table>

    </div>

  </div>

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
   $('.editBtn').click(function () {
      $('#edit_id').val($(this).data('id'));
      $('#edit_name').val($(this).data('name'));
      $('#edit_username').val($(this).data('username'));
      $('#edit_phone').val($(this).data('phone'));
      var editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
  });
});
 function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }
</script>
<!-- Modal التعديل -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="supervisors.php">
        <div class="modal-header">
          <h5 class="modal-title">✏️ تعديل المستخدم</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_id" id="edit_id">
          <div class="mb-3">
            <label class="form-label">الاسم الكامل</label>
            <input type="text" name="edit_name" id="edit_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">اسم المستخدم</label>
            <input type="text" name="edit_username" id="edit_username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">رقم الهاتف</label>
            <input type="text" name="edit_phone" id="edit_phone" class="form-control">
          </div>
          <div class="mb-3">
  <label class="form-label">الدور / الصلاحية</label>
  <select name="edit_role" id="edit_role" class="form-control" required>
    <option value="admin">مدير (Admin)</option>
    <option value="user">مشرف (User)</option>
  </select>
</div>
          <div class="mb-3">
            <label class="form-label">كلمة المرور (اتركها فارغة إن لم تتغير)</label>
            <input type="password" name="edit_password" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-success">💾 حفظ التعديلات</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
