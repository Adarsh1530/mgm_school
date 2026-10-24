<?php
$html = file_get_contents(__DIR__ . '/../audit/footer_complete.html');
echo "Footer length: " . strlen($html) . "\n";

// Let's check what images and links are inside
preg_match_all('#https?://mgm-school\.nbtksa\.in[^\s"\'\)]+#', $html, $m);
echo "MGM URLs: " . count($m[0]) . "\n";
foreach (array_unique($m[0]) as $u) {
    echo "  $u\n";
}
