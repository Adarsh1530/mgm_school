<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');
preg_match_all('#class="swiper-slide[^"]*"[^>]*style="([^"]*)"#i', $html, $m);
echo "Swiper slides with inline style: " . count($m[0]) . "\n";
foreach ($m[1] as $s) {
    echo "  Slide style: $s\n";
}
