<?php
$files = ['assets/css/custom.css', 'assets/css/acadia-core.css', 'assets/css/style.css'];
foreach ($files as $f) {
    if (file_exists($f)) {
        $c = file_get_contents($f);
        preg_match_all('#\.has-dropdown[^{]*\{[^}]*\}#i', $c, $m);
        echo "$f: " . count($m[0]) . " rules\n";
        foreach (array_slice($m[0], 0, 5) as $rule) {
            echo "  $rule\n";
        }
    }
}
