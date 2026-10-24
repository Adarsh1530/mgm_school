const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/notices/', { waitUntil: 'networkidle2' });

  const broken = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img'))
      .filter(img => !img.complete || img.naturalWidth === 0)
      .map(img => ({
        src: img.src,
        alt: img.alt,
        outerHTML: img.outerHTML
      }));
  });

  console.log('Broken images on /notices/:', broken);
  await browser.close();
})();
