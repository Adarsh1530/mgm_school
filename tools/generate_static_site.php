<?php
/**
 * Static Site Generator for MGM Model School
 * Renders all pages with up-to-date navigation, mega-dropdown, and assets
 */
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTPS'] = 'on';
$_SERVER['SCRIPT_NAME'] = '/index.php';

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$pagesToRender = [
    '' => ['file' => 'index.html', 'dir' => null],
    'highlights' => ['file' => 'highlights.html', 'dir' => 'highlights'],
    'about-us' => ['file' => 'about-us.html', 'dir' => 'about-us'],
    'our-founder' => ['file' => 'our-founder.html', 'dir' => 'our-founder'],
    'our-mission' => ['file' => 'our-mission.html', 'dir' => 'our-mission'],
    'courses-offered' => ['file' => 'courses-offered.html', 'dir' => 'courses-offered'],
    'admission-procedure' => ['file' => 'admission-procedure.html', 'dir' => 'admission-procedure'],
    'attendance' => ['file' => 'attendance.html', 'dir' => 'attendance'],
    'swimming-pool' => ['file' => 'swimming-pool.html', 'dir' => 'swimming-pool'],
    'voice-of-mgm' => ['file' => 'voice-of-mgm.html', 'dir' => 'voice-of-mgm'],
    'ncc' => ['file' => 'ncc.html', 'dir' => 'ncc'],
    'hindustan-scouts-guides' => ['file' => 'hindustan-scouts-guides.html', 'dir' => 'hindustan-scouts-guides'],
    'yoga' => ['file' => 'yoga.html', 'dir' => 'yoga'],
    'merit-day' => ['file' => 'merit-day.html', 'dir' => 'merit-day'],
    'pta' => ['file' => 'pta.html', 'dir' => 'pta'],
    'alumni' => ['file' => 'alumni.html', 'dir' => 'alumni'],
    'gallery' => ['file' => 'gallery.html', 'dir' => 'gallery'],
    'notices' => ['file' => 'notices.html', 'dir' => 'notices'],
    'mandatory-disclosure' => ['file' => 'mandatory-disclosure.html', 'dir' => 'mandatory-disclosure'],
    'contact' => ['file' => 'contact.html', 'dir' => 'contact'],
];

foreach ($pagesToRender as $slug => $dest) {
    echo "Rendering: " . ($slug ?: 'home') . "... ";
    $_SERVER['REQUEST_URI'] = $slug ? '/' . $slug . '/' : '/';
    
    ob_start();
    if ($slug === '') {
        $wpId = 1119;
        $currentSlug = '';
        require __DIR__ . '/../views/home.php';
    } else {
        $page = get_page_by_slug($slug);
        $currentSlug = $slug;
        $customView = __DIR__ . '/../views/' . $slug . '.php';
        if (file_exists($customView)) {
            require $customView;
        } else {
            require __DIR__ . '/../views/page.php';
        }
    }
    $html = ob_get_clean();

    // Standardize root-relative asset URLs to ensure local and live portability
    $html = str_replace('https://mgmmodelschool.edu.in/assets/', '/assets/', $html);

    // Save to root html file
    $rootFile = __DIR__ . '/../' . $dest['file'];
    file_put_contents($rootFile, $html);

    // Save to folder/index.html if dir defined
    if ($dest['dir']) {
        $dirPath = __DIR__ . '/../' . $dest['dir'];
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
        file_put_contents($dirPath . '/index.html', $html);
    }
    echo "Done (" . strlen($html) . " bytes)\n";
}

echo "All static pages successfully generated!\n";
