const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  for (const w of [1440, 1024, 768, 375]) {
    await page.setViewport({ width: w, height: 800 });
    await page.goto('http://localhost/MGM%20SCHOOL/contact/', { waitUntil: 'networkidle2' });
    const cards = await page.evaluate(() => {
      return Array.from(document.querySelectorAll('.tp-subpage-container .row.g-4 > div .card')).map(c => ({
        height: c.offsetHeight,
        width: c.offsetWidth
      }));
    });
    console.log(`Viewport ${w}px:`, JSON.stringify(cards));
  }
  await browser.close();
})();
