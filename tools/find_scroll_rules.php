<?php
$files = ['assets/css/custom.css', 'assets/css/acadia-core.css', 'assets/js/main.js'];
foreach ($files as $f) {
    $c = file_get_contents($f);
    preg_match_all('#[^\n\}]*scroll[^\n\{]*\{[^\}]*\}#i', $c, $m);
    echo "$f: " . count($m[0]) . " scroll rules\n";
    foreach (array_slice($m[0], 0, 5) as $r) {
        echo "  " . substr($r, 0, 100) . "\n";
    }
}
