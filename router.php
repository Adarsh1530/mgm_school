<?php
/**
 * Built-in Web Server Router for MGM Model School
 */

$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// Serve static assets (images, css, js, fonts, docs) directly
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

// Otherwise route through front controller
require __DIR__ . '/index.php';
