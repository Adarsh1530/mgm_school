<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->prepare("SELECT title, content_html FROM pages WHERE slug = ?");
$stmt->execute(['our-mission']);
$r = $stmt->fetch();
echo "Title: " . $r['title'] . "\n";
echo "Content length: " . strlen($r['content_html']) . "\n";
echo "Content preview: " . substr(strip_tags($r['content_html']), 0, 500) . "\n";
