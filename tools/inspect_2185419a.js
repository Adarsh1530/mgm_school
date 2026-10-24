const fs = require('fs');
const html = fs.readFileSync('audit/homepage_clean_extracted.html', 'utf8');
const idx = html.indexOf('2185419a');
console.log(html.substring(idx - 50, idx + 1200));
