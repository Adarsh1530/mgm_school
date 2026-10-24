<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

echo "Page length: " . strlen($html) . "\n";
// Print all image src
preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches);
print_r($matches[1]);
