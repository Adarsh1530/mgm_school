const fs = require('fs');
const path = require('path');

console.log('=== CHECKING ALL VIEWS FILES FOR HREF="#" OR BROKEN LINKS ===');
const viewsDir = 'views';
fs.readdirSync(viewsDir).forEach(f => {
  if (f.endsWith('.php')) {
    const content = fs.readFileSync(path.join(viewsDir, f), 'utf8');
    const regex = /<a\b[^>]*href=["']#["'][^>]*>(.*?)<\/a>/gis;
    let m;
    const found = [];
    while ((m = regex.exec(content)) !== null) {
      found.push(m[1].replace(/<[^>]+>/g, '').trim().replace(/\s+/g, ' '));
    }
    if (found.length > 0) {
      console.log(`In ${f} (${found.length}):`);
      found.forEach(txt => console.log(`  - "${txt}"`));
    }
  }
});
