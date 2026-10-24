const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

const regex = /<section[^>]*breadcrumb[^>]*>[\s\S]*?<\/section>|<div[^>]*breadcrumb-area[^>]*>[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/gi;
const match = html.match(regex);
if (match) {
  console.log(match[0].substring(0, 1000));
  fs.writeFileSync('audit/breadcrumb_snippet.html', match[0]);
} else {
  // search for breadcrumb class
  const idx = html.indexOf('breadcrumb');
  if (idx !== -1) {
    console.log(html.substring(Math.max(0, idx - 100), idx + 800));
  } else {
    console.log('No breadcrumb text found in mandatory-disclosure_full.html');
  }
}
