<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$stmt = $pdo->query("SELECT id, title, image_path FROM gallery");
while ($r = $stmt->fetch()) {
    $clean = ltrim($r['image_path'], '/');
    $exists = file_exists(__DIR__ . '/../' . $clean) ? 'EXISTS' : 'MISSING';
    echo "ID {$r['id']}: '{$r['title']}' => {$r['image_path']} ($exists)\n";
}
