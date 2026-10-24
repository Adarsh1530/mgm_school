<?php
$html = file_get_contents(__DIR__ . '/../audit/raw_pages/mandatory-disclosure_full.html');
$pos = strpos($html, 'data-elementor-type="wp-page"');
if ($pos !== false) {
    // print 500 chars before and 200 chars after
    echo substr($html, max(0, $pos - 400), 700);
} else {
    echo "Not found\n";
}
