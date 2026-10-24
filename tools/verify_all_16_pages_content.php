<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$json = json_decode(file_get_contents(__DIR__ . '/../audit/live_deep_audit/live_site_scraped_data.json'), true);
$db = Database::getConnection();

echo "========================================================================\n";
echo "       DEEP VERIFICATION OF ALL 16 PAGES (CONTENT & MARKUP)            \n";
echo "========================================================================\n\n";

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
    if (!$live) {
        echo "[$slug] NOT FOUND in live scraped data!\n";
        continue;
    }

    $stmt = $db->prepare("SELECT * FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    $local = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "PAGE: /$slug/\n";
    echo "  Live WP ID: " . ($live['wpId'] ?? 'N/A') . " | Local WP ID: " . ($local['wp_id'] ?? 'N/A') . "\n";
    echo "  Live Title: {$live['title']} | Local Title: {$local['title']}\n";
    
    // Check images in live
    $liveImgSrcs = array_map(function($img) {
        return basename(parse_url($img['src'], PHP_URL_PATH));
    }, $live['images'] ?? []);
    // Filter out header/footer images (logo, etc.)
    $liveContentImgs = array_filter($liveImgSrcs, function($src) {
        return !in_array($src, ['cropped-1733381285-removebg-preview.png', 'download-pdf.png', 'breadcrumb-bg.jpg']);
    });

    $localContent = $local['content_html'] ?? '';

    $missingImgs = [];
    foreach ($liveContentImgs as $img) {
        if (strpos($localContent, $img) === false) {
            $missingImgs[] = $img;
        }
    }

    // Check doc links
    $liveDocs = array_map(function($d) {
        return basename(parse_url($d['href'], PHP_URL_PATH));
    }, $live['docLinks'] ?? []);

    $missingDocs = [];
    foreach ($liveDocs as $doc) {
        if (strpos($localContent, $doc) === false) {
            $missingDocs[] = $doc;
        }
    }

    echo "  Live Content Images: " . count($liveContentImgs) . " | Missing in local: " . (empty($missingImgs) ? "0 (ALL PRESENT)" : implode(', ', $missingImgs)) . "\n";
    if (!empty($liveDocs)) {
        echo "  Live Docs: " . count($liveDocs) . " | Missing in local: " . (empty($missingDocs) ? "0 (ALL PRESENT)" : implode(', ', $missingDocs)) . "\n";
    }

    echo "------------------------------------------------------------------------\n";
}
