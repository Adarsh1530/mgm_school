<?php
/**
 * Image Popup Notification API
 * MGM Model School Website
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

$popup = get_popup_notification();

if ($popup) {
    $img = $popup['image_url'];
    if (!preg_match('#^https?://#i', $img)) {
        $img = asset_url(str_replace('assets/', '', $img));
    }
    $popup['display_image_url'] = $img;
    echo json_encode([
        'status' => 'success',
        'active' => true,
        'popup'  => $popup
    ]);
} else {
    echo json_encode([
        'status' => 'success',
        'active' => false,
        'popup'  => null
    ]);
}
