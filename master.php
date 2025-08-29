<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // رجعه لصفحة تسجيل الدخول
    exit;
}
include 'config.php'; 

// إضافة سجل جديد
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO master 
        (status, plant_no, contract_type, yom, plate_no, supplier_code, owner, owner_toc, contact_no, starting_date, releasing_date, project_name, notes, `user`, hours) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isssissssssssss", 
        $_POST['status'], 
        $_POST['plant_no'], 
        $_POST['contract_type'], 
        $_POST['yom'], 
        $_POST['plate_no'], 
        $_POST['supplier_code'], 
        $_POST['owner'], 
        $_POST['owner_toc'], 
        $_POST['contact_no'], 
        $_POST['starting_date'], 
        $_POST['releasing_date'], 
        $_POST['project_name'], 
        $_POST['notes'], 
        $_POST['supervisor'],  // يروح في عمود `user`
        $_POST['hours']        // يروح في عمود hours
    );

    $stmt->execute();
    $stmt->close();
    header("Location: master.php");
    exit;
}



// حذف سجل
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM master WHERE id=?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
    $stmt->close();
    header("Location: master.php");
    exit;
}

// جلب بيانات للتعديل
$editRow = [];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM master WHERE id=?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    $editRow = $result->fetch_assoc();
    $stmt->close();
}

