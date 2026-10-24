<?php
$html = file_get_contents('audit/footer_complete.html');
echo substr($html, 0, 1500) . "\n";
