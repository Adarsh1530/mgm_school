<?php
/**
 * Authentication & Authorization
 * MGM Model School Recreation Project
 */

require_once __DIR__ . '/../config/config.php';

// Ensure session is initialized
if (function_exists('start_admin_session')) {
    start_admin_session();
} elseif (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

/**
 * Issue secure persistent authentication cookie token (14 days)
 */
function issue_admin_token(array $user): void {
    if (empty($user['id']) || empty($user['username'])) return;
    $key = defined('AUTH_SECRET_KEY') ? AUTH_SECRET_KEY : 'mgm_default_secret_key';
    $pwdHash = $user['password_hash'] ?? '';
    $payload = $user['id'] . '|' . $user['username'] . '|' . hash('sha256', $pwdHash);
    $signature = hash_hmac('sha256', $payload, $key);
    $token = base64_encode($payload . '|' . $signature);

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || (isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false)
        || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'mgmmodelschool.edu.in') !== false);

    $expires = time() + (86400 * 14); // 14 days
    if (PHP_VERSION_ID >= 70300) {
        setcookie('mgm_admin_token', $token, [
            'expires' => $expires,
            'path' => '/',
            'domain' => '',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    } else {
        setcookie('mgm_admin_token', $token, $expires, '/', '', $isHttps, true);
    }
}

/**
 * Clear persistent authentication cookie
 */
function clear_admin_token(): void {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || (isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], 'https') !== false)
        || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'mgmmodelschool.edu.in') !== false);

    if (PHP_VERSION_ID >= 70300) {
        setcookie('mgm_admin_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'domain' => '',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    } else {
        setcookie('mgm_admin_token', '', time() - 3600, '/', '', $isHttps, true);
    }
    unset($_COOKIE['mgm_admin_token']);
}

/**
 * Attempt to restore login session from persistent cookie token
 */
function authenticate_from_token(): bool {
    if (empty($_COOKIE['mgm_admin_token'])) {
        return false;
    }

    $raw = base64_decode($_COOKIE['mgm_admin_token'], true);
    if (!$raw) {
        clear_admin_token();
        return false;
    }

    $parts = explode('|', $raw);
    if (count($parts) !== 4) {
        clear_admin_token();
        return false;
    }

    list($userId, $username, $pwdHashSha, $sig) = $parts;
    $key = defined('AUTH_SECRET_KEY') ? AUTH_SECRET_KEY : 'mgm_default_secret_key';
    $expectedSig = hash_hmac('sha256', $userId . '|' . $username . '|' . $pwdHashSha, $key);

    if (!hash_equals($expectedSig, $sig)) {
        clear_admin_token();
        return false;
    }

    // Verify user still exists in database and password has not changed
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id AND username = :u LIMIT 1");
        $stmt->execute([':id' => $userId, ':u' => $username]);
        $user = $stmt->fetch();

        if ($user && hash('sha256', $user['password_hash'] ?? '') === $pwdHashSha) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
    } catch (\Throwable $e) {
        error_log("Token auth error: " . $e->getMessage());
    }

    clear_admin_token();
    return false;
}

function is_logged_in(): bool {
    if (!empty($_SESSION['user_id']) && !empty($_SESSION['username'])) {
        return true;
    }
    return authenticate_from_token();
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

    // If already authenticated, ensure no stale login warning flash is lingering in session
    if (!empty($_SESSION['flash']) && is_array($_SESSION['flash'])) {
        if (isset($_SESSION['flash']['message']) && strpos($_SESSION['flash']['message'], 'Please log in to access') !== false) {
            unset($_SESSION['flash']);
        }
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
