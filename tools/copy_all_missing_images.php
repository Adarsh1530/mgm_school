<?php
$srcDir = "C:/Users/KEERTHI ADARSH M P/Desktop/mgm school udpation/";
$destDir = __DIR__ . "/../assets/images/";

$files = scandir($srcDir);
$copied = 0;
foreach ($files as $f) {
    if ($f === '.' || $f === '..' || is_dir($srcDir . $f)) continue;
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
        $clean = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '-', pathinfo($f, PATHINFO_FILENAME))) . '.' . $ext;
        // copy with clean name
        copy($srcDir . $f, $destDir . $clean);
        $copied++;
    }
}
echo "Copied $copied image files cleanly.\n";
