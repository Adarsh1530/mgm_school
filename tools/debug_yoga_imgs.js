const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/yoga/', { waitUntil: 'networkidle0' });

  const brokenImg = await page.evaluate(() => {
    const imgs = Array.from(document.querySelectorAll('img'));
    return imgs.map(img => ({
      outerHTML: img.outerHTML,
      src: img.src,
      complete: img.complete,
      naturalWidth: img.naturalWidth
    }));
  });

  console.log('All imgs on /yoga/:', brokenImg);
  await browser.close();
}

run().catch(console.error);
