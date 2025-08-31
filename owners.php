<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'config.php';

// إضافة مالك جديد
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO owners (owner_name, contact_no, first_contract_date, notes, owner_type , status, customer_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssis", $_POST['owner_name'], $_POST['contact_no'], $_POST['first_contract_date'], $_POST['notes'], $_POST['owner_type'], $_POST['status'], $_POST['customer_code']);
    $stmt->execute();
    $stmt->close();
    header("Location: owners.php?msg=added");
    exit;
}

// حذف مالك
if (isset($_GET['delete'])) {
    // $stmt = $conn->prepare("DELETE FROM owners WHERE id=?");
    // $stmt->bind_param("i", $_GET['delete']);
    // $stmt->execute();
    // $stmt->close();
    header("Location: owners.php?msg=deleted");
    exit;
}

// جلب بيانات للتعديل
$editRow = [];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM owners WHERE id=?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $editRow = $result->fetch_assoc();
    $stmt->close();
}

// تعديل مالك
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE owners SET owner_name=?, contact_no=?, first_contract_date=?, notes=?, owner_type=?, status=?, customer_code=? WHERE id=?");
    $stmt->bind_param("ssssssii", $_POST['owner_name'], $_POST['contact_no'], $_POST['first_contract_date'], $_POST['notes'], $_POST['owner_type'], $_POST['status'], $_POST['customer_code'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: owners.php?msg=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة الموردين</title>
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

<div class="main full" id="main">
<nav class="navbar navbar-dark mb-4">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"> <span class="menu-btn" onclick="toggleSidebar()">☰</span> 🧑‍💼 إدارة الموردين </span>
  </div>
</nav>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-<?=
        ($_GET['msg'] == 'added') ? 'success' :
        (($_GET['msg'] == 'updated') ? 'info' :
        (($_GET['msg'] == 'deleted') ? 'danger' : 'secondary'))
    ?> alert-dismissible fade show" role="alert">
        <?php if ($_GET['msg'] == 'added'): ?>
            ✅ تم إضافة مورد بنجاح
        <?php elseif ($_GET['msg'] == 'updated'): ?>
            ✏️ تم تحديث بيانات المورد
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
    <button class="btn btn-gold" type="button" data-bs-toggle="collapse" data-bs-target="#ownerForm" aria-expanded="false" aria-controls="ownerForm">
        📋 <?= isset($editRow['id']) ? "تعديل المورد" : "إضافة مورد جديد" ?>
    </button>
  </div>

  <!-- نموذج الإضافة والتعديل -->
  <div class="collapse <?= isset($editRow['id']) ? 'show' : '' ?>" id="ownerForm">
    <div class="card p-4 mb-4">
      <form method="post">
          <div class="row g-3">
              <div class="col-md-4">
                  <label class="form-label">اسم المورد <font color="red"> * </font></label>
                  <input type="text" name="owner_name" placeholder="ادخل إسم المورد" class="form-control" value="<?= isset($editRow['owner_name']) ? $editRow['owner_name'] : '' ?>" required>
              </div>
              <div class="col-md-4">
  <label class="form-label">كود العميل</label>
  <input type="text" name="customer_code" class="form-control" placeholder="أدخل كود العميل" value="<?= isset($editRow['customer_code']) ? $editRow['customer_code'] : '' ?>">
</div>

<div class="col-md-4">
  <label class="form-label">تاريخ أول تعاقد</label>
  <input type="date" name="first_contract_date" class="form-control" value="<?= isset($editRow['first_contract_date']) ? $editRow['first_contract_date'] : '' ?>">
</div>

<div class="col-md-4">
  <label class="form-label">نوع المورد</label>
  <select name="owner_type" class="form-select">
      <option value="">-- اختر --</option>
      <option value="شركة" <?= (isset($editRow['owner_type']) && $editRow['owner_type']=="شركة") ? 'selected' : '' ?>>شركة</option>
      <option value="فرد" <?= (isset($editRow['owner_type']) && $editRow['owner_type']=="فرد") ? 'selected' : '' ?>>فرد</option>
      <option value="وكيل" <?= (isset($editRow['owner_type']) && $editRow['owner_type']=="وكيل") ? 'selected' : '' ?>>وكيل</option>
      <option value="مشروع" <?= (isset($editRow['owner_type']) && $editRow['owner_type']=="مشروع") ? 'selected' : '' ?>>مشروع</option>
      <option value="مقاول من الباطن" <?= (isset($editRow['owner_type']) && $editRow['owner_type']=="مقاول من الباطن") ? 'selected' : '' ?>>مقاول من الباطن</option>
      <option value="تشغيل" <?= (isset($editRow['owner_type']) && $editRow['owner_type']=="تشغيل") ? 'selected' : '' ?>>تشغيل</option>
  </select>
</div>
              <div class="col-md-4">
                  <label class="form-label">رقم الهاتف</label>
                  <input type="text" name="contact_no" placeholder="ادخل رقم الهاتف" class="form-control" value="<?= isset($editRow['contact_no']) ? $editRow['contact_no'] : '' ?>">
              </div>
              <div class="col-md-4">
    <label class="form-label">الحالة</label>
    <select name="status" class="form-select">
        <option value=""> -- إختار الحالة -- </option>
        <option value="1" <?= (isset($editRow['status']) && $editRow['status']==1) ? 'selected' : '' ?>>نشط</option>
        <option value="0" <?= (isset($editRow['status']) && $editRow['status']==0) ? 'selected' : '' ?>>غير نشط</option>
    </select>
</div>
              <div class="col-md-12">
                  <label class="form-label">ملاحظات</label>
                  <textarea cols="10" name="notes" placeholder="ملاحظاتك عن المورد" class="form-control"><?= isset($editRow['notes']) ? $editRow['notes'] : '' ?></textarea>
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
          <a href="owners.php" class="btn btn-link mt-2">إلغاء</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- عرض البيانات -->
  <div class="card p-4">
  <h4 class="mb-3">قائمة الموردين</h4>
  <table id="ownersTable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="text-align: right;">#</th>
        <th style="text-align: right;">الاسم</th>
        <th style="text-align: right;">الهاتف</th>
        <th style="text-align: right;">ملاحظات</th>
        <th style="text-align: right;">كود العميل</th>
        <th style="text-align: right;">تاريخ أول تعاقد</th>
        <th style="text-align: right;">النوع</th>
        <th style="text-align: right;">الحالة</th>
        <th style="text-align: right;">إجراءات</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1 ;
      $result = $conn->query("SELECT * FROM owners");
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $i ?></td>
        <td><?= $row['owner_name'] ?></td>
        <td><?= $row['contact_no'] ?></td>
        <td><?= $row['notes'] ?></td>
        <td><?= $row['customer_code'] ?></td>
        <td><?= $row['first_contract_date'] ?></td>
        <td><?= $row['owner_type'] ?></td>
        <td><?= $row['status'] == 1 ? '<font color="green"> ✅ نشط</font>' : '<font color="red"> ❌ غير نشط</font>' ?></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">✏️ تعديل</a>
          <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</a>
        </td>
      </tr>
      <?php $i++; endwhile; ?>
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
    $('#ownersTable').DataTable({
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
