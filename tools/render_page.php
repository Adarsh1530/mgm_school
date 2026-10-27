<?php
// Simple CLI page renderer
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/highlights/';
$_SERVER['SERVER_NAME'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTP_HOST'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTPS'] = 'on';

require_once __DIR__ . '/../config/config.php';

ob_start();
$currentSlug = 'highlights';
$pageTitle = 'Campus Highlights';
$breadcrumbTitle = 'Highlights';
$metaDescription = 'Explore the 21 unique highlights of MGM Model School Ayiroor, Varkala — from our semi-Olympic swimming pool and 20-20 teaching method to the AI Robotics Hub, Poly House, and National Cadet Corps.';
require_once __DIR__ . '/../views/highlights.php';
$html = ob_get_clean();

echo "Rendered length: " . strlen($html) . "\n";
echo "Highlights count in HTML: " . substr_count($html, 'highlight-card') . "\n";
echo "Activities count in HTML: " . substr_count($html, 'Activities') . "\n";
