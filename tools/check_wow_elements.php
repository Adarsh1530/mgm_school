<?php
require_once 'config/config.php';
$html = file_get_contents('audit/homepage_clean_extracted.html');
preg_match_all('#class="[^"]*wow[^"]*"#i', $html, $m);
echo "Homepage wow elements: " . count($m[0]) . "\n";

$db = getDB();
$stmt = $db->query('SELECT slug, content_html FROM pages');
while ($r = $stmt->fetch()) {
    preg_match_all('#class="[^"]*wow[^"]*"#i', $r['content_html'], $mw);
    if (count($mw[0]) > 0) {
        echo "{$r['slug']}: " . count($mw[0]) . " wow elements\n";
    }
}
