<?php
$files = glob('assets/js/*.js');
foreach ($files as $f) {
    $c = file_get_contents($f);
    preg_match_all('#addEventListener\([\'"]([^\'"]+)[\'"]#i', $c, $m);
    echo basename($f) . ":\n";
    foreach ($m[1] as $evt) {
        echo "  event: $evt\n";
    }
}
