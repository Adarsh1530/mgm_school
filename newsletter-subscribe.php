<?php
/**
 * Newsletter Subscription Handler
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if ($email) {
        try {
            $db = getDB();
            $stmt = $db->prepare("INSERT IGNORE INTO newsletter_subscribers (email) VALUES (:email)");
            $stmt->execute([':email' => $email]);
            set_flash('success', 'Thank you for subscribing to the MGM Model School newsletter!');
        } catch (Exception $e) {
            error_log("Newsletter error: " . $e->getMessage());
        }
    }
}

// Redirect back to referring page or homepage
$referer = $_SERVER['HTTP_REFERER'] ?? url('/');
header("Location: " . $referer);
exit;
