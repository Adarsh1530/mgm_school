<?php
$cssFiles = glob(__DIR__ . '/../assets/css/*.css');
foreach ($cssFiles as $f) {
    $content = file_get_contents($f);
    if (strpos($content, 'tp-hero-bg') !== false) {
        echo basename($f) . " has tp-hero-bg\n";
    }
}
