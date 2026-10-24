<?php
$c = file_get_contents('assets/css/hero.css');
preg_match_all('#https?://[^\)\'\"\s]+#', $c, $m);
echo "URLs in hero.css: " . count($m[0]) . "\n";
foreach (array_unique($m[0]) as $u) {
    echo "  $u\n";
}
