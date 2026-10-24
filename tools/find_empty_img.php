<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');
preg_match_all('#<img[^>]*>#i', $html, $m);
foreach ($m[0] as $img) {
    preg_match('#src=[\'"]([^\'"]*)[\'"]#i', $img, $src);
    $s = $src[1] ?? '';
    if (empty($s) || $s === '/' || $s === 'http://localhost/MGM SCHOOL/') {
        echo "Found empty/broken img tag:\n$img\n";
    }
}
