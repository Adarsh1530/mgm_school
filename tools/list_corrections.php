<?php
$dir = "C:/Users/KEERTHI ADARSH M P/Desktop/mgm school corrections/";
$files = scandir($dir);
foreach ($files as $f) {
    if ($f === '.' || $f === '..') continue;
    $sz = getimagesize($dir . $f);
    echo "$f: {$sz[0]}x{$sz[1]} (" . round(filesize($dir . $f)/1024) . " KB)\n";
}
