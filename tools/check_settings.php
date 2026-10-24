<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $r['setting_key'] . " => " . $r['setting_value'] . PHP_EOL;
}
