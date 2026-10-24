<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT id, menu_id, label, url, parent_id, sort_order FROM menu_items ORDER BY parent_id, sort_order");
while ($r = $stmt->fetch()) {
    echo "ID: {$r['id']}, Parent: {$r['parent_id']}, Order: {$r['sort_order']}, Label: {$r['label']} => URL: {$r['url']}\n";
}
