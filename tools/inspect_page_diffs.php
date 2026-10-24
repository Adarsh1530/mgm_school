<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$json = json_decode(file_get_contents(__DIR__ . '/../audit/live_deep_audit/live_site_scraped_data.json'), true);
$db = Database::getConnection();

function inspectSlug($slug, $json, $db) {
    echo "========================================================\n";
    echo "PAGE: /$slug/\n";
    echo "========================================================\n";
    
    $live = $json[$slug] ?? null;
    if (!$live) {
        echo "Not found in live data!\n";
        return;
    }

    $stmt = $db->prepare("SELECT * FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    $local = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "--- LIVE HEADINGS ---\n";
    foreach ($live['headings'] as $h) {
        echo "  [{$h['tag']}] {$h['text']}\n";
    }

    echo "\n--- LIVE TEXT PREVIEW (first 500 chars) ---\n";
    echo substr($live['fullText'], 0, 500) . "\n...\n";

    echo "\n--- LOCAL TEXT PREVIEW (first 500 chars) ---\n";
    $localClean = strip_tags($local['content_html'] ?? '');
    echo substr($localClean, 0, 500) . "\n...\n";

    if (!empty($live['tables'])) {
        echo "\n--- LIVE TABLES (" . count($live['tables']) . ") ---\n";
        foreach ($live['tables'] as $idx => $t) {
            echo "Table #$idx: " . count($t) . " rows\n";
            foreach (array_slice($t, 0, 4) as $r) {
                echo "   | " . implode(" | ", $r) . "\n";
            }
        }
    }
    echo "\n\n";
}

inspectSlug('our-mission', $json, $db);
inspectSlug('our-founder', $json, $db);
inspectSlug('admission-procedure', $json, $db);
inspectSlug('courses-offered', $json, $db);
