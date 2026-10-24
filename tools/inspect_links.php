<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();
$stmt = $db->query('SELECT slug, content_html FROM pages');
while ($r = $stmt->fetch()) {
    preg_match_all('#(src|href)=["\']([^"\']+)["\']#i', $r['content_html'], $matches, PREG_SET_ORDER);
    echo "=== Page: " . $r['slug'] . " ===\n";
    foreach ($matches as $m) {
        $attr = $m[1];
        $val = $m[2];
        // print if not starting with http or mailto or tel or #
        if (!preg_match('#^(https?://|mailto:|tel:|#)#', $val)) {
            echo "   $attr: $val\n";
        }
    }
}
