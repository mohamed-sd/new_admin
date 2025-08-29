<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * , ( SELECT equipment_types.type_name FROM equipment_types WHERE equipment_types.id = (SELECT equipments.equipment_type FROM equipments WHERE master.plate_no = equipments.plate_number)) as 'type' FROM master WHERE id=$id LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc(), JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(null);
    }
}
?>