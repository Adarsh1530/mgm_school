const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

// Find the footer container that contains the copyright text
const cIdx = html.indexOf('tp-footer-copyright');
if (cIdx !== -1) {
  // Trace back to opening parent container
  const start = html.lastIndexOf('<div data-elementor-type="wp-post"', cIdx);
  const end = html.indexOf('</template>', cIdx);
  const footerHtml = html.substring(start !== -1 ? start : cIdx - 2000, end !== -1 ? end : cIdx + 2000);
  fs.writeFileSync('audit/footer_complete.html', footerHtml);
  console.log('Saved audit/footer_complete.html (length: ' + footerHtml.length + ')');
} else {
  console.log('tp-footer-copyright not found');
}
