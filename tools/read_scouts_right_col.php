<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

// Print everything after the certificates block
$pos = strpos($html, 'elementor-element-4a139fb');
if ($pos !== false) {
    echo substr($html, $pos, 4000) . "\n";
} else {
    echo "Not found, printing last 3000 chars:\n" . substr($html, -3000) . "\n";
}
