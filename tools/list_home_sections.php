<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_clean_extracted.html');
preg_match_all('#<section[^>]*class="([^"]*)"#i', $html, $sections);
echo "Sections in homepage_clean_extracted.html: " . count($sections[0]) . "\n";
foreach ($sections[1] as $s) {
    echo "  Section class: $s\n";
}
