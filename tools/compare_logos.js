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
  
  // Create a page comparing both logos
  await page.setContent(`
    <div style="background: #002147; padding: 20px; display: flex; gap: 20px;">
      <div>
        <h3 style="color: white;">Old Logo</h3>
        <img src="http://localhost/MGM%20SCHOOL/assets/images/cropped-1733381285-removebg-preview.png" style="max-height: 80px;" />
      </div>
      <div>
        <h3 style="color: white;">New Logo (Raw)</h3>
        <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.jpeg" style="max-height: 80px;" />
      </div>
    </div>
  `);
  
  await page.screenshot({ path: 'tools/logo_comparison.png' });
  console.log('Saved logo_comparison.png');
  await browser.close();
})();
