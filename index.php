<?php
/**
 * Front Controller & URL Router
 * MGM Model School Recreation Project
 */

require_once __DIR__ . '/config/config.php';

// Parse Route
$route = '';
if (isset($_GET['route'])) {
    $route = trim($_GET['route'], '/');
} else {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH);
    $path = rawurldecode($path);

    if (BASE_PATH && strpos($path, BASE_PATH) === 0) {
        $path = substr($path, strlen(BASE_PATH));
    }
    $route = trim($path, '/');
}

// Route mapping
if ($route === '' || $route === 'home') {
    $wpId = 1119;
    require_once __DIR__ . '/views/home.php';
} else {
    $currentSlug = $route;
    $customView = __DIR__ . '/views/' . $route . '.php';
    if (file_exists($customView)) {
        require_once $customView;
    } else {
        $page = get_page_by_slug($route);
        if ($page) {
            require_once __DIR__ . '/views/page.php';
        } else {
            http_response_code(404);
            require_once __DIR__ . '/views/404.php';
        }
    }
}
