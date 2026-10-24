<?php
$cssFiles = glob(__DIR__ . '/../assets/css/*.css');
foreach ($cssFiles as $f) {
    $content = file_get_contents($f);
    if (strpos($content, 'mgm-school.nbtksa.in') !== false) {
        preg_match_all('#https?://mgm-school\.nbtksa\.in[^\)"\'\s]+#', $content, $m);
        echo basename($f) . ": " . count($m[0]) . " references\n";
        foreach (array_unique($m[0]) as $url) {
            echo "   " . $url . "\n";
        }
    }
}
