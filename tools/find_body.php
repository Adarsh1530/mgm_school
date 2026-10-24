<?php
$html = file_get_contents(__DIR__ . '/../audit/raw_pages/mandatory-disclosure_full.html');
preg_match('#<body[^>]*>#i', $html, $m);
echo $m[0] ?? "Not found\n";
