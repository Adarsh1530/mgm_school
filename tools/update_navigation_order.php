<?php
require_once __DIR__ . '/../config/config.php';

$db = getDB();

// 1. Check if Notices exists in navigation
$stmt = $db->query("SELECT id FROM navigation WHERE url LIKE '%/notices/%' OR label = 'Notices' LIMIT 1");
$noticesNav = $stmt->fetch();

if (!$noticesNav) {
    $db->exec("INSERT INTO navigation (label, url, parent_id, sort_order) VALUES ('Notices', '/notices/', NULL, 6)");
    echo "Inserted Notices into navigation.\n";
} else {
    $db->prepare("UPDATE navigation SET label = 'Notices', url = '/notices/', parent_id = NULL, sort_order = 6 WHERE id = :id")->execute([':id' => $noticesNav['id']]);
    echo "Updated existing Notices item.\n";
}

// 2. Detach Gallery from Activities and set as standalone top-level with sort_order = 5
$db->exec("UPDATE navigation SET parent_id = NULL, sort_order = 5 WHERE url LIKE '%/gallery/%' OR label = 'Gallery'");
echo "Updated Gallery to standalone top-level with sort_order = 5.\n";

// 3. Set Mandatory Disclosure to sort_order = 7
$db->exec("UPDATE navigation SET parent_id = NULL, sort_order = 7 WHERE url LIKE '%/mandatory-disclosure/%' OR label = 'Mandatory Disclosure'");

// 4. Set Contact to sort_order = 8
$db->exec("UPDATE navigation SET parent_id = NULL, sort_order = 8 WHERE url LIKE '%/contact/%' OR label = 'Contact'");

// 5. Verify Activities children
$stmt = $db->query("SELECT id, label, url, sort_order FROM navigation WHERE parent_id = 4 ORDER BY sort_order ASC");
$activitiesChildren = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Re-index Activities children sort_order 1..8
$order = 1;
foreach ($activitiesChildren as $child) {
    $db->prepare("UPDATE navigation SET sort_order = :ord WHERE id = :id")->execute([':ord' => $order++, ':id' => $child['id']]);
}

// 6. Display full top-level tree
$stmt = $db->query("SELECT id, label, url, sort_order FROM navigation WHERE parent_id IS NULL ORDER BY sort_order ASC");
$topItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\n--- TOP LEVEL NAVIGATION ORDER ---\n";
foreach ($topItems as $item) {
    echo "{$item['sort_order']}. {$item['label']} ({$item['url']})\n";
}

echo "\n--- ACTIVITIES SUB-ITEMS ---\n";
$stmt = $db->query("SELECT id, label, url, sort_order FROM navigation WHERE parent_id = 4 ORDER BY sort_order ASC");
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $child) {
    echo "   - {$child['label']} ({$child['url']})\n";
}
