<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT id, title, file_url, file_name FROM mandatory_disclosures");
while ($r = $stmt->fetch()) {
    echo "{$r['id']}: {$r['title']} => {$r['file_url']} ({$r['file_name']})\n";
}
