<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
preg_match_all('#<section[^>]*class="([^"]*)"#i', $html, $sections);
echo "Sections in homepage_full.html: " . count($sections[0]) . "\n";
foreach ($sections[1] as $s) {
    echo "  Section class: $s\n";
}
