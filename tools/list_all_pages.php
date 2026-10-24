<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
echo "--- ALL PAGES ---\n";
foreach ($pdo->query("SELECT id, slug, title FROM pages") as $row) {
    echo "ID {$row['id']}: [{$row['slug']}] {$row['title']}\n";
}

echo "\n--- NAVIGATION MENU ---\n";
foreach ($pdo->query("SELECT id, parent_id, label, url, sort_order FROM navigation ORDER BY parent_id, sort_order") as $row) {
    echo "ID {$row['id']} (parent {$row['parent_id']}): {$row['label']} -> {$row['url']} (order {$row['sort_order']})\n";
}
