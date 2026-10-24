<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'mandatory-disclosure'");
$stmt->execute();
$html = $stmt->fetchColumn();

preg_match_all('#<a[^>]+href="assets/docs/[^"]+"[^>]*>#is', $html, $m);
foreach ($m[0] as $tag) {
    echo "$tag\n";
}
