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
  await page.setViewport({ width: 600, height: 600 });
  await page.setContent(`
    <body style="background: #222; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0;">
      <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" style="width: 300px; height: 300px; object-fit: contain; background: #fff; padding: 10px; border-radius: 8px;" />
    </body>
  `);
  await page.screenshot({ path: 'tools/new_logo_large.png' });
  console.log('Saved tools/new_logo_large.png');
  await browser.close();
})();
