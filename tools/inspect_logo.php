<?php
$source = "C:/Users/KEERTHI ADARSH M P/Desktop/mgm school udpation/new mgm logo.jpeg";
$old = "assets/images/cropped-1733381285-removebg-preview.png";
$target = "assets/images/new-mgm-logo.jpeg";

echo "Source size: " . json_encode(getimagesize($source)) . PHP_EOL;
echo "Old logo size: " . (file_exists($old) ? json_encode(getimagesize($old)) : "none") . PHP_EOL;
