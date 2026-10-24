const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Find navigation links and structure
const navRegex = /<nav[\s\S]*?<\/nav>/gi;
const navMatches = html.match(navRegex);
console.log('Nav matches found:', navMatches ? navMatches.length : 0);

if (navMatches) {
  navMatches.forEach((nav, idx) => {
    console.log(`\n=== NAV ${idx} ===`);
    console.log(nav);
  });
}

// Check header
const headerMatch = html.match(/<header[\s\S]*?<\/header>/gi);
console.log('\nHeader matches found:', headerMatch ? headerMatch.length : 0);
if (headerMatch) {
  fs.writeFileSync('audit/header_raw.html', headerMatch[0]);
  console.log('Saved audit/header_raw.html');
}

// Check footer
const footerMatch = html.match(/<footer[\s\S]*?<\/footer>/gi);
console.log('Footer matches found:', footerMatch ? footerMatch.length : 0);
if (footerMatch) {
  fs.writeFileSync('audit/footer_raw.html', footerMatch[0]);
  console.log('Saved audit/footer_raw.html');
} else {
  // Check elementor footer template or similar
  const footerLike = html.match(/<div[^>]*class="[^"]*footer[^"]*"[\s\S]*?<\/div>/gi);
  console.log('Footer-like divs found:', footerLike ? footerLike.length : 0);
  if (footerLike) {
    fs.writeFileSync('audit/footer_raw.html', footerLike.join('\n---\n'));
  }
}
