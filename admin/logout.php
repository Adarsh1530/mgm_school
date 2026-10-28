<?php
/**
 * Admin Logout Handler
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

if (is_logged_in()) {
    log_audit("User Logout", "Admin user " . ($_SESSION['username'] ?? '') . " logged out.");
}

clear_admin_token();

$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

header("Location: " . ADMIN_URL . "/login.php");
exit;
