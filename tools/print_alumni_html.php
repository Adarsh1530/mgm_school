<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = ?");
$stmt->execute(['alumni']);
echo $stmt->fetchColumn() . "\n";
