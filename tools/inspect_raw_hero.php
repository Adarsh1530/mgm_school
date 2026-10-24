<?php
$html = file_get_contents('audit/homepage_full.html');
$heroStart = strpos($html, '<section class="tp-hero-area');
$heroEnd = strpos($html, '</section>', $heroStart) + 10;
echo substr($html, $heroStart, $heroEnd - $heroStart);
