<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'config.php';

// إضافة مشروع جديد
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO projects (project_name, project_location, contract_type, contract_duration, target_hours, target_tons, target_meters, target_floors, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssidddsi", $_POST['project_name'], $_POST['project_location'], $_POST['contract_type'], $_POST['contract_duration'], $_POST['target_hours'], $_POST['target_tons'], $_POST['target_meters'], $_POST['target_floors'], $_POST['notes'], $_POST['status']);
    $stmt->execute();
    $stmt->close();
    header("Location: projects.php?msg=added");
    exit;
}

// حذف مشروع
if (isset($_GET['delete'])) {
    // $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
    // $stmt->bind_param("i", $_GET['delete']);
    // $stmt->execute();
    // $stmt->close();
    header("Location: projects.php?msg=deleted");
    exit;
}

// جلب بيانات للتعديل
$editRow = [];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id=?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $editRow = $result->fetch_assoc();
    $stmt->close();
}

// تعديل مشروع
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE projects SET project_name=?, project_location=?, contract_type=?, contract_duration=?, target_hours=?, target_tons=?, target_meters=?, target_floors=?, notes=?, status=? WHERE id=?");
    $stmt->bind_param("ssssidddsii", $_POST['project_name'], $_POST['project_location'], $_POST['contract_type'], $_POST['contract_duration'], $_POST['target_hours'], $_POST['target_tons'], $_POST['target_meters'], $_POST['target_floors'], $_POST['notes'], $_POST['status'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
    header("Location: projects.php?msg=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إدارة المشاريع</title>
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
<span class="navbar-brand mb-0 h1"> <span class="menu-btn" onclick="toggleSidebar()">☰</span> 🏗️ إدارة المشاريع </span>
</div>
</nav>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-<?=
($_GET['msg'] == 'added') ? 'success' :
(($_GET['msg'] == 'updated') ? 'info' :
(($_GET['msg'] == 'deleted') ? 'danger' : 'secondary'))
?> alert-dismissible fade show" role="alert">
<?php if ($_GET['msg'] == 'added'): ?>
✅ تم إضافة المشروع بنجاح
<?php elseif ($_GET['msg'] == 'updated'): ?>
✏️ تم تحديث بيانات المشروع
<?php elseif ($_GET['msg'] == 'deleted'): ?>
🗑️ الحذف معطل مؤقتا
<?php else: ?>
ℹ️ عملية غير معروفة
<?php endif; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="container">

<!-- زر إظهار/إخفاء الفورم -->
<div class="mb-3">
<button class="btn btn-gold" type="button" data-bs-toggle="collapse" data-bs-target="#projectForm" aria-expanded="false" aria-controls="projectForm">
📋 <?= isset($editRow['id']) ? "تعديل المشروع" : "إضافة مشروع جديد" ?>
</button>
</div>

<!-- نموذج الإضافة والتعديل -->
<div class="collapse <?= isset($editRow['id']) ? 'show' : '' ?>" id="projectForm">
<div class="card p-4 mb-4">
<form method="post">
<div class="row g-3">
<div class="col-md-4">
<label class="form-label">اسم المشروع <font color="red"> * </font></label>
<input type="text" name="project_name" placeholder="ادخل اسم المشروع" class="form-control" value="<?= isset($editRow['project_name']) ? $editRow['project_name'] : '' ?>" required>
</div>

<div class="col-md-4">
<label class="form-label">مكان المشروع</label>
<input type="text" name="project_location" class="form-control" value="<?= isset($editRow['project_location']) ? $editRow['project_location'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">نوع العقد</label>
<input type="text" name="contract_type" class="form-control" value="<?= isset($editRow['contract_type']) ? $editRow['contract_type'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">مدة العقد</label>
<input type="text" name="contract_duration" class="form-control" value="<?= isset($editRow['contract_duration']) ? $editRow['contract_duration'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">الساعات المستهدفة</label>
<input type="number" name="target_hours" class="form-control" value="<?= isset($editRow['target_hours']) ? $editRow['target_hours'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">الأطنان المستهدفة</label>
<input type="number" step="0.01" name="target_tons" class="form-control" value="<?= isset($editRow['target_tons']) ? $editRow['target_tons'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">الأمتار المستهدفة</label>
<input type="number" step="0.01" name="target_meters" class="form-control" value="<?= isset($editRow['target_meters']) ? $editRow['target_meters'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">الأدوار المستهدفة</label>
<input type="number" name="target_floors" class="form-control" value="<?= isset($editRow['target_floors']) ? $editRow['target_floors'] : '' ?>">
</div>

<div class="col-md-4">
<label class="form-label">الحالة</label>
<select name="status" class="form-select">
<option value="1" <?= (isset($editRow['status']) && $editRow['status']==1) ? 'selected' : '' ?>>نشط</option>
<option value="0" <?= (isset($editRow['status']) && $editRow['status']==0) ? 'selected' : '' ?>>غير نشط</option>
</select>
</div>

<div class="col-md-12">
<label class="form-label">ملاحظات</label>
<textarea name="notes" class="form-control"><?= isset($editRow['notes']) ? $editRow['notes'] : '' ?></textarea>
</div>
</div>

<div class="mt-4">
<?php if (isset($editRow['id'])): ?>
<input type="hidden" name="id" value="<?= $editRow['id'] ?>">
<button type="submit" name="update" class="btn btn-gold">💾 تحديث</button>
<a href="projects.php" class="btn btn-link">إلغاء</a>
<?php else: ?>
<button type="submit" name="add" class="btn btn-gold">➕ إضافة</button>
<?php endif; ?>
</div>
</form>
</div>
</div>

<!-- عرض البيانات -->
<div class="card p-4">
<h4 class="mb-3">قائمة المشاريع</h4>
<table id="projectsTable" class="table table-bordered table-striped">
<thead>
<tr>
<th>#</th>
<th>اسم المشروع</th>
<th>المكان</th>
<th>نوع العقد</th>
<th>مدة العقد</th>
<th>الساعات</th>
<th>الأطنان</th>
<th>الأمتار</th>
<th>الأدوار</th>
<th>الحالة</th>
<th>ملاحظات</th>
<th>إجراءات</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
$result = $conn->query("SELECT * FROM projects");
while($row = $result->fetch_assoc()):
?>
<tr>
<td><?= $i ?></td>
<td><?= $row['project_name'] ?></td>
<td><?= $row['project_location'] ?></td>
<td><?= $row['contract_type'] ?></td>
<td><?= $row['contract_duration'] ?></td>
<td><?= $row['target_hours'] ?></td>
<td><?= $row['target_tons'] ?></td>
<td><?= $row['target_meters'] ?></td>
<td><?= $row['target_floors'] ?></td>
<td><?= $row['status']==1 ? '<font color="green">✅ نشط</font>' : '<font color="red">❌ غير نشط</font>' ?></td>
<td><?= $row['notes'] ?></td>
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
$('#projectsTable').DataTable({
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
</script>
</body>
</html>
