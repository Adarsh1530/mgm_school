<?php
$css = file_get_contents(__DIR__ . '/../assets/css/font-awesome-pro.css');
preg_match_all('#url\([\'"]?([^\'")]+)[\'"]?\)#i', $css, $m);
echo "URLs in font-awesome-pro.css: " . count($m[1]) . "\n";
foreach (array_unique($m[1]) as $u) {
    echo "  $u\n";
}
