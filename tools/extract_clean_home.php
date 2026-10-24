<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');

$start = strpos($html, '<div data-elementor-type="wp-page" data-elementor-id="1119"');
$end = strpos($html, '<div data-elementor-type="wp-post" data-elementor-id="200"');
if ($end === false) {
    $end = strpos($html, '<footer');
}

$pageHtml = substr($html, $start, $end - $start);
echo "Extracted length: " . strlen($pageHtml) . "\n";

// Replace remote image URLs
$pageHtml = preg_replace('#https?://mgm-school\.nbtksa\.in/wp-content/uploads/\d{4}/\d{2}/([^"\')\s]+)#i', 'assets/images/$1', $pageHtml);
$pageHtml = preg_replace('#https?://wp\.themepure\.net/acadia/wp-content/uploads/\d{4}/\d{2}/([^"\')\s]+)#i', 'assets/images/$1', $pageHtml);
$pageHtml = preg_replace('#https?://mgm-school\.nbtksa\.in/#i', '/', $pageHtml);

file_put_contents(__DIR__ . '/../audit/homepage_clean_extracted.html', $pageHtml);
echo "Saved to audit/homepage_clean_extracted.html\n";
echo "First 200 chars:\n" . substr($pageHtml, 0, 200) . "\n";
echo "Last 200 chars:\n" . substr($pageHtml, -200) . "\n";
