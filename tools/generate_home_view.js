const fs = require('fs');

let homeHtml = fs.readFileSync('audit/homepage_content.html', 'utf8');

// Replace remote URLs with local asset URLs
homeHtml = homeHtml.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
homeHtml = homeHtml.replace(/https?:\/\/wp\.themepure\.net\/acadia\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
homeHtml = homeHtml.replace(/https?:\/\/mgm-school\.nbtksa.in/g, '');

const viewPhp = `<?php
/**
 * Exact MGM Model School Homepage View
 */
require_once __DIR__ . '/../config/config.php';

$pageTitle = "Home";
$currentSlug = "";
$wpId = 1119;

require_once __DIR__ . '/../templates/header.php';
?>

<main id="content" class="site-main">
${homeHtml}
</main>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
`;

fs.writeFileSync('views/home.php', viewPhp);
console.log('Saved exact views/home.php successfully!');
