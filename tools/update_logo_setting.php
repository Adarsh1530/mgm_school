<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'logo_path'");
$stmt->execute(['assets/images/new-mgm-logo.png']);
echo "Updated logo_path to assets/images/new-mgm-logo.png. Rows affected: " . $stmt->rowCount() . "\n";
