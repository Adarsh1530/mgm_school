<?php
$specs = json_decode(file_get_contents('audit/full_page_specs.json'), true);
foreach ($specs as $s) {
    if (!empty($s['logoStyles'])) {
        echo "Logo styles: " . json_encode($s['logoStyles']) . "\n";
        break;
    }
}
$nav = json_decode(file_get_contents('audit/nav_and_layout.json'), true);
echo "Logo snippet: " . ($nav['headerSnippet'] ?? '') . "\n";
