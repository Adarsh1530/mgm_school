<?php
$nav = json_decode(file_get_contents('audit/nav_and_layout.json'), true);
echo "Original Footer Snippet:\n";
echo substr($nav['footerSnippet'] ?? '', 0, 1500) . "\n";
