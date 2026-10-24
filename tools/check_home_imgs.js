const fs = require('fs');

const html = fs.readFileSync('audit/homepage_content.html', 'utf8');
const regex = /src=["']([^"']+)["']/gi;
const imgs = [];
let m;
while ((m = regex.exec(html)) !== null) {
  imgs.push(m[1]);
}
console.log('Homepage images count:', imgs.length);
console.log(Array.from(new Set(imgs)).slice(0, 15));
