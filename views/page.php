<?php
/**
 * Page View
 * Exact Visual Recreation of Reference WordPress Website
 */
require_once __DIR__ . '/../config/config.php';

$page = get_page_by_slug($currentSlug);

if (!$page) {
    http_response_code(404);
    require_once __DIR__ . '/404.php';
    exit;
}

$pageTitle = $page['title'];
$breadcrumbTitle = $page['breadcrumb_title'] ?? $page['title'];
$metaDescription = $page['meta_description'];
$wpId = $page['wp_id'] ?? null;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<?= render_content($page['content_html']) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
