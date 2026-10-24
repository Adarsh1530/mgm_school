const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Search for footer container
const footerStart = html.indexOf('tp-footer');
if (footerStart !== -1) {
  console.log(html.substring(footerStart - 100, footerStart + 2500));
} else {
  console.log('tp-footer not found');
}

// Find copyright text
const cIdx = html.indexOf('©');
if (cIdx !== -1) {
  console.log('Copyright area:', html.substring(cIdx - 200, cIdx + 300));
}
