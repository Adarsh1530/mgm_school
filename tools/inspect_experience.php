<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');
$idx = strpos($html, 'Years of');
if ($idx !== false) {
    echo substr($html, $idx - 1000, 1500) . "\n";
}
