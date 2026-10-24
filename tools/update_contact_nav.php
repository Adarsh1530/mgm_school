<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();

// 1. Update navigation ID 6 URL to /contact/
$pdo->query("UPDATE navigation SET url = '/contact/' WHERE id = 6");
echo "Updated navigation Contact URL to /contact/!\n";

// 2. Ensure pages table has a row for contact
$stmt = $pdo->prepare("SELECT id FROM pages WHERE slug = 'contact'");
$stmt->execute();
if (!$stmt->fetch()) {
    $ins = $pdo->prepare("INSERT INTO pages (slug, title, breadcrumb_title, meta_description, content_html, is_published, created_at, updated_at) VALUES ('contact', 'Contact Us', 'Contact Us', 'Contact MGM Model School, Ayiroor, Varkala - Location, phone numbers, email, and campus enquiry.', '', 1, NOW(), NOW())");
    $ins->execute();
    echo "Inserted contact page into pages table!\n";
} else {
    echo "Contact page already in pages table.\n";
}
