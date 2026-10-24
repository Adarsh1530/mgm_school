<?php
require_once __DIR__ . '/../config/config.php';
$db = getDB();
$stmt = $db->query("SELECT content_html FROM pages WHERE slug = 'gallery'");
$row = $stmt->fetch();
// find where images are
preg_match_all('#<div class="elementor-element[^>]*data-widget_type="image[^>]*>[\s\S]*?</div>\s*</div>#', $row['content_html'], $m);
echo "Image widgets found: " . count($m[0]) . "\n";
if (count($m[0]) > 0) {
    echo $m[0][0] . "\n";
} else {
    // search for <img
    preg_match_all('#<img[^>]*>#', $row['content_html'], $imgs);
    echo "Imgs found: " . count($imgs[0]) . "\n";
    echo $imgs[0][0] . "\n";
}
