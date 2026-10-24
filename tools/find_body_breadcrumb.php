<?php
$html = file_get_contents(__DIR__ . '/../audit/raw_pages/mandatory-disclosure_full.html');
$pos = strpos($html, '<section', strpos($html, '<body'));
if ($pos !== false) {
    echo substr($html, $pos, 1500);
} else {
    // search for tp-breadcrumb in body
    $pos2 = strpos($html, 'tp-breadcrumb', strpos($html, '<body'));
    if ($pos2 !== false) {
        echo substr($html, $pos2 - 100, 1500);
    } else {
        echo "No breadcrumb in body\n";
    }
}
