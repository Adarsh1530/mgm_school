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
  
  await page.setContent(`<img src="data:image/png;base64,${b64}" id="test" />`);
  
  // We can render this page and take a screenshot or examine it
  console.log('make those pdf into image exists, size:', fs.statSync(imgPath).size);
  await browser.close();
})();
