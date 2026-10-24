<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$jsonPath = __DIR__ . '/../audit/live_deep_audit/live_site_scraped_data.json';
if (!file_exists($jsonPath)) {
    die("Error: scraped JSON not found.\n");
}
$liveData = json_decode(file_get_contents($jsonPath), true);

$db = Database::getConnection();

$stmt = $db->query("SELECT slug, title, content_html, meta_description FROM pages");
$localPages = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $localPages[$row['slug']] = $row;
}

$stmt2 = $db->query("SELECT setting_key, setting_value FROM site_settings");
$settings = [];
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

echo "========================================================\n";
echo "           LIVE SITE VS LOCAL DATABASE AUDIT            \n";
echo "========================================================\n\n";

echo "--- SITE SETTINGS ---\n";
echo "School Name: " . ($settings['school_name'] ?? '') . "\n";
echo "Phone 1:     " . ($settings['phone_primary'] ?? '') . "\n";
echo "Phone 2:     " . ($settings['phone_secondary'] ?? '') . "\n";
echo "Email:       " . ($settings['email_primary'] ?? '') . "\n";
echo "Address:     " . ($settings['school_address'] ?? '') . "\n\n";

echo "--- 16 PAGES COMPARISON ---\n";
printf("%-26s | %-32s | %-32s | %-10s | %-10s\n", "Slug", "Live Title", "Local Title", "Live Len", "Local Len");
echo str_repeat("-", 125) . "\n";

$mismatches = [];

foreach ($liveData as $slug => $live) {
    if ($slug === 'home') continue;

    $local = $localPages[$slug] ?? null;
    if (!$local) {
        echo "[MISSING LOCAL PAGE] /$slug/\n";
        continue;
    }

    $liveTitle = $live['title'] ?? '';
    $localTitle = $local['title'] ?? '';
    
    // Clean text length comparison
    $liveText = trim($live['fullText'] ?? '');
    // Remove header and footer text if included in live scrape
    $cleanLocalText = trim(strip_tags($local['content_html'] ?? ''));

    printf("%-26s | %-32s | %-32s | %-10d | %-10d\n", 
        substr($slug, 0, 26),
        substr($liveTitle, 0, 32),
        substr($localTitle, 0, 32),
        strlen($liveText),
        strlen($cleanLocalText)
    );

    // Deep checks:
    $pageDiscrepancies = [];

    // Check titles: on live site it is e.g. "Courses Offered – MGM School"
    $expectedTitle = $localTitle . " – MGM School";
    if ($liveTitle !== $expectedTitle && $liveTitle !== $localTitle) {
        $pageDiscrepancies[] = "Title variance: Live has '{$liveTitle}', Local has '{$localTitle}'";
    }

    // Check table presence
    $liveTablesCount = count($live['tables'] ?? []);
    $localHasTable = (strpos($local['content_html'], '<table') !== false);
    if ($liveTablesCount > 0 && !$localHasTable) {
        $pageDiscrepancies[] = "Live has $liveTablesCount table(s) but local content lacks <table> tag!";
    }

    // Check PDF/Doc links
    $liveDocLinks = $live['docLinks'] ?? [];
    if (!empty($liveDocLinks)) {
        foreach ($liveDocLinks as $doc) {
            $href = $doc['href'];
            $filename = basename($href);
            if (strpos($local['content_html'], $filename) === false) {
                $pageDiscrepancies[] = "Missing doc link in local content: $filename ($href)";
            }
        }
    }

    if (!empty($pageDiscrepancies)) {
        $mismatches[$slug] = $pageDiscrepancies;
    }
}

echo "\n========================================================\n";
echo "              DISCREPANCIES & FINDINGS                   \n";
echo "========================================================\n";

if (empty($mismatches)) {
    echo "NO structural mismatches found! All tables and doc links matched.\n";
} else {
    foreach ($mismatches as $slug => $issues) {
        echo "\n[/$slug/]:\n";
        foreach ($issues as $issue) {
            echo "  - $issue\n";
        }
    }
}
