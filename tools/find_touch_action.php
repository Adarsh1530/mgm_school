<?php
$files = glob('assets/css/*.css');
foreach ($files as $f) {
    $c = file_get_contents($f);
    if (strpos($c, 'touch-action') !== false) {
        preg_match_all('#[^\n\}]*touch-action[^\n\{]*\{[^\}]*\}#i', $c, $m);
        echo basename($f) . ":\n";
        foreach ($m[0] as $r) {
            echo "  $r\n";
        }
    }
}
