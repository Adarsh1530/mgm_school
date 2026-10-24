<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$json = json_decode(file_get_contents(__DIR__ . '/../audit/live_deep_audit/live_site_scraped_data.json'), true);
$db = Database::getConnection();

echo "=== COMPARING ADMISSION REQUIREMENTS TABLE ===\n";
$liveAdmissionTable = $json['admission-procedure']['tables'][0] ?? [];
$localAdmissionRows = $db->query("SELECT class_level, documents_required FROM admission_requirements ORDER BY sort_order")->fetchAll(PDO::FETCH_ASSOC);

echo "Live Table Rows: " . count($liveAdmissionTable) . " | Local DB Rows: " . count($localAdmissionRows) . "\n";
echo "\n--- LIVE ADMISSION ROWS ---\n";
foreach ($liveAdmissionTable as $idx => $row) {
    echo "Row $idx: " . implode(" | ", $row) . "\n";
}
echo "\n--- LOCAL ADMISSION DB ROWS ---\n";
foreach ($localAdmissionRows as $idx => $row) {
    echo "DB $idx: {$row['class_level']} | {$row['documents_required']}\n";
}

echo "\n=== COMPARING COURSES TABLE ===\n";
$liveCoursesTable = $json['courses-offered']['tables'][0] ?? [];
$localCoursesRows = $db->query("SELECT class_level, stream_name, subjects FROM courses ORDER BY sort_order")->fetchAll(PDO::FETCH_ASSOC);

echo "Live Table Rows: " . count($liveCoursesTable) . " | Local DB Rows: " . count($localCoursesRows) . "\n";
echo "\n--- LIVE COURSES ROWS ---\n";
foreach ($liveCoursesTable as $idx => $row) {
    echo "Row $idx: " . implode(" | ", $row) . "\n";
}
echo "\n--- LOCAL COURSES DB ROWS ---\n";
foreach ($localCoursesRows as $idx => $row) {
    echo "DB $idx: {$row['class_level']} (" . ($row['stream_name'] ?: 'General') . ") | {$row['subjects']}\n";
}
