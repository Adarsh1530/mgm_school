<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->query("DESCRIBE navigation");
while ($r = $stmt->fetch()) {
    echo $r['Field'] . " (" . $r['Type'] . ")\n";
}
