<?php
require_once __DIR__ . '/../config/config.php';
$db = getDB();
$stmt = $db->query("SELECT content_html FROM pages WHERE slug = 'mandatory-disclosure'");
$row = $stmt->fetch();
preg_match_all('#<a[^>]*href="([^"]+)"[^>]*>#i', $row['content_html'], $m);
echo "Total links in mandatory-disclosure content: " . count($m[1]) . "\n";
foreach (array_unique($m[1]) as $u) {
    echo "  " . $u . "\n";
}
