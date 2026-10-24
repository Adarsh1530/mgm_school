<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$json = json_decode(file_get_contents(__DIR__ . '/../audit/live_deep_audit/live_site_scraped_data.json'), true);
$db = Database::getConnection();

$pages = [
  'mandatory-disclosure',
  'yoga',
  'voice-of-mgm',
  'hindustan-scouts-guides',
  'swimming-pool',
  'ncc',
  'attendance',
  'admission-procedure',
  'alumni',
  'merit-day',
  'pta',
  'courses-offered',
  'our-founder',
  'gallery',
  'our-mission',
  'about-us'
];

foreach ($pages as $slug) {
    $live = $json[$slug] ?? null;
    if (!$live) continue;

    $stmt = $db->prepare("SELECT content_html FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    $localRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $localHtml = $localRow['content_html'] ?? '';

    // Extract significant phrases from live text to check if they exist in localHtml
    $liveText = $live['fullText'] ?? '';
    // Split into sentences / paragraphs
    $lines = array_filter(array_map('trim', explode("\n", $liveText)), function($l) {
        // filter out common nav items
        $ignore = ['Home', 'About Us', 'Academics', 'Activities', 'Mandatory Disclosure', 'Contact', 'Welcome To..!', 'CONTACT US', 'FOLLOW US', 'Quick Links', 'Reach Us', 'Our Newsletter', 'Search', 'Subscribe'];
        return strlen($l) > 15 && !in_array($l, $ignore);
    });

    $missingPhrases = [];
    foreach ($lines as $line) {
        // Normalize spaces
        $cleanLine = preg_replace('/\s+/', ' ', $line);
        // Take a unique 30-char slice if long
        $checkSnippet = substr($cleanLine, 0, min(40, strlen($cleanLine)));
        // Check in local strip_tags
        $localPlain = preg_replace('/\s+/', ' ', strip_tags($localHtml));
        if (stripos($localPlain, $checkSnippet) === false && stripos($localHtml, $checkSnippet) === false) {
            // Also test decoded
            if (stripos(html_entity_decode($localPlain), $checkSnippet) === false) {
                $missingPhrases[] = $line;
            }
        }
    }

    echo "PAGE: /$slug/\n";
    if (empty($missingPhrases)) {
        echo "  [OK] All live text content verified present locally!\n";
    } else {
        echo "  [MISMATCH] " . count($missingPhrases) . " phrase(s) from live not found in local:\n";
        foreach (array_slice($missingPhrases, 0, 5) as $mp) {
            echo "    - \"$mp\"\n";
        }
    }
}
