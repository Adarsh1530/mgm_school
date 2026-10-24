const fs = require('fs');

// Read the raw html of gallery
const pages = JSON.parse(fs.readFileSync('audit/all_pages_clean.json', 'utf8'));
let galHtml = pages['gallery'].rawHtml;

// Replace remote paths with local paths
galHtml = galHtml.replace(/https?:\/\/mgm-school\.nbtksa.in\/wp-content\/uploads\/[0-9]{4}\/[0-9]{2}\/([^\s"'<>]+\.(?:jpg|jpeg|png|webp|gif|svg))/gi, 'assets/images/$1');
galHtml = galHtml.replace(/https?:\/\/mgm-school\.nbtksa.in/g, '');

// Convert empty data-thumbnail divs to actual img tags
// e.g. <div class="e-gallery-image elementor-gallery-item__image" data-thumbnail="assets/images/1752478940.jpeg" data-width="300" data-height="300" aria-label="" role="img" ></div>
galHtml = galHtml.replace(/<div class="e-gallery-image elementor-gallery-item__image" data-thumbnail="([^"]+)"[^>]*><\/div>/gi, (match, src) => {
  return `<img class="e-gallery-image" src="${src}" alt="Gallery Photo" loading="lazy">`;
});

function escapeSql(str) {
  if (str === null || str === undefined) return 'NULL';
  return "'" + String(str).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

const sql = `UPDATE pages SET content_html = ${escapeSql(galHtml)} WHERE slug = 'gallery';\n`;
fs.writeFileSync('audit/update_gallery.sql', sql);
console.log('Saved audit/update_gallery.sql');
