<?php
/**
 * Courses Offered View
 * Exact Visual Recreation of Reference WordPress Website with Authentic Course Chart
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "courses-offered";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Courses Offered";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "Courses and curriculum streams offered at MGM Model School.";
$wpId = 15930;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<!-- Original Database-Driven Content Tables -->
<?= render_content($page['content_html']) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
