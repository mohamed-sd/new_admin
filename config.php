<?php
// ملف config.php

$host = "localhost";     // اسم السيرفر (غالباً localhost)
$user = "root";          // اسم المستخدم لقاعدة البيانات
$pass = "";              // كلمة مرور المستخدم
$db   = "equipation";      // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($host, $user, $pass, $db);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}



/**
 * دالة عامة للإضافة (تعمل مع كل الجداول)
 * @param string $table اسم الجدول
 * @param array $data مصفوفة (الحقل => القيمة)
 * @return int|false ترجع ID آخر إدخال أو false في حال الفشل
 */
if (!function_exists('insertData')) {
    function insertData($table, $data) {
        global $conn;
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $values = array_values($data);
        $types  = str_repeat("s", count($values));
        $stmt->bind_param($types, ...$values);
        return $stmt->execute() ? $conn->insert_id : false;
    }
}

?>
