const fs = require('fs');

const css = fs.readFileSync('public/assets/css/font-awesome-pro.css', 'utf8');
const urls = [];
const regex = /url\(['"]?([^'")]+)['"]?\)/gi;
let m;
while ((m = regex.exec(css)) !== null) {
  urls.push(m[1]);
}
console.log('Font URLs found:', Array.from(new Set(urls)));
