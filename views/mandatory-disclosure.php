<?php
/**
 * Mandatory Disclosure View
 * Exact Visual Recreation of Reference WordPress Website with Authentic School Documents
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "mandatory-disclosure";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Mandatory Disclosure";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "Mandatory public disclosures for MGM Model School, Ayiroor, Varkala.";
$wpId = 16051;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<!-- Original Elementor Disclosure Tables -->
<?= render_content($page['content_html']) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
