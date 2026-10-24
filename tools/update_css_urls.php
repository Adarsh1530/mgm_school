<?php
$cssFiles = glob(__DIR__ . '/../assets/css/*.css');
foreach ($cssFiles as $f) {
    $content = file_get_contents($f);
    $replaced = preg_replace_callback('#https?://mgm-school\.nbtksa\.in/wp-content/uploads/\d{4}/\d{2}/([^"\')\s]+)#', function($m) {
        return '../images/' . basename($m[1]);
    }, $content);
    if ($replaced !== $content) {
        file_put_contents($f, $replaced);
        echo "Updated URLs in " . basename($f) . "\n";
    }
}
