<?php
require_once __DIR__ . '/../config/config.php';
$db = getDB();

echo "--- site_settings ---\n";
$stmt = $db->query("SELECT * FROM site_settings WHERE setting_value LIKE '%logo%' OR setting_value LIKE '%1733381285%'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "--- pages ---\n";
$stmt = $db->query("SELECT id, slug, title FROM pages WHERE content_html LIKE '%1733381285%'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
