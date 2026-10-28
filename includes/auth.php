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
    if (($_SESSION['user_role'] ?? '') !== 'admin' && ($_SESSION['user_role'] ?? '') !== 'superadmin') {
        http_response_code(403);
        die("Access Denied: You do not have administrative privileges.");
    }
}

function is_superadmin(): bool {
    return is_logged_in() && (($_SESSION['user_role'] ?? '') === 'superadmin');
}

function require_superadmin(): void {
    require_login();
    if (!is_superadmin()) {
        set_flash('error', 'Access Denied: User roles management is restricted to Super Admin.');
        header("Location: " . ADMIN_URL . "/");
        exit;
    }
}
