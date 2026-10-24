<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();
$stmt = $db->query('SELECT slug, content_html FROM pages');
while ($r = $stmt->fetch()) {
    preg_match_all('#assets/(images|docs)/[^\s"\'\)]+#', $r['content_html'], $m);
    echo str_pad($r['slug'], 25) . " : " . count($m[0]) . " matches\n";
    if (count($m[0]) > 0) {
        echo "   e.g. " . $m[0][0] . "\n";
    }
}
