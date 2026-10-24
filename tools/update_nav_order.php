<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();

// Update About dropdown items order & label
$pdo->query("UPDATE navigation SET sort_order = 1 WHERE id = 9"); // About Us
$pdo->query("UPDATE navigation SET sort_order = 2 WHERE id = 7"); // Our Founder
$pdo->query("UPDATE navigation SET sort_order = 3, label = 'Vision & Mission' WHERE id = 8"); // Vision & Mission

echo "Updated About dropdown order successfully!\n";
