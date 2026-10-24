<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();

$meritContent = file_get_contents(__DIR__ . '/../views/merit-day.php');
// Extract inner body content between breadcrumb and footer
$startTag = '<div class="tp-subpage-container py-5"';
$endTag = '<?php require_once __DIR__ . \'/../templates/footer.php\'; ?>';
$startPos = strpos($meritContent, $startTag);
$endPos = strpos($meritContent, $endTag);

if ($startPos !== false && $endPos !== false) {
    $contentHtml = substr($meritContent, $startPos, $endPos - $startPos);
    $stmt = $pdo->prepare("UPDATE pages SET content_html = ? WHERE slug = 'merit-day'");
    $stmt->execute([$contentHtml]);
    echo "Updated pages table for merit-day! Rows: " . $stmt->rowCount() . "\n";
} else {
    echo "Could not parse merit-day content bounds.\n";
}
