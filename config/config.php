<?php
/**
 * Application Configuration
 * MGM Model School Recreation Project
 */

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Start secure session if not started
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// Database Credentials
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mgm_school');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Dynamic Base URL Detection
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

if (php_sapi_name() === 'cli') {
    $basePath = '/MGM SCHOOL';
} else {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $basePath = rtrim($scriptDir, '/');
    if ($basePath !== '' && $basePath[0] !== '/') {
        $basePath = '/' . $basePath;
    }
    // If accessed inside /admin, adjust base path
    if (substr($basePath, -6) === '/admin') {
        $basePath = substr($basePath, 0, -6);
    }
}

define('BASE_PATH', $basePath);
define('BASE_URL', $protocol . $host . str_replace(' ', '%20', $basePath));
define('ASSETS_URL', BASE_URL . '/assets');
define('ADMIN_URL', BASE_URL . '/admin');

// File Uploads
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads');
define('DOCS_DIR', __DIR__ . '/../assets/docs');
define('IMAGES_DIR', __DIR__ . '/../assets/images');

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../includes/functions.php';
