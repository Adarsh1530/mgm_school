<?php
/**
 * Authentication & Authorization
 * MGM Model School Recreation Project
 */

require_once __DIR__ . '/../config/config.php';

function is_logged_in(): bool {
    return !empty($_SESSION['user_id']) && !empty($_SESSION['username']);
}

function current_user(): ?array {
    if (!is_logged_in()) {
        return null;
    }
    return [
        'id'       => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'email'    => $_SESSION['user_email'] ?? '',
        'role'     => $_SESSION['user_role'] ?? 'admin'
    ];
}

function require_login(): void {
    if (!is_logged_in()) {
        set_flash('error', 'Please log in to access the administration panel.');
        header("Location: " . ADMIN_URL . "/login.php");
        exit;
    }
}

function require_admin(): void {
    require_login();
    if ($_SESSION['user_role'] !== 'admin') {
        http_response_code(403);
        die("Access Denied: You do not have administrative privileges.");
    }
}
