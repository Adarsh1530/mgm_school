<?php
require_once __DIR__ . '/../config/config.php';
$db = getDB();
$stmt = $db->query("SELECT content_html FROM pages WHERE slug = 'mandatory-disclosure'");
$row = $stmt->fetch();
$rendered = render_content($row['content_html']);
preg_match_all('#<a[^>]*href="([^"]+)"[^>]*>#i', $rendered, $m);
echo "Rendered sample links:\n";
foreach (array_slice(array_unique($m[1]), 0, 5) as $u) {
    echo "  $u\n";
}
preg_match_all('#<img[^>]*src="([^"]+)"[^>]*>#i', $rendered, $imgs);
echo "Rendered sample images:\n";
foreach (array_slice(array_unique($imgs[1]), 0, 5) as $u) {
    echo "  $u\n";
}
