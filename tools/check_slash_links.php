<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();
$stmt = $db->query('SELECT slug, content_html FROM pages');
while ($r = $stmt->fetch()) {
    preg_match_all('#(src|href)=["\'](/[a-zA-Z0-9_\-\./]+)["\']#i', $r['content_html'], $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        echo "Page {$r['slug']}: {$m[1]}=\"{$m[2]}\"\n";
    }
}
