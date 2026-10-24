const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Find all <style> tags
const styleRegex = /<style[^>]*>([\s\S]*?)<\/style>/gi;
let sm;
let styleCount = 0;
let totalStyleLen = 0;
const styleSnippets = [];

while ((sm = styleRegex.exec(html)) !== null) {
  styleCount++;
  totalStyleLen += sm[1].length;
  styleSnippets.push(sm[0]);
}

console.log(`Found ${styleCount} <style> tags, total CSS length: ${totalStyleLen} bytes`);
fs.writeFileSync('audit/all_inline_styles.html', styleSnippets.join('\n'));

// Find all CSS stylesheet URLs
const cssLinks = [];
const linkRegex = /<link[^>]*rel=["']stylesheet["'][^>]*href=["']([^"']+)["'][^>]*>/gi;
let lm;
while ((lm = linkRegex.exec(html)) !== null) {
  cssLinks.push(lm[1]);
}

console.log(`Found ${cssLinks.length} stylesheet links`);
fs.writeFileSync('audit/all_css_links.json', JSON.stringify(cssLinks, null, 2));
