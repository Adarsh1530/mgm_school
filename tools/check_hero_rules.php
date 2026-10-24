<?php
$c = file_get_contents('assets/css/hero.css');
preg_match_all('#\.tp-hero-[a-z0-9_\-]+[^{]*\{[^}]*\}#i', $c, $m);
echo "Hero rules: " . count($m[0]) . "\n";
foreach (array_slice($m[0], 0, 15) as $r) {
    echo "  $r\n";
}
