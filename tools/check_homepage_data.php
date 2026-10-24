<?php
$json = json_decode(file_get_contents(__DIR__ . '/../audit/live_deep_audit/live_site_scraped_data.json'), true);
$home = $json['home'];

echo "=== HOMEPAGE LIVE DATA ===\n";
echo "Title: " . $home['title'] . "\n";
echo "Meta Desc: " . $home['metaDesc'] . "\n";
echo "\n--- HEADINGS ---\n";
foreach ($home['headings'] as $h) {
    echo "  [{$h['tag']}] {$h['text']}\n";
}

echo "\n--- IMAGES COUNT: " . count($home['images']) . " ---\n";
$images = array_map(function($i) { return basename($i['src']); }, $home['images']);
echo "Sample Images:\n  " . implode("\n  ", array_slice(array_unique($images), 0, 15)) . "\n";
