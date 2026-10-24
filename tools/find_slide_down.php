<?php
$c = file_get_contents('assets/css/acadia-core.css');
$pos = strpos($c, 'headerSlideDown');
if ($pos !== false) {
    echo substr($c, $pos - 50, 400);
} else {
    echo "headerSlideDown not found\n";
}
