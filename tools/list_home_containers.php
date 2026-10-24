<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
$start = strpos($html, '<div data-elementor-type="wp-page" data-elementor-id="1119"');
$end = strpos($html, '<div data-elementor-type="wp-post" data-elementor-id="200"');
$content = substr($html, $start, $end - $start);

preg_match_all('#<div class="elementor-element elementor-element-([a-z0-9]+)[^"]*e-parent[^"]*"[^>]*data-id="([a-z0-9]+)"#i', $content, $parents);
echo "Total top-level e-parent containers in homepage: " . count($parents[0]) . "\n";
foreach ($parents[2] as $id) {
    // find what widgets are inside this parent container
    $pStart = strpos($content, 'data-id="' . $id . '"');
    $sub = substr($content, $pStart, 1500);
    preg_match_all('#data-widget_type="([^"]+)"#i', $sub, $widgets);
    echo "  Container data-id=$id widgets: " . implode(', ', array_unique($widgets[1])) . "\n";
}
