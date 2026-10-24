<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
preg_match_all('#<link[^>]*rel=[\'"]stylesheet[\'"][^>]*>#i', $html, $links);
echo "Total CSS links in reference homepage: " . count($links[0]) . "\n";
foreach ($links[0] as $l) {
    preg_match('#href=[\'"]([^\'"]+)[\'"]#i', $l, $m);
    if ($m) {
        echo "  " . $m[1] . "\n";
    }
}
