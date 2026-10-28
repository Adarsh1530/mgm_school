<?php
/**
 * Isolated CLI Page Renderer for Static Generator
 * MGM Model School
 */
$slug = $argv[1] ?? '';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTPS'] = 'on';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = $slug ? '/' . trim($slug, '/') . '/' : '/';

chdir(__DIR__ . '/..');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

ob_start();
if ($slug === '' || $slug === 'home') {
    $wpId = 1119;
    $currentSlug = '';
    require __DIR__ . '/../views/home.php';
} else {
    $page = get_page_by_slug($slug);
    $currentSlug = $slug;
    $customView = __DIR__ . '/../views/' . $slug . '.php';
    if (file_exists($customView)) {
        require $customView;
    } else {
        require __DIR__ . '/../views/page.php';
    }
}
$html = ob_get_clean();

// Standardize root-relative asset URLs to ensure local and live portability
$html = str_replace('https://mgmmodelschool.edu.in/assets/', '/assets/', $html);

echo $html;
