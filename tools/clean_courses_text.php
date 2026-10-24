<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'courses-offered'");
$stmt->execute();
$html = $stmt->fetchColumn();

$cleaned = str_replace(
    '<p>Here is the same content with only minor corrections for punctuation and consistency:</p>',
    '',
    $html
);

$update = $pdo->prepare("UPDATE pages SET content_html = ? WHERE slug = 'courses-offered'");
$update->execute([$cleaned]);
echo "Cleaned courses-offered! Rows affected: " . $update->rowCount() . "\n";
