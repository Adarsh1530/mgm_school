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
  
  const imgPath = 'C:\\Users\\KEERTHI ADARSH M P\\Desktop\\mgm school corrections\\mandatory discloure some pdfs are missing and some others are not properly opening use the exact pdfs and remove the institutional records & affiliation verification section just remove it .png';
  const b64 = fs.readFileSync(imgPath).toString('base64');
  
  await page.setContent(`<img src="data:image/png;base64,${b64}" id="s" />`);
  await page.screenshot({ path: 'tools/debug_disclosure_screen.jpg', quality: 60 });
  console.log('Saved tools/debug_disclosure_screen.jpg');
  await browser.close();
})();
