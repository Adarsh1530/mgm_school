<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');
$pos = strpos($html, '<section class="tp-hero-area');
$end = strpos($html, '</section>', $pos) + 10;
echo substr($html, $pos, $end - $pos);
