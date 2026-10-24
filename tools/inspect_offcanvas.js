const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Search for offcanvas
const offcanvasMatch = html.match(/<div[^>]*class="[^"]*offcanvas[^"]*"[\s\S]*?<\/div>\s*<\/div>/gi);
console.log('Offcanvas matches:', offcanvasMatch ? offcanvasMatch.length : 0);
if (offcanvasMatch) {
  fs.writeFileSync('audit/offcanvas_raw.html', offcanvasMatch.join('\n---\n'));
  console.log('Saved audit/offcanvas_raw.html');
}

// Search for all <a> tags in html to see all internal URLs
const links = [];
const aRegex = /<a\s+[^>]*href=["']([^"']*)["'][^>]*>([\s\S]*?)<\/a>/gi;
let match;
while ((match = aRegex.exec(html)) !== null) {
  const href = match[1];
  const text = match[2].replace(/<[^>]+>/g, '').trim();
  if (href && (href.startsWith('/') || href.includes('mgm-school.nbtksa.in'))) {
    links.push({ text, href });
  }
}

console.log('Found internal links in mandatory-disclosure:', links.length);
fs.writeFileSync('audit/page_links.json', JSON.stringify(links, null, 2));

// Search for breadcrumbs and titles
const breadcrumbMatch = html.match(/<section[^>]*class="[^"]*breadcrumb[^"]*"[\s\S]*?<\/section>/gi);
console.log('Breadcrumb section matches:', breadcrumbMatch ? breadcrumbMatch.length : 0);
if (breadcrumbMatch) {
  fs.writeFileSync('audit/breadcrumb_raw.html', breadcrumbMatch[0]);
  console.log('Saved audit/breadcrumb_raw.html');
}
