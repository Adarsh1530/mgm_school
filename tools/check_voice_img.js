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
  
  // Let's render the screenshot on a canvas and analyze what's visible
  const imgPath = 'C:\\Users\\KEERTHI ADARSH M P\\Desktop\\mgm school corrections\\fix the voice of mgm section properly .png';
  const b64 = fs.readFileSync(imgPath).toString('base64');
  
  await page.setContent(`<img src="data:image/png;base64,${b64}" id="s" />`);
  await page.screenshot({ path: 'tools/debug_voice.jpg', quality: 60 });
  console.log('Saved tools/debug_voice.jpg');
  await browser.close();
})();
