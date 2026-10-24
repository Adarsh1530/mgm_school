const fs = require('fs');
const html = fs.readFileSync('audit/homepage_clean_extracted.html', 'utf8');

// Search for 2185419a
const idx = html.indexOf('2185419a');
if (idx !== -1) {
  console.log('Found 2185419a snippet:');
  console.log(html.substring(idx - 100, idx + 400));
} else {
  console.log('2185419a not found in raw html');
}

// Search for classes or IDs having 235px
const regex = /data-id="([^"]+)"/g;
let m;
const ids = [];
while ((m = regex.exec(html)) !== null) {
  ids.push(m[1]);
}
console.log('Total elementor IDs in homepage:', ids.length, ids.slice(0, 10));
