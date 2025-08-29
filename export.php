<?php
include "config.php";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=operations.csv");
header("Pragma: no-cache");
header("Expires: 0");

// BOM عشان الإكسيل يفهم UTF-8 ويعرض العربي صح
echo "\xEF\xBB\xBF";

$columns = array(
    "record_date", "data_entry_name", "shift", "cost_code", "machine_type", "plate_chassis",
    "start_counter", "end_counter", "driver_name", "supplier", "supplier_name", "project_name",
    "contract_num_customer", "mine_code", "contract_code_machine", "targeted_hours_day",
    "contract_hours_day", "west_moves", "ore_moves", "actual_bucket_hours",
    "actual_jackhammer_hours", "additional_jackhammer_hours", "standby_hours",
    "total_main_hours", "uncompleted_hours", "maintenance_delay", "holidays_vacations",
    "hr_issues", "other_issues", "total_downtime", "discounted_standby", "discounted_working",
    "missing_hours", "marketing_issues", "tank_existing", "new_packing", "diesel_consumption",
    "average_consumption", "notes", "suggestions", "maintenance_type", "maintenance_section",
    "maintenance_details", "malfunctioning_part", "maintenance_description"
);

// طباعة رؤوس الأعمدة
echo implode(",", $columns) . "\n";

$sql = "SELECT " . implode(",", $columns) . " FROM operations";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = array();
        foreach ($columns as $col) {
            $cell = isset($row[$col]) ? $row[$col] : '';
            // لو فيه فاصلة أو سطر جديد، نحط النص جوه " "
            $cell = str_replace('"', '""', $cell); 
            $data[] = '"' . $cell . '"';
        }
        echo implode(",", $data) . "\n";
    }
}
exit;
