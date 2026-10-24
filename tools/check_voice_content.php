<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'voice-of-mgm'");
$stmt->execute();
echo substr($stmt->fetchColumn(), 0, 3000) . "\n";
