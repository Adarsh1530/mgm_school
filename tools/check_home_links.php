<?php
require_once __DIR__ . '/../config/config.php';

$html = file_get_contents(__DIR__ . '/../views/home.php');
preg_match_all('#(src|href)=["\']([^"\']+)["\']#i', $html, $matches, PREG_SET_ORDER);
$relativeAssets = 0;
$slashLinks = 0;
foreach ($matches as $m) {
    $attr = $m[1];
    $val = $m[2];
    if (strpos($val, 'assets/') === 0) {
        $relativeAssets++;
    } elseif (strpos($val, '/') === 0 && strpos($val, '//') !== 0) {
        $slashLinks++;
        // echo "Slash link: $val\n";
    }
}
echo "home.php: $relativeAssets relative assets, $slashLinks slash links\n";
