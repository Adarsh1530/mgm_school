<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'mandatory-disclosure'");
$stmt->execute();
$html = $stmt->fetchColumn();

preg_match_all('#<a[^>]+href="([^"]+)"[^>]*>(.*?)</a>#is', $html, $m);
for ($i = 0; $i < count($m[0]); $i++) {
    $href = $m[1][$i];
    $text = trim(strip_tags($m[2][$i]));
    echo "[$i] '$text' => $href\n";
}
