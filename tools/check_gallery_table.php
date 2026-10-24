<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT id, title, image_url, category FROM gallery ORDER BY sort_order ASC, id ASC LIMIT 10");
while ($r = $stmt->fetch()) {
    echo "ID {$r['id']}: '{$r['title']}' ({$r['category']}) => {$r['image_url']}\n";
}
