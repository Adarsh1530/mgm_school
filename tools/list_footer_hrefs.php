<?php
$html = file_get_contents(__DIR__ . '/../audit/footer_complete.html');
preg_match_all('#href="([^"]+)"#', $html, $m);
foreach (array_unique($m[1]) as $href) {
    echo "Href: $href\n";
}
