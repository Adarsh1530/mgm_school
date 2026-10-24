<?php
$files = ['assets/css/animate.css', 'assets/css/acadia-core.css'];
foreach ($files as $f) {
    $c = file_get_contents($f);
    if (preg_match_all('#[^\n\}]*\.wow[^\n\{]*\{[^\}]*\}#i', $c, $m)) {
        echo "$f:\n";
        foreach ($m[0] as $r) {
            echo "  $r\n";
        }
    }
}
