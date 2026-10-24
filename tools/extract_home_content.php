<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
$startPos = strpos($html, '<div data-elementor-type="wp-page" data-elementor-id="1119"');
echo "Start pos: $startPos\n";

// Find where footer starts
$footerPos = strpos($html, '<footer', $startPos);
if ($footerPos === false) {
    $footerPos = strpos($html, 'data-elementor-type="wp-post" data-elementor-id="843"', $startPos);
}
echo "Footer pos: $footerPos\n";

if ($startPos !== false && $footerPos !== false) {
    $pageHtml = substr($html, $startPos, $footerPos - $startPos);
    echo "Extracted pageHtml length: " . strlen($pageHtml) . "\n";
    echo "End of pageHtml (last 300 chars):\n" . substr($pageHtml, -300) . "\n";
    
    // Also check what comes after footerPos
    echo "At footerPos (first 300 chars):\n" . substr($html, $footerPos, 300) . "\n";
}
