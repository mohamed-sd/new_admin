<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
include 'config.php'; // يفترض أن $conn هو mysqli connection

// ---------- إضافة معدة ----------
if (isset($_POST['add'])) {
    $equipment_code = isset($_POST['equipment_code']) ? trim($_POST['equipment_code']) : '';
    $equipment_name = isset($_POST['equipment_name']) ? trim($_POST['equipment_name']) : '';
    $equipment_type = isset($_POST['equipment_type']) ? trim($_POST['equipment_type']) : '';
    $owner_id = isset($_POST['owner_id']) ? trim($_POST['owner_id']) : '';
    $model = isset($_POST['model']) ? trim($_POST['model']) : '';
    $plate_number = isset($_POST['plate_number']) ? trim($_POST['plate_number']) : '';
    $status = isset($_POST['status']) ? intval($_POST['status']) : 1;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    $stmt = $conn->prepare("INSERT INTO equipments (equipment_code, equipment_name, equipment_type, owner_id, model, plate_number, status, description, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
if (!$stmt) {
    die("Prepare Error (insert): " . $conn->error);
}
$stmt->bind_param("sssissis", $equipment_code, $equipment_name, $equipment_type, $_POST['owner_id'], $model, $plate_number, $status, $description);
    if (!$stmt->execute()) {
        die("Execute Error (insert): " . $stmt->error);
    }
    $stmt->close();
    header("Location: equipments.php?msg=added");
    exit;
}

// ---------- حذف معدة ----------
if (isset($_GET['delete'])) {
    // $id = intval($_GET['delete']);
    // $stmt = $conn->prepare("DELETE FROM equipments WHERE id = ?");
    // if (!$stmt) {
    //     die("Prepare Error (delete): " . $conn->error);
    // }
    // $stmt->bind_param("i", $id);
    // if (!$stmt->execute()) {
    //     die("Execute Error (delete): " . $stmt->error);
    // }
    // $stmt->close();
    header("Location: equipments.php?msg=deleted");
    exit;
}

// ---------- جلب بيانات للتعديل ----------
$editRow = array();
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM equipments WHERE id = ?");
    if (!$stmt) {
        die("Prepare Error (select edit): " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Execute Error (select edit): " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result) {
        $editRow = $result->fetch_assoc();
    } else {
        $editRow = array();
    }
    $stmt->close();
}

// ---------- تعديل معدة ----------
if (isset($_POST['update'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $equipment_code = isset($_POST['equipment_code']) ? trim($_POST['equipment_code']) : '';
    $equipment_name = isset($_POST['equipment_name']) ? trim($_POST['equipment_name']) : '';
    $equipment_type = isset($_POST['equipment_type']) ? trim($_POST['equipment_type']) : '';
    $owner_id = isset($_POST['owner_id']) ? trim($_POST['owner_id']) : '';
    $model = isset($_POST['model']) ? trim($_POST['model']) : '';
    $plate_number = isset($_POST['plate_number']) ? trim($_POST['plate_number']) : '';
    $status = isset($_POST['status']) ? intval($_POST['status']) : 1;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    $stmt = $conn->prepare("UPDATE equipments SET equipment_code=?, equipment_name=?, equipment_type=?, owner_id=?, model=?, plate_number=?, status=?, description=? WHERE id=?");
if (!$stmt) {
    die("Prepare Error (update): " . $conn->error);
}
$stmt->bind_param("sssissisi", $equipment_code, $equipment_name, $equipment_type, $_POST['owner_id'], $model, $plate_number, $status, $description, $id);
    if (!$stmt->execute()) {
        die("Execute Error (update): " . $stmt->error);
    }
    $stmt->close();
    header("Location: equipments.php?msg=updated");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة المعدات</title>
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
    <span class="navbar-brand mb-0 h1"><span class="menu-btn" onclick="toggleSidebar()">☰</span> 🚜 إدارة المعدات </span>
  </div>
</nav>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-<?=
        ($_GET['msg'] == 'added') ? 'success' :
        (($_GET['msg'] == 'updated') ? 'info' :
        (($_GET['msg'] == 'deleted') ? 'danger' : 'secondary'))
    ?> alert-dismissible fade show" role="alert">
        <?php if ($_GET['msg'] == 'added'): ?>
            ✅ تم إضافة المعدة بنجاح
        <?php elseif ($_GET['msg'] == 'updated'): ?>
            ✏️ تم تحديث بيانات المعدة
        <?php elseif ($_GET['msg'] == 'deleted'): ?>
            🗑️ الحذف لا يعمل مؤقتا
        <?php else: ?>
            ℹ️ عملية غير معروفة
        <?php endif; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container">

  <!-- زر إظهار/إخفاء الفورم -->
  <div class="mb-3">
    <button class="btn btn-gold" type="button" data-bs-toggle="collapse" data-bs-target="#equipForm" aria-expanded="false" aria-controls="equipForm">
        📋 <?php echo isset($editRow['id']) ? "تعديل معدة" : "إضافة معدة جديدة"; ?>
    </button>
  </div>

  <!-- نموذج الإضافة والتعديل -->
  <div class="collapse <?php echo isset($editRow['id']) ? 'show' : ''; ?>" id="equipForm">
    <div class="card p-4 mb-4">
      <form method="post">
          <div class="row g-3">
              <div class="col-md-4">
                  <label class="form-label">كود المعدة / Equipation <font color="red">*</font></label>
                  <input type="text" name="equipment_code" class="form-control" value="<?php echo isset($editRow['equipment_code']) ? htmlspecialchars($editRow['equipment_code']) : ''; ?>" required>
              </div>
              <div class="col-md-4">
                  <label class="form-label"> كود العميل / <font color="red">*</font></label>
                  <input type="text" name="equipment_name" class="form-control" value="<?php echo isset($editRow['equipment_name']) ? htmlspecialchars($editRow['equipment_name']) : ''; ?>" required>
              </div>
              <div class="col-md-4">
  <label class="form-label">نوع المعدة</label>
  <select name="equipment_type" class="form-select" required>
      <option value="">-- اختر نوع المعدة --</option>
      <?php
      $types = $conn->query("SELECT * FROM equipment_types WHERE status=1");
      while($t = $types->fetch_assoc()):
      ?>
      <option value="<?= $t['id'] ?>" <?= (isset($editRow['equipment_type']) && $editRow['equipment_type'] == $t['id']) ? 'selected' : '' ?>>
          <?= $t['type_name'] ?>
      </option>
      <?php endwhile; ?>
  </select>
</div>

<div class="col-md-4">
  <label class="form-label">المورد / المالك</label>
  <select name="owner_id" class="form-select" required>
      <option value="">-- اختر المورد --</option>
      <?php
      $owners = $conn->query("SELECT * FROM owners WHERE status=1 ORDER BY owner_name ASC");
      while($o = $owners->fetch_assoc()):
      ?>
      <option value="<?= $o['id'] ?>" <?= (isset($editRow['owner_id']) && $editRow['owner_id'] == $o['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($o['owner_name']) ?>
      </option>
      <?php endwhile; ?>
  </select>
</div>
              <div class="col-md-4">
                  <label class="form-label">الموديل</label>
                  <input type="text" name="model" class="form-control" value="<?php echo isset($editRow['model']) ? htmlspecialchars($editRow['model']) : ''; ?>">
              </div>
              <div class="col-md-4">
                  <label class="form-label">رقم اللوحة</label>
                  <input type="text" name="plate_number" class="form-control" value="<?php echo isset($editRow['plate_number']) ? htmlspecialchars($editRow['plate_number']) : ''; ?>">
              </div>
              <div class="col-md-4">
                  <label class="form-label">الحالة</label>
                  <select name="status" class="form-select">
                      <option value="1" <?php echo (isset($editRow['status']) && $editRow['status']==1) ? 'selected' : ''; ?>>نشط</option>
                      <option value="0" <?php echo (isset($editRow['status']) && $editRow['status']==0) ? 'selected' : ''; ?>>غير نشط</option>
                  </select>
              </div>

              <div class="col-md-8">
                  <label class="form-label">ملاحظات / وصف</label>
                  <textarea name="description" class="form-control"><?php echo isset($editRow['description']) ? htmlspecialchars($editRow['description']) : ''; ?></textarea>
              </div>
          </div>

          <div class="mt-4">
              <?php if (isset($editRow['id'])): ?>
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($editRow['id']); ?>">
                  <button type="submit" name="update" class="btn btn-gold">💾 تحديث</button>
              <?php else: ?>
                  <button type="submit" name="add" class="btn btn-gold">➕ إضافة</button>
              <?php endif; ?>
          </div>
      </form>
      <?php if (isset($editRow['id'])): ?>
          <a href="equipments.php" class="btn btn-link mt-2">إلغاء</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- عرض البيانات -->
  <div class="card p-4">
  <h4 class="mb-3">قائمة المعدات</h4>
  <table id="equipmentsTable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="text-align: right;">#</th>
        <th style="text-align: right;">كود المعدة</th>
        <th style="text-align: right;">كود العميل</th>
        <th style="text-align: right;">النوع</th>
        <th style="text-align: right;">المورد</th>
        <th style="text-align: right;">الموديل</th>
        <th style="text-align: right;">رقم اللوحة</th>
        <th style="text-align: right;">الحالة</th>
        <th style="text-align: right;">تاريخ الإدخال</th>
        <th style="text-align: right;">إجراءات</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      $result = $conn->query("SELECT * FROM equipments ORDER BY id DESC");
      if (!$result) { die("SQL Error (select equipments): " . $conn->error); }
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo htmlspecialchars($row['equipment_code']); ?></td>
        <td><?php echo htmlspecialchars($row['equipment_name']); ?></td>
        <td>
    <?php
    $type_id = $row['equipment_type'];
    $type_name = '';
    $qType = $conn->query("SELECT type_name FROM equipment_types WHERE id = '$type_id' LIMIT 1");
    if($qType && $qType->num_rows > 0){
        $typeRow = $qType->fetch_assoc();
        $type_name = $typeRow['type_name'];
    }
    echo htmlspecialchars($type_name);
    ?>
</td>
<td>
  <?php
  $owner_id = $row['owner_id'];
  $owner_name = '';
  $qOwner = $conn->query("SELECT owner_name FROM owners WHERE id = '$owner_id' LIMIT 1");
  if($qOwner && $qOwner->num_rows > 0){
      $ownerRow = $qOwner->fetch_assoc();
      $owner_name = $ownerRow['owner_name'];
  }
  echo htmlspecialchars($owner_name);
  ?>
</td>
        <td><?php echo htmlspecialchars($row['model']); ?></td>
        <td><?php echo htmlspecialchars($row['plate_number']); ?></td>
        <td><?php echo ($row['status'] == 1) ? '<font color="green"> ✅ نشط</font>' : '<font color="red"> ❌ غير نشط</font>'; ?></td>
        <td><?php echo htmlspecialchars(isset($row['created_at']) ? $row['created_at'] : ''); ?></td>
        <td>
          <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">✏️ تعديل</a>
          <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</a>
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
    $('#equipmentsTable').DataTable({
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
 setTimeout(function(){
    var alertNode = document.querySelector('.alert');
    if (alertNode) {
        var bsAlert = new bootstrap.Alert(alertNode);
        bsAlert.close();
    }
}, 4000);
</script>
</body>
</html>
