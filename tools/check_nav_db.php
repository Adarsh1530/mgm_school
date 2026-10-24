<?php
require_once __DIR__ . '/../config/config.php';
$db = getDB();
$stmt = $db->query('SELECT * FROM navigation ORDER BY sort_order ASC');
while ($r = $stmt->fetch()) {
    echo "ID: {$r['id']} | Parent: {$r['parent_id']} | Label: {$r['label']} | URL: {$r['url']}\n";
}
