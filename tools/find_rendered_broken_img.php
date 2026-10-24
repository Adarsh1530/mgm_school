<?php
require_once 'config/config.php';
$html = file_get_contents('audit/homepage_clean_extracted.html');
$rendered = render_content($html);
preg_match_all('#<img[^>]*>#i', $rendered, $m);
foreach ($m[0] as $img) {
    preg_match('#src=[\'"]([^\'"]*)[\'"]#i', $img, $src);
    $s = $src[1] ?? '';
    if (strpos($s, 'http://localhost/MGM%20SCHOOL/') === 0 && strlen($s) <= strlen('http://localhost/MGM%20SCHOOL/')) {
        echo "Found in rendered content:\n$img\n";
    }
}
