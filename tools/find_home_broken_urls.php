<?php
$html = file_get_contents('audit/homepage_full.html');
$imgs = [
  'about-1-icon.png',
  'services-3-icon-4.png',
  'layer.png',
  'designtools.png',
  'command.png',
  'language-square.png',
  'bucket.png',
  '1733381285-removebg-preview',
  'cta-shape-1.png',
  'unnamed-5.webp',
  '2.png',
  '3.png',
  'unnamed-4.webp'
];

foreach ($imgs as $img) {
    preg_match_all('#https?://[^\s"\'\)]*' . preg_quote($img, '#') . '[^\s"\'\)]*#i', $html, $m);
    echo "=== $img ===\n";
    foreach (array_unique($m[0]) as $u) {
        echo "  $u\n";
    }
}
