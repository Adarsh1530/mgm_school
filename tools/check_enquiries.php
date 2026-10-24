<?php
require_once 'config/config.php';
$db = getDB();
$stmt = $db->query('SELECT id, type, name, email, phone, status, created_at FROM enquiries ORDER BY id DESC LIMIT 5');
while ($r = $stmt->fetch()) {
    echo "ID: {$r['id']} | Type: {$r['type']} | Name: {$r['name']} | Status: {$r['status']} | At: {$r['created_at']}\n";
}
