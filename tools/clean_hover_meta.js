const fs = require('fs');
let html = fs.readFileSync('audit/homepage_clean_extracted.html', 'utf8');

// Replace any empty <a> tags inside tp-hover-meta
html = html.replace(/<div class="tp-hover-meta">[\s\S]*?<\/div>/gi, '');
fs.writeFileSync('audit/homepage_clean_extracted.html', html, 'utf8');
console.log('Cleaned tp-hover-meta tags.');
