<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'mandatory-disclosure'");
$stmt->execute();
$html = $stmt->fetchColumn();

// Replace all links pointing to assets/docs/ with target="_blank" rel="noopener noreferrer"
$updated = preg_replace_callback(
    '#<a([^>]+href="assets/docs/[^"]+")([^>]*)>#i',
    function ($m) {
        $attrs = $m[1] . ' ' . $m[2];
        // remove existing target or rel
        $attrs = preg_replace('#\s*target="[^"]*"#i', '', $attrs);
        $attrs = preg_replace('#\s*rel="[^"]*"#i', '', $attrs);
        return '<a ' . trim($attrs) . ' target="_blank" rel="noopener noreferrer">';
    },
    $html
);

$up = $pdo->prepare("UPDATE pages SET content_html = ? WHERE slug = 'mandatory-disclosure'");
$up->execute([$updated]);
echo "Updated mandatory-disclosure document links with target='_blank' rel='noopener noreferrer'! Rows: " . $up->rowCount() . "\n";
