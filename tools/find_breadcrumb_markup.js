const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Search for breadcrumb or title
const match = html.match(/<div[^>]*class="[^"]*breadcrumb[^"]*"[\s\S]*?<\/div>/gi);
console.log('Breadcrumb divs found:', match ? match.length : 0);
if (match) {
  match.forEach((m, i) => console.log(`[${i}]`, m));
}

// Search for "Mandatory Disclosure" occurrences
let pos = 0;
while ((pos = html.indexOf('Mandatory Disclosure', pos)) !== -1) {
  console.log('--- At pos', pos, '---');
  console.log(html.substring(Math.max(0, pos - 150), pos + 250));
  pos += 20;
}
