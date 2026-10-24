<?php
$source = "C:/Users/KEERTHI ADARSH M P/Desktop/mgm school udpation/new mgm logo.jpeg";
$im = imagecreatefromjpeg($source);
$w = imagesx($im);
$h = imagesy($im);
echo "w=$w, h=$h\n";
// inspect corners
$c00 = imagecolorat($im, 0, 0);
$c01 = imagecolorat($im, 0, $h-1);
$c10 = imagecolorat($im, $w-1, 0);
$c11 = imagecolorat($im, $w-1, $h-1);
printf("Top-left: #%06X\n", $c00);
printf("Bottom-left: #%06X\n", $c01);
printf("Top-right: #%06X\n", $c10);
printf("Bottom-right: #%06X\n", $c11);
