<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_full.html');
echo substr($html, 170000, 300);
