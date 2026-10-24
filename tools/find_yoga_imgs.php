<?php
require_once __DIR__ . '/../config/config.php';
$db = getDB();
$stmt = $db->query("SELECT content_html FROM pages WHERE slug = 'yoga'");
$row = $stmt->fetch();
$rendered = render_content($row['content_html']);
preg_match_all('#<img[^>]*>#i', $rendered, $m);
foreach ($m[0] as $img) {
    echo "IMG: $img\n";
}
