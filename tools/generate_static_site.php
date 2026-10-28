<?php
/**
 * Static Site Generator for MGM Model School
 * Renders all pages with up-to-date navigation, mega-dropdown, and assets
 * Uses isolated process execution to ensure every page includes full header, navigation, and footer.
 */

$phpBinary = 'c:\\xampp\\php\\php.exe';
if (!file_exists($phpBinary)) {
    $phpBinary = 'php';
}

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
    'twenty-twenty-method' => ['file' => 'twenty-twenty-method.html', 'dir' => 'twenty-twenty-method'],
    'libraries-at-mgm' => ['file' => 'libraries-at-mgm.html', 'dir' => 'libraries-at-mgm'],
    'poly-house' => ['file' => 'poly-house.html', 'dir' => 'poly-house'],
    'krishi-thottam' => ['file' => 'krishi-thottam.html', 'dir' => 'krishi-thottam'],
    'amma-school' => ['file' => 'amma-school.html', 'dir' => 'amma-school'],
    'vriksha-chikitsa' => ['file' => 'vriksha-chikitsa.html', 'dir' => 'vriksha-chikitsa'],
    'counselling-centre' => ['file' => 'counselling-centre.html', 'dir' => 'counselling-centre'],
    'innovation-centre' => ['file' => 'innovation-centre.html', 'dir' => 'innovation-centre'],
    'gdc' => ['file' => 'gdc.html', 'dir' => 'gdc'],
    'life-skills' => ['file' => 'life-skills.html', 'dir' => 'life-skills'],
    'school-canteen' => ['file' => 'school-canteen.html', 'dir' => 'school-canteen'],
    'butterfly-garden' => ['file' => 'butterfly-garden.html', 'dir' => 'butterfly-garden'],
    '3d-max-zone' => ['file' => '3d-max-zone.html', 'dir' => '3d-max-zone'],
    'ominis' => ['file' => 'ominis.html', 'dir' => 'ominis'],
    'nova-ai-hub' => ['file' => 'nova-ai-hub.html', 'dir' => 'nova-ai-hub'],
    'school-band-troop' => ['file' => 'school-band-troop.html', 'dir' => 'school-band-troop'],
    'happiness-room' => ['file' => 'happiness-room.html', 'dir' => 'happiness-room'],
    'club-and-house-activities' => ['file' => 'club-and-house-activities.html', 'dir' => 'club-and-house-activities'],
    'club-house-activities' => ['file' => 'club-house-activities.html', 'dir' => 'club-house-activities'],
];

$cliRenderer = __DIR__ . '/render_page_cli.php';
$errors = 0;

foreach ($pagesToRender as $slug => $dest) {
    $label = $slug ?: 'home';
    echo "Rendering: " . str_pad($label, 28) . "... ";

    $cmd = escapeshellarg($phpBinary) . ' ' . escapeshellarg($cliRenderer) . ' ' . escapeshellarg($slug);
    $html = shell_exec($cmd);

    if (empty($html) || strpos($html, '<!DOCTYPE html>') === false) {
        echo "FAILED (incomplete or missing doctype)\n";
        $errors++;
        continue;
    }

    // Strip out any fallback SQLite warning line if present at the top
    $html = preg_replace('/^MySQL connection unavailable[^\n]*\n+/i', '', $html);

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
    echo "Done (" . strlen($html) . " bytes, full HTML)\n";
}

if ($errors === 0) {
    echo "\nAll " . count($pagesToRender) . " static pages successfully generated with complete stylesheets & layouts!\n";
} else {
    echo "\nCompleted with $errors errors.\n";
}
