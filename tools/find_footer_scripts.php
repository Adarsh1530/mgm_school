<?php
$html = file_get_contents(__DIR__ . '/../audit/raw_pages/mandatory-disclosure_full.html');
preg_match_all('#<script[^>]*src="([^"]+)"[^>]*></script>#i', $html, $m);
echo "Total external scripts in reference site: " . count($m[1]) . "\n";
foreach ($m[1] as $s) {
    if (strpos($s, 'googletagmanager') === false && strpos($s, 'analytics') === false) {
        echo "  " . basename(parse_url($s, PHP_URL_PATH)) . " => " . $s . "\n";
    }
}
