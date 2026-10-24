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
  
  const imgPath = 'C:\\Users\\KEERTHI ADARSH M P\\Desktop\\mgm school corrections\\make those pdf into image.png';
  const b64 = fs.readFileSync(imgPath).toString('base64');
  
  await page.setContent(`
    <body style="margin: 0; background: #000;">
      <img src="data:image/png;base64,${b64}" style="width: 100%;" />
    </body>
  `);
  
  // Let's inspect the page content or take a test crop
  await page.screenshot({ path: 'tools/debug_pdf_screenshot.jpg', quality: 50 });
  console.log('Saved tools/debug_pdf_screenshot.jpg');
  await browser.close();
})();
