<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

echo "--- CHECKING mandatory_disclosures table ---\n";
$stmt = $pdo->query("SELECT id, title, file_url, file_name FROM mandatory_disclosures");
while ($r = $stmt->fetch()) {
    $exists = file_exists(__DIR__ . '/../' . $r['file_url']) ? 'EXISTS' : 'MISSING';
    $sz = $exists === 'EXISTS' ? filesize(__DIR__ . '/../' . $r['file_url']) : 0;
    echo "ID {$r['id']}: {$r['title']} => {$r['file_url']} ($exists, $sz bytes)\n";
}

echo "\n--- CHECKING links inside pages.content_html for mandatory-disclosure ---\n";
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'mandatory-disclosure'");
$stmt->execute();
$html = $stmt->fetchColumn();

preg_match_all('#href="([^"]+\.pdf)"#i', $html, $matches);
foreach (array_unique($matches[1]) as $link) {
    $cleanLink = ltrim($link, '/');
    if (strpos($cleanLink, 'http') === 0) {
        $p = parse_url($cleanLink, PHP_URL_PATH);
        $cleanLink = ltrim($p, '/');
        if (strpos($cleanLink, 'MGM%20SCHOOL/') === 0) {
            $cleanLink = substr($cleanLink, strlen('MGM%20SCHOOL/'));
        }
    }
    $exists = file_exists(__DIR__ . '/../' . $cleanLink) ? 'EXISTS' : 'MISSING';
    $sz = $exists === 'EXISTS' ? filesize(__DIR__ . '/../' . $cleanLink) : 0;
    echo "$link => $cleanLink ($exists, $sz bytes)\n";
}
