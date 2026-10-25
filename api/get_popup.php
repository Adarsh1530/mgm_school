<?php
/**
 * Public API - Popup Banner Configuration
 * MGM Model School
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache, no-store, must-revalidate');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    
    $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'popup_%'");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $isActive = isset($settings['popup_active']) ? (int)$settings['popup_active'] : 1;
    $title = $settings['popup_title'] ?? 'Admissions Open 2025-2026';
    $imageUrl = $settings['popup_image_url'] ?? 'assets/images/Untitled-design-4.png';
    $redirectUrl = $settings['popup_redirect_url'] ?? 'admission-procedure/';
    $showDelay = isset($settings['popup_delay']) ? (int)$settings['popup_delay'] : 800;
    $displayMode = $settings['popup_mode'] ?? 'session';

    echo json_encode([
        'status' => 'success',
        'is_active' => $isActive,
        'title' => $title,
        'image_url' => $imageUrl,
        'redirect_url' => $redirectUrl,
        'show_delay' => $showDelay,
        'display_mode' => $displayMode
    ]);
} catch (Throwable $e) {
    echo json_encode([
        'status' => 'fallback',
        'is_active' => 1,
        'title' => 'Admissions Open 2025-2026',
        'image_url' => 'assets/images/Untitled-design-4.png',
        'redirect_url' => 'admission-procedure/',
        'show_delay' => 800,
        'display_mode' => 'session'
    ]);
}
