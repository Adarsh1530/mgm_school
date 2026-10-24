const fs = require('fs');

const html = fs.readFileSync('audit/raw_pages/mandatory-disclosure_full.html', 'utf8');

const match = html.match(/<style id="acadia-custom-inline-css">([\s\S]*?)<\/style>/i);
if (match) {
  console.log('--- Custom Inline CSS ---');
  console.log(match[1]);
  fs.writeFileSync('audit/acadia_custom_vars.css', match[1]);
} else {
  console.log('No acadia-custom-inline-css found');
}
