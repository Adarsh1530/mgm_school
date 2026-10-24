<?php
$html = file_get_contents(__DIR__ . '/../audit/raw_pages/mandatory-disclosure_full.html');
$start = strpos($html, '<div data-elementor-type="wp-post" data-elementor-id="6225"');
$end = strpos($html, '<div data-elementor-type="wp-page"', $start);
echo substr($html, $start, $end - $start);
