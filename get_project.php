<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->query("SELECT * FROM projects WHERE id=$id AND status=1");
    if ($query->num_rows > 0) {
        echo json_encode($query->fetch_assoc());
    }
}
?>
