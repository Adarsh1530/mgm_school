<?php
$files = glob('assets/css/*.css');
foreach ($files as $f) {
    $c = file_get_contents($f);
    if (preg_match_all('#(?:html|body)[^{]*\{[^}]*overflow[^}]*\}#i', $c, $m)) {
        echo basename($f) . ":\n";
        foreach ($m[0] as $rule) {
            echo "  $rule\n";
        }
    }
}
