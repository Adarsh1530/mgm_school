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
  
  const imgPath = 'C:\\Users\\KEERTHI ADARSH M P\\Desktop\\mgm school corrections\\update to new logo.png';
  const b64 = fs.readFileSync(imgPath).toString('base64');
  
  // Render it and check
  await page.setContent(`<img src="data:image/png;base64,${b64}" id="test" />`);
  const dims = await page.evaluate(() => {
    const img = document.getElementById('test');
    return { w: img.naturalWidth, h: img.naturalHeight };
  });
  console.log('update to new logo.png dims:', dims);
  await browser.close();
})();
