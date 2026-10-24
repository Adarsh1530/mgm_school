<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

preg_match_all('/[^\s"\'<>]+\.pdf/i', $html, $matches);
echo "PDF matches found: " . count($matches[0]) . "\n";
print_r($matches[0]);
