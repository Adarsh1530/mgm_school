<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_content.html');
echo "Length: " . strlen($html) . "\n";
echo "Last 500 chars:\n" . substr($html, -500);
