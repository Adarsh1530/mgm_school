<?php
putenv('FORCE_SQLITE=1');
require_once __DIR__ . '/../config/config.php';

$db = getDB();
echo "Driver: " . $db->getAttribute(PDO::ATTR_DRIVER_NAME) . "\n";
echo "School Setting: " . get_setting('school_name', 'MGM') . "\n";
echo "Top Nav Count: " . count(get_navigation_tree()) . "\n";
echo "Notices Count: " . count(get_active_notices()) . "\n";
echo "Ticker Count: " . count(get_ticker_notices()) . "\n";
$aboutPage = get_page_by_slug('about-us');
echo "About-Us Page: " . ($aboutPage ? 'FOUND (id: ' . $aboutPage['id'] . ')' : 'NOT FOUND') . "\n";
$contactPage = get_page_by_slug('contact');
echo "Contact Page: " . ($contactPage ? 'FOUND (id: ' . $contactPage['id'] . ')' : 'NOT FOUND') . "\n";
$noticesPage = get_page_by_slug('notices');
echo "Notices Page: " . ($noticesPage ? 'FOUND (id: ' . $noticesPage['id'] . ')' : 'NOT FOUND') . "\n";
