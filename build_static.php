<?php
/**
 * Static Site Generator for MGM Model School
 * Pre-renders all pages to clean static HTML with both root .html and directory/index.html
 * for 100% guaranteed zero-error compatibility with Vercel and any static web server.
 */

$rootDir = str_replace('\\', '/', __DIR__);
$phpBinary = 'C:/xampp/php/php.exe';

$routes = [
    '' => ['index.html'],
    'about-us' => ['about-us.html', 'about-us/index.html'],
    'courses-offered' => ['courses-offered.html', 'courses-offered/index.html'],
    'gallery' => ['gallery.html', 'gallery/index.html'],
    'notices' => ['notices.html', 'notices/index.html'],
    'mandatory-disclosure' => ['mandatory-disclosure.html', 'mandatory-disclosure/index.html'],
    'contact' => ['contact.html', 'contact/index.html'],
    'admission-procedure' => ['admission-procedure.html', 'admission-procedure/index.html'],
    'alumni' => ['alumni.html', 'alumni/index.html'],
    'our-founder' => ['our-founder.html', 'our-founder/index.html'],
    'our-mission' => ['our-mission.html', 'our-mission/index.html'],
    'merit-day' => ['merit-day.html', 'merit-day/index.html'],
    'yoga' => ['yoga.html', 'yoga/index.html'],
    'voice-of-mgm' => ['voice-of-mgm.html', 'voice-of-mgm/index.html'],
    'hindustan-scouts-guides' => ['hindustan-scouts-guides.html', 'hindustan-scouts-guides/index.html'],
    'swimming-pool' => ['swimming-pool.html', 'swimming-pool/index.html'],
    'ncc' => ['ncc.html', 'ncc/index.html'],
    'attendance' => ['attendance.html', 'attendance/index.html'],
    'pta' => ['pta.html', 'pta/index.html'],
    '404' => ['404.html']
];

echo "Generating dual static files (.html and /index.html)...\n";

foreach ($routes as $route => $outFiles) {
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
        'http:\/\/localhost\/MGM%20SCHOOL\/' => '\/',
        'http:\/\/localhost\/MGM SCHOOL\/' => '\/',
        'https:\/\/localhost\/MGM%20SCHOOL\/' => '\/',
        'http:\/\/localhost\/' => '\/',
        'https:\/\/localhost\/' => '\/',
        'https://mgmschool.vercel.app/' => '/',
        'http://mgmschool.vercel.app/' => '/'
    ];

    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }

    $content = preg_replace('#<base href="[^"]*">#i', '<base href="/">', $content);

    foreach ($outFiles as $outFile) {
        $fullPath = $rootDir . '/' . $outFile;
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($fullPath, $content);
        echo "  [OK] /" . ($route ?: '(home)') . " -> " . $outFile . "\n";
    }
}

echo "All static files successfully generated!\n";
