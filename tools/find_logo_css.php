<?php
$files = glob('assets/css/*.css');
foreach ($files as $f) {
    $c = file_get_contents($f);
    if (strpos($c, 'tp-header-inner-logo') !== false || strpos($c, 'tp-el-logo') !== false) {
        preg_match_all('#[^\n\}]*(?:tp-header-inner-logo|tp-el-logo)[^\n\{]*\{[^\}]*\}#i', $c, $m);
        foreach ($m[0] as $r) {
            echo basename($f) . ": $r\n";
        }
    }
}
