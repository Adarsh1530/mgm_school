<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
preg_match_all('#<div data-elementor-type="([^"]+)" data-elementor-id="([^"]+)"[^>]*>#', $html, $m, PREG_OFFSET_CAPTURE);
foreach ($m[0] as $i => $match) {
    echo "Match $i: type={$m[1][$i][0]}, id={$m[2][$i][0]} at offset {$match[1]}\n";
}
