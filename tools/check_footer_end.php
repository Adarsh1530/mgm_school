<?php
$html = file_get_contents(__DIR__ . '/../audit/footer_complete.html');
echo "Length: " . strlen($html) . "\n";
echo "Last 400 chars:\n" . substr($html, -400);
