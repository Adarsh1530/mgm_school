<?php
/**
 * Helper Functions
 * MGM Model School Recreation Project
 */

function e(?string $str): string {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string {
    if (empty($path) || $path === '/') {
        return BASE_URL . '/';
    }
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0 || strpos($path, 'tel:') === 0 || strpos($path, 'mailto:') === 0 || $path === '#') {
        return $path;
    }
    $trimmed = ltrim($path, '/');
    return BASE_URL . '/' . $trimmed;
}

function asset_url(string $path = ''): string {
    $trimmed = ltrim($path, '/');
    if (strpos($trimmed, 'assets/') === 0) {
        return url($trimmed);
    }
    return url('assets/' . $trimmed);
}

function render_content(?string $html): string {
    if (empty($html)) return '';
    $baseUrl = str_replace(' ', '%20', rtrim(BASE_URL, '/'));

    // Rewrite relative assets/ paths in src, poster, and href
    $html = preg_replace('#(src|poster)=([\'"])assets/#i', '$1=$2' . $baseUrl . '/assets/', $html);
    $html = preg_replace('#href=([\'"])assets/#i', 'href=$1' . $baseUrl . '/assets/', $html);

    // Rewrite background-image url(assets/...
    $html = preg_replace('#url\(([\'"]?)assets/#i', 'url($1' . $baseUrl . '/assets/', $html);

    // Rewrite internal root-relative links like href="/about-us/"
    $html = preg_replace_callback('#href=([\'"])/([a-zA-Z0-9_\-]+/??)([\'"])#i', function($m) use ($baseUrl) {
        return 'href=' . $m[1] . $baseUrl . '/' . ltrim($m[2], '/') . $m[3];
    }, $html);

    // Ensure images load eagerly to prevent scroll stutter and blank image placeholders
    $html = str_replace('loading="lazy"', 'loading="eager"', $html);

    return $html;
}

function render_mgm_video(string $videoPath, string $posterPath = '', string $title = 'Video'): string {
    $vUrl = asset_url($videoPath);
    $pAttr = $posterPath ? ' poster="' . e(asset_url($posterPath)) . '"' : '';
    $safeTitle = e($title);
    return <<<HTML
<div class="mgm-video-container" data-video-wrapper>
  <video class="mgm-autoplay-video" playsinline webkit-playsinline muted loop preload="none"{$pAttr}>
    <source src="{$vUrl}" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>
  <div class="mgm-video-controls-overlay">
    <div class="mgm-video-btn-group">
      <button type="button" class="mgm-video-ctrl-btn mgm-btn-mute" aria-label="Unmute Video">
        <i class="fa-solid fa-volume-xmark"></i> <span class="mgm-btn-label">Unmute</span>
      </button>
    </div>
    <div class="mgm-video-badge">
      <span class="mgm-video-badge-dot"></span>
      <span>{$safeTitle}</span>
    </div>
  </div>
</div>
HTML;
}

function get_setting(string $key, string $default = ''): string {
    static $settingsCache = null;
    if ($settingsCache === null) {
        $settingsCache = [];
        try {
            $db = getDB();
            $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
            while ($row = $stmt->fetch()) {
                $settingsCache[$row['setting_key']] = $row['setting_value'];
            }
        } catch (Exception $e) {
            error_log("Settings error: " . $e->getMessage());
        }
    }
    return $settingsCache[$key] ?? $default;
}

/**
 * Update or insert a site setting
 */
function set_setting(string $key, string $value): bool {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        if ($stmt->fetchColumn() > 0) {
            $upd = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
            return $upd->execute([$value, $key]);
        } else {
            $ins = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
            return $ins->execute([$key, $value]);
        }
    } catch (Throwable $e) {
        error_log("set_setting error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get active image popup notification if enabled and within date range
 */
function get_popup_notification(): ?array {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM popups WHERE is_active = 1 ORDER BY updated_at DESC, id DESC LIMIT 1");
        $popup = $stmt ? $stmt->fetch() : null;
        if ($popup && !empty($popup['image_url'])) {
            return [
                'enabled'   => true,
                'image_url' => $popup['image_url'],
                'title'     => $popup['title'] ?? 'Special Announcement',
                'link_url'  => $popup['link_url'] ?? '',
            ];
        }
    } catch (\Throwable $e) {
        // Fallback to site_settings if popups table not available
    }

    $enabled = get_setting('popup_enabled', '0');
    $imageUrl = get_setting('popup_image_url', '');

    if ($enabled !== '1' || empty($imageUrl)) {
        return null;
    }

    return [
        'enabled'   => true,
        'image_url' => $imageUrl,
        'title'     => get_setting('popup_title', 'Special Announcement'),
        'link_url'  => get_setting('popup_link_url', ''),
    ];
}

function get_navigation_tree(): array {
    static $tree = null;
    if ($tree !== null) return $tree;

    $tree = [];
    try {
        $db = getDB();
        $stmt = $db->query("SELECT * FROM navigation ORDER BY sort_order ASC, id ASC");
        $items = $stmt->fetchAll();

        $lookup = [];
        foreach ($items as $item) {
            $item['children'] = [];
            $lookup[$item['id']] = $item;
        }

        foreach ($lookup as $id => &$item) {
            if ($item['parent_id'] && isset($lookup[$item['parent_id']])) {
                $lookup[$item['parent_id']]['children'][] = &$item;
            } else {
                $tree[] = &$item;
            }
        }
    } catch (Exception $e) {
        error_log("Navigation error: " . $e->getMessage());
    }
    return $tree;
}

function get_page_by_slug(string $slug): ?array {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM pages WHERE slug = :slug AND is_published = 1 LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        $page = $stmt->fetch();
        return $page ?: null;
    } catch (Exception $e) {
        error_log("Page fetch error: " . $e->getMessage());
        return null;
    }
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function log_audit(string $action, string $details = ''): void {
    try {
        $db = getDB();
        $userId = $_SESSION['user_id'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $stmt = $db->prepare("INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES (:uid, :act, :det, :ip)");
        $stmt->execute([
            ':uid' => $userId,
            ':act' => $action,
            ':det' => $details,
            ':ip'  => $ip
        ]);
    } catch (Exception $e) {
        error_log("Audit log error: " . $e->getMessage());
    }
}

function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function get_active_notices(?string $category = null): array {
    try {
        $db = getDB();
        if ($category && $category !== 'all') {
            $stmt = $db->prepare("SELECT * FROM notices WHERE is_active = 1 AND category = :cat ORDER BY sort_order ASC, publish_date DESC");
            $stmt->execute([':cat' => $category]);
        } else {
            $stmt = $db->query("SELECT * FROM notices WHERE is_active = 1 ORDER BY sort_order ASC, publish_date DESC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Notices fetch error: " . $e->getMessage());
        return [];
    }
}

function get_ticker_notices(): array {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT id, title, slug, category, badge_color, display_date FROM notices WHERE is_active = 1 AND is_ticker = 1 ORDER BY sort_order ASC, publish_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Ticker notices fetch error: " . $e->getMessage());
        return [];
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void {
        header("Location: " . $url);
        exit;
    }
}
