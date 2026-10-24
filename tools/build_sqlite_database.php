<?php
require_once __DIR__ . '/../config/config.php';

$mysql = new PDO("mysql:host=127.0.0.1;dbname=mgm_school;charset=utf8mb4", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$sqliteFile = __DIR__ . '/../database/mgm_school.sqlite';
if (file_exists($sqliteFile)) {
    unlink($sqliteFile);
}

$sqlite = new PDO("sqlite:" . $sqliteFile, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

echo "Building SQLite database at $sqliteFile...\n";

// List tables to copy
$tables = ['site_settings', 'navigation', 'pages', 'notices', 'courses', 'gallery', 'mandatory_disclosures', 'admission_requirements', 'users'];

foreach ($tables as $table) {
    try {
        $check = $mysql->query("SHOW TABLES LIKE '$table'")->fetch();
        if (!$check) continue;

        // Get columns
        $cols = $mysql->query("DESCRIBE $table")->fetchAll();
        $colDefs = [];
        $colNames = [];
        foreach ($cols as $col) {
            $name = $col['Field'];
            $colNames[] = $name;
            $type = strtolower($col['Type']);
            if (strpos($type, 'int') !== false) {
                $sqlType = 'INTEGER';
            } elseif (strpos($type, 'char') !== false || strpos($type, 'text') !== false || strpos($type, 'enum') !== false) {
                $sqlType = 'TEXT';
            } else {
                $sqlType = 'TEXT';
            }
            if ($col['Key'] === 'PRI') {
                $colDefs[] = "`$name` $sqlType PRIMARY KEY" . (strpos($type, 'int') !== false ? ' AUTOINCREMENT' : '');
            } else {
                $colDefs[] = "`$name` $sqlType";
            }
        }

        $createSql = "CREATE TABLE IF NOT EXISTS `$table` (" . implode(', ', $colDefs) . ");";
        $sqlite->exec($createSql);

        // Copy data
        $rows = $mysql->query("SELECT * FROM `$table`")->fetchAll();
        if (!empty($rows)) {
            $placeholders = ':' . implode(', :', $colNames);
            $insertSql = "INSERT INTO `$table` (`" . implode('`, `', $colNames) . "`) VALUES ($placeholders)";
            $stmt = $sqlite->prepare($insertSql);

            foreach ($rows as $row) {
                $params = [];
                foreach ($colNames as $colName) {
                    $params[':' . $colName] = $row[$colName];
                }
                $stmt->execute($params);
            }
        }

        echo "  [OK] Table '$table' copied with " . count($rows) . " rows.\n";
    } catch (Exception $e) {
        echo "  [ERROR] Table '$table': " . $e->getMessage() . "\n";
    }
}

echo "SQLite database created successfully!\n";
