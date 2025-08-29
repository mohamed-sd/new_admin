<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'config.php';

// إضافة نوع جديد
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO equipment_types (type_name, description, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $_POST['type_name'], $_POST['description'], $_POST['status']);
    $stmt->execute();
    $stmt->close();
    header("Location: equipment_types.php?msg=added");
    exit;
}

// حذف نوع
if (isset($_GET['delete'])) {
    //$stmt = $conn->prepare("DELETE FROM equipment_types WHERE id=?");
    //$stmt->bind_param("i", $_GET['delete']);
    //$stmt->execute();
    //$stmt->close();
    header("Location: equipment_types.php?msg=deleted");
    exit;
}

// جلب بيانات للتعديل
$editRow = [];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM equipment_types WHERE id=?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $editRow = $result->fetch_assoc();
    $stmt->close();
}

// تعديل نوع
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE equipment_types SET type_name=?, description=?, status=? WHERE id=?");
    $stmt->bind_param("ssii", $_POST['type_name'], $_POST['description'], $_POST['status'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: equipment_types.php?msg=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة أنواع المعدات</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <style>
      body { background-color: #fffbea; font-family: 'Tajawal', sans-serif; }
      .navbar { background-color: #d4af37; }
      .btn-gold { background-color: #d4af37; color: white; border: none; }
      .btn-gold:hover { background-color: #b89629; color: #fff; }
      .card { border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
      table { background: white; }
      th { background-color: #d4af37; color: white; }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main" id="main">
<nav class="navbar navbar-dark mb-4">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"> <span class="menu-btn" onclick="toggleSidebar()">☰</span> ⚙️ إدارة أنواع المعدات </span>
  </div>
</nav>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-<?=
        ($_GET['msg'] == 'added') ? 'success' :
        (($_GET['msg'] == 'updated') ? 'info' :
        (($_GET['msg'] == 'deleted') ? 'danger' : 'secondary'))
    ?> alert-dismissible fade show" role="alert">
        <?php if ($_GET['msg'] == 'added'): ?>
            ✅ تم إضافة النوع بنجاح
        <?php elseif ($_GET['msg'] == 'updated'): ?>
            ✏️ تم تحديث بيانات النوع
        <?php elseif ($_GET['msg'] == 'deleted'): ?>
            🗑️ الحذف معطل حاليا
        <?php else: ?>
            ℹ️ عملية غير معروفة
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container">

  <!-- زر إظهار/إخفاء الفورم -->
  <div class="mb-3">
    <button class="btn btn-gold" type="button" data-bs-toggle="collapse" data-bs-target="#typeForm" aria-expanded="false" aria-controls="typeForm">
        📋 <?= isset($editRow['id']) ? "تعديل النوع" : "إضافة نوع جديد" ?>
    </button>
  </div>

  <!-- نموذج الإضافة والتعديل -->
  <div class="collapse <?= isset($editRow['id']) ? 'show' : '' ?>" id="typeForm">
    <div class="card p-4 mb-4">
      <form method="post">
          <div class="row g-3">
              <div class="col-md-6">
                  <label class="form-label">اسم النوع <font color="red"> * </font></label>
                  <input type="text" name="type_name" placeholder="ادخل اسم النوع" class="form-control" value="<?= isset($editRow['type_name']) ? $editRow['type_name'] : '' ?>" required>
              </div>
              <div class="col-md-6">
                  <label class="form-label">الحالة</label>
                  <select name="status" class="form-select">
                      <option value=""> -- إختار الحالة -- </option>
                      <option value="1" <?= (isset($editRow['status']) && $editRow['status']==1) ? 'selected' : '' ?>>نشط</option>
                      <option value="0" <?= (isset($editRow['status']) && $editRow['status']==0) ? 'selected' : '' ?>>غير نشط</option>
                  </select>
              </div>
              <div class="col-md-12">
                  <label class="form-label">الوصف</label>
                  <textarea cols="10" name="description" placeholder="وصف النوع" class="form-control"><?= isset($editRow['description']) ? $editRow['description'] : '' ?></textarea>
              </div>
          </div>

          <div class="mt-4">
              <?php if (isset($editRow['id'])): ?>
                  <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
                  <button type="submit" name="update" class="btn btn-gold">💾 تحديث</button>
              <?php else: ?>
                  <button type="submit" name="add" class="btn btn-gold">➕ إضافة</button>
              <?php endif; ?>
          </div>
      </form>
      <?php if (isset($editRow['id'])): ?>
          <a href="equipment_types.php" class="btn btn-link mt-2">إلغاء</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- عرض البيانات -->
  <div class="card p-4">
  <h4 class="mb-3">قائمة أنواع المعدات</h4>
  <table id="typesTable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="text-align: right;">الاسم</th>
        <th style="text-align: right;">الوصف</th>
        <th style="text-align: right;">الحالة</th>
        <th style="text-align: right;">إجراءات</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM equipment_types");
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['type_name'] ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['status'] == 1 ? '<font color="green"> ✅ نشط</font>' : '<font color="red"> ❌ غير نشط</font>' ?></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ تعديل</a>
          <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('#typesTable').DataTable({
       responsive: true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
        }
    });
});
 function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
 }
 setTimeout(() => {
    let alertNode = document.querySelector('.alert');
    if (alertNode) {
        let bsAlert = new bootstrap.Alert(alertNode);
        bsAlert.close();
    }
}, 4000);
</script>
</body>
</html>