<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();
$stmt = $db->query('SELECT slug, content_html FROM pages');
$missing = [];
$totalFound = 0;

while ($r = $stmt->fetch()) {
    $slug = $r['slug'];
    preg_match_all('#assets/(images|docs)/([^\s"\'\)]+)#i', $r['content_html'], $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $type = $m[1]; // images or docs
        $file = $m[2];
        $diskPath = __DIR__ . '/../assets/' . $type . '/' . $file;
        $totalFound++;
        if (!file_exists($diskPath)) {
            $missing[] = [
                'page' => $slug,
                'type' => $type,
                'file' => $file,
                'expected' => $diskPath
            ];
        }
    }
}

// Also check views/home.php
$homeHtml = file_get_contents(__DIR__ . '/../views/home.php');
preg_match_all('#assets/(images|docs)/([^\s"\'\)]+)#i', $homeHtml, $matches, PREG_SET_ORDER);
foreach ($matches as $m) {
    $type = $m[1];
    $file = $m[2];
    $diskPath = __DIR__ . '/../assets/' . $type . '/' . $file;
    $totalFound++;
    if (!file_exists($diskPath)) {
        $missing[] = [
            'page' => 'home',
            'type' => $type,
            'file' => $file,
            'expected' => $diskPath
        ];
    }
}

echo "Total asset references checked: $totalFound\n";
echo "Total missing on disk: " . count($missing) . "\n";
if (count($missing) > 0) {
    foreach ($missing as $m) {
        echo " [MISSING] [{$m['page']}] {$m['type']}/{$m['file']}\n";
    }
} else {
    echo "ALL REFERENCED ASSETS EXIST ON DISK!\n";
}
