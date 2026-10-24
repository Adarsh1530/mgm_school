const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const dir = 'C:\\Users\\KEERTHI ADARSH M P\\Desktop\\mgm school corrections';
const files = fs.readdirSync(dir);

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  
  // Create an HTML page containing all 14 screenshots with their filenames
  let html = '<html><body style="font-family: sans-serif; background: #222; color: #fff; padding: 20px;">';
  html += '<h1>User Corrections Screenshots</h1>';
  for (const f of files) {
    if (!f.endsWith('.png')) continue;
    const buf = fs.readFileSync(path.join(dir, f));
    const b64 = buf.toString('base64');
    html += `<div style="margin-bottom: 50px; background: #333; padding: 15px; border-radius: 8px;">`;
    html += `<h2 style="color: #4ade80; margin-top: 0;">${f}</h2>`;
    html += `<img src="data:image/png;base64,${b64}" style="max-width: 100%; border: 1px solid #555;" />`;
    html += `</div>`;
  }
  html += '</body></html>';
  
  fs.writeFileSync('tools/corrections_review.html', html);
  console.log('Saved tools/corrections_review.html');
  await browser.close();
})();
