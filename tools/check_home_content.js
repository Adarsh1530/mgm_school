const fs = require('fs');

const html = fs.readFileSync('audit/homepage_full.html', 'utf8');
const start = html.indexOf('<div data-elementor-type="wp-page"');
const end = html.indexOf('tp-footer-copyright');

console.log('Homepage start index:', start);
console.log('Homepage end index:', end);
if (start !== -1 && end !== -1) {
  // Find container end before footer
  const content = html.substring(start, end);
  console.log('Homepage content length:', content.length);
  fs.writeFileSync('audit/homepage_content.html', content);
}
