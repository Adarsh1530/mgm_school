<?php
$html = file_get_contents(__DIR__ . '/../audit/footer_complete.html');
// Replace remote images
$html = preg_replace('#https?://mgm-school\.nbtksa\.in/wp-content/uploads/\d{4}/\d{2}/([^"\')\s]+)#i', 'assets/images/$1', $html);
preg_match_all('#assets/(images|docs)/([^\s"\'\)]+)#i', $html, $matches, PREG_SET_ORDER);
$missing = [];
foreach ($matches as $m) {
    $path = __DIR__ . '/../assets/' . $m[1] . '/' . $m[2];
    if (!file_exists($path)) {
        $missing[] = $m[1] . '/' . $m[2];
    }
}
$missing = array_unique($missing);
echo "Missing in footer: " . count($missing) . "\n";
foreach ($missing as $f) {
    echo "  $f\n";
}
