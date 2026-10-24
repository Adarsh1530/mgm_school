<?php
$c = file_get_contents('assets/css/acadia-core.css');
preg_match_all('#[^\n\}]*header-sticky[^\n\{]*\{[^\}]*\}#i', $c, $m);
foreach ($m[0] as $r) {
    echo "$r\n";
}
