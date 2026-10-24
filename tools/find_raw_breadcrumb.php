<?php
$html = file_get_contents(__DIR__ . '/../audit/raw_pages/mandatory-disclosure_full.html');
$pos = strpos($html, 'tp-breadcrumb');
if ($pos !== false) {
    echo substr($html, $pos - 200, 1200);
} else {
    echo "tp-breadcrumb not found\n";
}
