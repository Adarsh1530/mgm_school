<?php
$nav = json_decode(file_get_contents('audit/nav_and_layout.json'), true);
echo "Keys: " . implode(', ', array_keys($nav)) . "\n";
echo "Header length: " . strlen($nav['headerSnippet'] ?? '') . "\n";
