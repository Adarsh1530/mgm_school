<?php
$c = file_get_contents('assets/css/acadia-core.css');
preg_match_all('#\.main-menu[^{]*\{[^}]*\}#i', $c, $m);
echo "main-menu rules: " . count($m[0]) . "\n";
foreach ($m[0] as $r) {
    if (strpos($r, 'content') !== false) {
        echo "  $r\n";
    }
}
$c2 = file_get_contents('assets/css/custom.css');
preg_match_all('#\.main-menu[^{]*\{[^}]*\}#i', $c2, $m2);
echo "custom.css main-menu rules: " . count($m2[0]) . "\n";
foreach ($m2[0] as $r) {
    echo "  $r\n";
}
