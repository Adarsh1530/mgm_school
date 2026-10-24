<?php
$html = file_get_contents(__DIR__ . '/../audit/homepage_clean_extracted.html');
preg_match_all('#assets/(images|docs)/([^\s"\'\)]+)#i', $html, $matches, PREG_SET_ORDER);
$missing = [];
foreach ($matches as $m) {
    $path = __DIR__ . '/../assets/' . $m[1] . '/' . $m[2];
    if (!file_exists($path)) {
        $missing[] = $m[1] . '/' . $m[2];
    }
}
$missing = array_unique($missing);
echo "Total unique missing in homepage_clean_extracted: " . count($missing) . "\n";
foreach ($missing as $f) {
    echo "  Missing: $f\n";
}
