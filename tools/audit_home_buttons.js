const fs = require('fs');

const home = fs.readFileSync('views/home.php', 'utf8');
const extracted = fs.readFileSync('audit/homepage_clean_extracted.html', 'utf8');

function checkLinks(content, sourceName) {
  console.log(`\n=== SCANNING ALL <a> TAGS IN ${sourceName} ===`);
  const regex = /<a\b[^>]*>(.*?)<\/a>/gis;
  let m;
  let count = 0;
  while ((m = regex.exec(content)) !== null) {
    const fullTag = m[0];
    const innerText = m[1].replace(/<[^>]+>/g, '').trim().replace(/\s+/g, ' ');
    const hrefMatch = fullTag.match(/href=["']([^"']*)["']/i);
    const href = hrefMatch ? hrefMatch[1] : '';
    
    console.log(`[${count++}] Text: "${innerText.substring(0, 50)}" | Href: "${href}"`);
  }
}

checkLinks(extracted, 'audit/homepage_clean_extracted.html');