// تعديل سجل
// تعديل سجل
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE master 
        SET status=?, plant_no=?, contract_type=?, yom=?, plate_no=?, supplier_code=?, owner=?, owner_toc=?, contact_no=?, starting_date=?, releasing_date=?, project_name=?, `user`=?, notes=? , hours=?
        WHERE id=?");

    $stmt->bind_param("isssissssssssssi", 
        $_POST['status'], 
        $_POST['plant_no'], 
        $_POST['contract_type'], 
        $_POST['yom'], 
        $_POST['plate_no'], 
        $_POST['supplier_code'], 
        $_POST['owner'], 
        $_POST['owner_toc'], 
        $_POST['contact_no'], 
        $_POST['starting_date'], 
        $_POST['releasing_date'], 
        $_POST['project_name'], 
        $_POST['supervisor'],  // ✅ استخدم نفس حقل الفورم
        $_POST['notes'], 
        $_POST['hours'],
        $_POST['id']
    );

    $stmt->execute();
    $stmt->close();
    header("Location: master.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title> ادارة الماستر </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <style>
      body {
          background-color: #fffbea;
          font-family: 'Tajawal', sans-serif;
      }
      .navbar {
          background-color: #d4af37;
      }
      .btn-gold {
          background-color: #d4af37;
          color: white;
          border: none;
      }
      .btn-gold:hover {
          background-color: #b89629;
          color: #fff;
      }
      .card {
          border-radius: 15px;
          box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      }
      table {
          background: white;
      }
      th {
          background-color: #d4af37;
          color: white;
      }
  </style>
</head>
<body>

  <!-- Include the sidebar -->
  <?php include 'sidebar.php'; ?>

<div class="main" id="main">
<nav class="navbar navbar-dark mb-4">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1"> <span class="menu-btn" onclick="toggleSidebar()">☰</span> 🚛  ادارة الماستر </span>
  </div>
</nav>

<div class="container">

  <!-- زر إظهار/إخفاء الفورم -->
  <div class="mb-3">
    <button class="btn btn-gold" type="button" data-bs-toggle="collapse" data-bs-target="#equipmentForm" aria-expanded="false" aria-controls="equipmentForm">
        📋 <?= isset($editRow['id']) ? "تعديل البيانات" : "إضافة بيانات جديدة" ?>
    </button>
  </div>

  <!-- نموذج الإضافة والتعديل -->
  <div class="collapse <?= isset($editRow['id']) ? 'show' : '' ?>" id="equipmentForm">
    <div class="card p-4 mb-4">
      <form method="post">
          <div class="row g-3">


       <div class="col-md-4">
    <label class="form-label">المالك</label>
    <select name="ownerselect" id="ownerselect" class="form-select" <?= isset($editRow['id']) ? '' : 'required' ?>>
        <option value="">-- اختر مالك --</option>
        <?php
        $owners = $conn->query("SELECT * FROM owners WHERE status=1");
        while($o = $owners->fetch_assoc()):
        ?>
        <option value="<?= $o['id'] ?>" <?= (isset($editRow['owner']) && $editRow['owner'] == $o['id']) ? 'selected' : '' ?>>
            <?= $o['owner_name'] ?>
        </option>
        <?php endwhile; ?>
          </select>
          </div>

    <div class="col-md-4">
    <label class="form-label">المعدة</label>
    <select name="equipment" id="equipment" class="form-select" <?= isset($editRow['id']) ? '' : 'required' ?>>
  <option value="">-- اختر معدة --</option>
  <?php
  $equipments = $conn->query("SELECT * FROM equipments WHERE status=1");
  while($e = $equipments->fetch_assoc()):
  ?>
  <option value="<?= $e['id'] ?>" 
    <?= (isset($editRow['equipment']) && $editRow['equipment'] == $e['id']) ? 'selected' : '' ?>>
      <?= $e['equipment_name'] ." -- ". $e['equipment_code'] ?>
  </option>
  <?php endwhile; ?>
</select>
    </div>

    <div class="col-md-4">
  <label class="form-label">المشروع</label>
  <select name="project" id="project" class="form-select" <?= isset($editRow['id']) ? '' : 'required' ?>>
    <option value="">-- اختر مشروع --</option>
    <?php
    $projects = $conn->query("SELECT * FROM projects WHERE status=1");
    while($p = $projects->fetch_assoc()):
    ?>
    <option value="<?= $p['id'] ?>" 
      <?= (isset($editRow['project_name']) && $editRow['project_name'] == $p['id']) ? 'selected' : '' ?>>
        <?= $p['project_name'] ?>
    </option>
    <?php endwhile; ?>
  </select>
</div>

 

   <div class="col-md-4">
  <label class="form-label">المشرف</label>
  <select name="supervisor" id="supervisor" class="form-select" <?= isset($editRow['id']) ? '' : 'required' ?>>
    <option value="">-- اختر المشرف --</option>
    <?php
    $users = $conn->query("SELECT * FROM users WHERE role='user'");
    while($u = $users->fetch_assoc()):
    ?>
    <option value="<?= $u['id'] ?>" 
      <?= (isset($editRow['user']) && $editRow['user'] == $u['id']) ? 'selected' : '' ?>>
        <?= $u['name'] . " -- " . $u['phone'] ?>
    </option>
    <?php endwhile; ?>
  </select>
</div>

          <div class="col-md-4">
                  <label class="form-label"> اسم المالك</label>
                  <input type="text" name="owner" id="owner" class="form-control" value="<?= isset($editRow['plant_no']) ? $editRow['plant_no'] : '' ?>">
              </div>

             <div class="col-md-4">
                  <label class="form-label">رقم الموبايل</label>
                  <input type="text" name="contact_no" id="contact_no" class="form-control" value="<?= isset($editRow['contact_no']) ? $editRow['contact_no'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">تسمية إكوبيشن</label>
                  <input type="text" name="plant_no" id="plant_no" class="form-control" value="<?= isset($editRow['plant_no']) ? $editRow['plant_no'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">سنة الصنع</label>
                  <input type="number" name="yom" id="yom" class="form-control" value="<?= isset($editRow['yom']) ? $editRow['yom'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">رقم اللوحة</label>
                  <input type="text" name="plate_no" id="plate_no" class="form-control" value="<?= isset($editRow['plate_no']) ? $editRow['plate_no'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">تسمية العميل</label>
                  <input type="text" name="supplier_code" id="supplier_code" class="form-control" value="<?= isset($editRow['supplier_code']) ? $editRow['supplier_code'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">نوع العقد</label>
                  <input type="text" name="contract_type" id="contract_type" class="form-control" value="<?= isset($editRow['contract_type']) ? $editRow['contract_type'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">المالك حسب شهادة البحث</label>
                  <input type="text" name="owner_toc" class="form-control" value="<?= isset($editRow['owner_toc']) ? $editRow['owner_toc'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">تاريخ الدخول</label>
                  <input type="date" name="starting_date" class="form-control" value="<?= isset($editRow['starting_date']) ? $editRow['starting_date'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">تاريخ الخروج</label>
                  <input type="date" name="releasing_date" class="form-control" value="<?= isset($editRow['releasing_date']) ? $editRow['releasing_date'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">اسم المشروع</label>
                  <input type="text" name="project_name" id="project_name" class="form-control" value="<?= isset($editRow['project_name']) ? $editRow['project_name'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label"> ساعات العمل </label>
                  <input type="text" name="hours" id="hours" class="form-control" value="<?= isset($editRow['project_name']) ? $editRow['hours'] : '' ?>">
              </div>

              <div class="col-md-4">
                  <label class="form-label">الحالة</label>
                  <select name="status" class="form-select">
                      <option value="1" <?= (isset($editRow['status']) && $editRow['status']==1) ? 'selected' : '' ?>>في الخدمة</option>
                      <option value="0" <?= (isset($editRow['status']) && $editRow['status']==0) ? 'selected' : '' ?>>خارج الخدمة</option>
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
              <?php else: ?>
                  <button type="submit" name="add" class="btn btn-gold">➕ إضافة</button>
              <?php endif; ?>
          </div>
      </form>
          <?php if (isset($editRow['id'])): ?>
                  <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
                  <a href="master.php"> الغاء </a>
              <?php else: ?>
                 <!--  <button type="submit" name="add" class="btn btn-gold">➕ إضافة</button> -->
              <?php endif; ?>
    </div>
  </div>

  <!-- عرض البيانات -->
  <div class="card p-4">
    <h4 class="mb-3">قائمة المعدات</h4>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>الحالة</th>
          <th>إكوبيشن</th>
          <th>نوع العقد</th>
          <th>سنة الصنع</th>
          <th>رقم اللوحة</th>
          <th>العميل</th>
          <th>المالك</th>
          <!-- <th>المالك/ش.البحث</th> -->
          <th>موبايل</th>
          <th>تاريخ الدخول</th>
          <th>تاريخ الخروج</th>
          <th>المشروع</th>
          <th>ملاحظات</th>
          <th>إجراءات</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM master");
        while($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= $row['status'] == 1 ? 'في الخدمة' : 'خارج الخدمة' ?></td>
          <td><?= $row['plant_no'] ?></td>
          <td><?= $row['contract_type'] ?></td>
          <td><?= $row['yom'] ?></td>
          <td><?= $row['plate_no'] ?></td>
          <td><?= $row['supplier_code'] ?></td>
          <td><?= $row['owner'] ?></td>
          <!-- <td><?= $row['owner_toc'] ?></td> -->
          <td><?= $row['contact_no'] ?></td>
          <td><?= $row['starting_date'] ?></td>
          <td><?= $row['releasing_date'] ?></td>
          <td><?= $row['project_name'] ?></td>
          <td><?= $row['notes'] ?></td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>


  $(document).ready(function() {
    $('.table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
        },
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100],
        "order": [[ 1, "asc" ]] // ترتيب حسب العمود الثاني افتراضي
    });
});

  document.getElementById("equipment").addEventListener("change", function() {
    let equipmentId = this.value;
    if (equipmentId) {
        fetch("get_equipment.php?id=" + equipmentId)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById("yom").value = data.model || "";
                document.getElementById("plate_no").value = data.plate_number || "";
                document.getElementById("plant_no").value = data.equipment_name || "";
                document.getElementById("supplier_code").value = data.equipment_code || "";
            }
        });
    }
});

document.getElementById("ownerselect").addEventListener("change", function() {
    let ownerId = this.value;
    if (ownerId) {
        fetch("get_owner.php?id=" + ownerId)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById("owner").value = data.owner_name || "";
                document.getElementById("contact_no").value = data.contact_no || "";
                // document.getElementById("plant_no").value = data.equipment_name || "";
                // document.getElementById("supplier_code").value = data.equipment_code || "";
            }
        });
    }
});

document.getElementById("project").addEventListener("change", function() {
    let ownerId = this.value;
    if (ownerId) {
        fetch("get_project.php?id=" + ownerId)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById("project_name").value = data.project_name || "";
                document.getElementById("contract_type").value = data.contract_type || "";
                document.getElementById("hours").value = data.target_hours || "";
                // document.getElementById("plant_no").value = data.equipment_name || "";
                // document.getElementById("supplier_code").value = data.equipment_code || "";
            }
        });
    }
});

 function toggleSidebar(){
      document.getElementById("sidebar").classList.toggle("hide");
      document.getElementById("main").classList.toggle("full");
    }
</script>
</body>
</html>
