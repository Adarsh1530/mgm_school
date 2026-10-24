const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Extract all stylesheet hrefs
const cssMatches = [];
const linkRegex = /<link[^>]*href=["']([^"']+\.css[^"']*)["'][^>]*>/gi;
let m;
while ((m = linkRegex.exec(html)) !== null) {
  cssMatches.push(m[1]);
}
console.log('Found stylesheets:', cssMatches.length);
fs.writeFileSync('audit/stylesheets.json', JSON.stringify(cssMatches, null, 2));

// Extract Google fonts
const googleFonts = cssMatches.filter(url => url.includes('fonts.googleapis.com'));
console.log('Google Fonts:', googleFonts);

// Check theme name
const themeMatch = html.match(/\/wp-content\/themes\/([^\/]+)\//);
console.log('Theme:', themeMatch ? themeMatch[1] : 'Unknown');

// Check main CSS files
const themeCss = cssMatches.filter(url => url.includes('/themes/') || url.includes('/elementor/'));
console.log('Key Theme/Elementor CSS files:', themeCss.slice(0, 10));
