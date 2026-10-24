<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

$start = strpos($html, '<!-- Rajyapuraskar');
if ($start !== false) {
    echo substr($html, $start, 4000) . "\n";
} else {
    echo "Block not found!\n";
}
