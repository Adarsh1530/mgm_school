<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

$start = strpos($html, '<!-- Rajyapuraskar');
$end = strpos($html, '<div class="elementor-element elementor-element-4a139fb', $start);
echo "Start: $start, End: $end\n";
echo substr($html, $start, $end - $start) . "\n";
