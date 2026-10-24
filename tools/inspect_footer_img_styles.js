const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  
  const imgStyles = await page.evaluate(() => {
    const img = document.querySelector('.tp-footer-logo img');
    if (!img) return null;
    const s = window.getComputedStyle(img);
    return {
      margin: s.margin,
      padding: s.padding,
      verticalAlign: s.verticalAlign,
      display: s.display,
      position: s.position,
      top: s.top,
      transform: s.transform,
      lineHeight: s.lineHeight,
      filter: s.filter
    };
  });
  
  console.log('Footer img computed styles:', imgStyles);
  await browser.close();
})();
