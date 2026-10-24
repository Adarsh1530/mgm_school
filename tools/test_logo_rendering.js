const puppeteer = require('puppeteer-core');
const fs = require('fs');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  
  await page.setContent(`
    <div style="font-family: sans-serif; display: flex; gap: 20px; padding: 20px;">
      <div style="background: #ffffff; border: 1px solid #ccc; padding: 20px; text-align: center;">
        <h4>On White Header</h4>
        <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" style="max-height: 80px;" />
      </div>
      <div style="background: #002147; color: white; padding: 20px; text-align: center;">
        <h4>On Dark Footer (#002147)</h4>
        <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" style="max-height: 80px;" />
      </div>
    </div>
  `);
  
  await page.screenshot({ path: 'tools/logo_render_test.png' });
  console.log('Saved tools/logo_render_test.png');
  await browser.close();
})();
