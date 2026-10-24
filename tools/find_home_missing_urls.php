<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
$needles = [
    'Untitled-design-4',
    'Untitled-design-16',
    'iconservice-1',
    'iconservice-2',
    'iconservice-3',
    'iconservice-4',
    'image_00',
    'testimonial-shape'
];

foreach ($needles as $n) {
    preg_match_all('#https?://[^\s"\'\)]*' . $n . '[^\s"\'\)]*#i', $html, $m);
    echo "=== Needle: $n ===\n";
    foreach (array_unique($m[0]) as $u) {
        echo "   $u\n";
    }
}
