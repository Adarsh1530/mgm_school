<?php
/**
 * Static Site Generator for MGM Model School
 * Pre-renders all pages to clean static HTML with root-relative paths for instant, zero-error Vercel hosting.
 */

$rootDir = str_replace('\\', '/', __DIR__);
$phpBinary = 'C:/xampp/php/php.exe';

$routes = [
    '' => 'index.html',
    'about-us' => 'about-us/index.html',
    'courses-offered' => 'courses-offered/index.html',
    'gallery' => 'gallery/index.html',
    'notices' => 'notices/index.html',
    'mandatory-disclosure' => 'mandatory-disclosure/index.html',
    'contact' => 'contact/index.html',
    'admission-procedure' => 'admission-procedure/index.html',
    'alumni' => 'alumni/index.html',
    'our-founder' => 'our-founder/index.html',
    'our-mission' => 'our-mission/index.html',
    'merit-day' => 'merit-day/index.html',
    'yoga' => 'yoga/index.html',
    'voice-of-mgm' => 'voice-of-mgm/index.html',
    'hindustan-scouts-guides' => 'hindustan-scouts-guides/index.html',
    'swimming-pool' => 'swimming-pool/index.html',
    'ncc' => 'ncc/index.html',
    'attendance' => 'attendance/index.html',
    'pta' => 'pta/index.html',
    '404' => '404.html'
];

echo "Generating static site with isolated PHP processes...\n";

foreach ($routes as $route => $outFile) {
    $fullPath = $rootDir . '/' . $outFile;
    $dir = dirname($fullPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Isolate each page render in its own PHP process
    $renderScript = '<?php '
        . 'chdir(' . var_export($rootDir, true) . '); '
        . '$_GET["route"] = ' . var_export($route, true) . '; '
        . '$_SERVER["REQUEST_METHOD"] = "GET"; '
        . '$_SERVER["REQUEST_URI"] = ' . var_export(empty($route) ? '/' : '/' . $route, true) . '; '
        . '$_SERVER["SCRIPT_NAME"] = "/index.php"; '
        . '$_SERVER["HTTP_HOST"] = "localhost"; '
        . 'require "index.php";';

    $tempScript = $rootDir . '/temp_render.php';
    file_put_contents($tempScript, $renderScript);

    $content = shell_exec('"' . $phpBinary . '" -f "' . $tempScript . '"');
    @unlink($tempScript);

    if (empty($content)) {
        echo "  [ERROR] Failed to render /" . $route . "\n";
        continue;
    }

    // Convert all URLs to pure root-relative paths
    $replacements = [
        'http://localhost/MGM%20SCHOOL/' => '/',
        'http://localhost/MGM SCHOOL/' => '/',
        'https://localhost/MGM%20SCHOOL/' => '/',
        '/C:/xampp/htdocs/MGM%20SCHOOL/' => '/',
        '/C:/xampp/htdocs/MGM SCHOOL/' => '/',
        'C:/xampp/htdocs/MGM%20SCHOOL/' => '/',
        'C:/xampp/htdocs/MGM SCHOOL/' => '/',
        'http://localhost/' => '/',
        'https://localhost/' => '/',
        'https://mgmschool.vercel.app/' => '/',
        'http://mgmschool.vercel.app/' => '/'
    ];

    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }

    // Ensure base tag is cleanly root
    $content = preg_replace('#<base href="[^"]*">#i', '<base href="/">', $content);

    file_put_contents($fullPath, $content);
    echo "  [OK] /" . ($route ?: '(home)') . " -> " . $outFile . " (" . number_format(strlen($content)) . " bytes)\n";
}

echo "All static pages successfully generated!\n";
