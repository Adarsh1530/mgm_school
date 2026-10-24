<?php
$list = [
    'course-offered.jpeg',
    'admission-procedure.jpeg',
    'vission-and-mission.jpeg',
    'fee-structure.jpeg',
    'new-fee-structure.jpeg',
    'smc-list.jpeg',
    'strength.jpeg',
    'about-us.jpeg',
    'about-the-school-image.jpeg',
    'maths-zone.jpeg',
    'ominis.jpeg',
    'canteen.jpeg'
];
foreach ($list as $img) {
    $path = "assets/images/" . $img;
    if (file_exists($path)) {
        $sz = getimagesize($path);
        echo "$img: {$sz[0]}x{$sz[1]} ({$sz['mime']})\n";
    } else {
        echo "$img: NOT FOUND\n";
    }
}
