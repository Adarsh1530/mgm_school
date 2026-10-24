<?php
/**
 * Export MariaDB database to database.sql and database/database.sql
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();

$tables = [];
$stmt = $pdo->query("SHOW TABLES");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

$output = "-- MGM Model School Database Dump\n";
$output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$output .= "-- Server version: MariaDB 10.4 / MySQL 8.x\n\n";
$output .= "SET FOREIGN_KEY_CHECKS=0;\n";
$output .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$output .= "SET time_zone = \"+00:00\";\n\n";

foreach ($tables as $table) {
    $create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_NUM);
    $output .= "DROP TABLE IF EXISTS `$table`;\n";
    $output .= $create[1] . ";\n\n";

    $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($rows)) {
        $output .= "INSERT INTO `$table` VALUES\n";
        $valStrings = [];
        foreach ($rows as $r) {
            $vals = [];
            foreach ($r as $val) {
                if ($val === null) {
                    $vals[] = "NULL";
                } else {
                    $vals[] = $pdo->quote($val);
                }
            }
            $valStrings[] = "(" . implode(", ", $vals) . ")";
        }
        $output .= implode(",\n", $valStrings) . ";\n\n";
    }
}

$output .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents(__DIR__ . '/../database.sql', $output);
if (!is_dir(__DIR__ . '/../database')) {
    mkdir(__DIR__ . '/../database', 0777, true);
}
file_put_contents(__DIR__ . '/../database/database.sql', $output);

echo "Exported database successfully! (" . strlen($output) . " bytes)\n";
