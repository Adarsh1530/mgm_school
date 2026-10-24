<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

// Print 2000 chars before and after Rajyapuraskar
$pos = strpos($html, 'Rajyapuraskar');
echo substr($html, max(0, $pos - 800), 2000) . "\n";
