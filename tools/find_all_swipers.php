<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');
preg_match_all('#<div[^>]*class="[^"]*swiper[^"]*"[^>]*>#i', $html, $swipers);
echo "Total swipers found: " . count($swipers[0]) . "\n";
foreach ($swipers[0] as $s) {
    echo "  $s\n";
}
