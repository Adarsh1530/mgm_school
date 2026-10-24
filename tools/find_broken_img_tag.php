<?php
$files = [
    'templates/header.php',
    'templates/offcanvas.php',
    'templates/breadcrumb.php',
    'templates/footer.php'
];

foreach ($files as $f) {
    $content = file_get_contents(__DIR__ . '/../' . $f);
    preg_match_all('#<img[^>]*>#i', $content, $m);
    echo "$f: " . count($m[0]) . " imgs\n";
    foreach ($m[0] as $img) {
        echo "   $img\n";
    }
}
