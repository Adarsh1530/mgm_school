<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();
$stmt = $db->prepare("SELECT id FROM pages WHERE slug = 'notices' LIMIT 1");
$stmt->execute();
$existing = $stmt->fetch();

if (!$existing) {
    $ins = $db->prepare("
        INSERT INTO pages (slug, title, hero_title, breadcrumb_title, content_html, meta_description, is_published)
        VALUES ('notices', 'Notices', 'News, Announcements & Events', 'Notices', '', 'Official notices, circulars, academic milestones, and event updates from MGM Model School Ayiroor, Varkala.', 1)
    ");
    $ins->execute();
    echo "Inserted 'notices' into pages table.\n";
} else {
    echo "'notices' page already exists with id {$existing['id']}.\n";
}
