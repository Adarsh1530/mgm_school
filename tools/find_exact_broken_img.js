const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle0' });

  const info = await page.evaluate(() => {
    const broken = Array.from(document.querySelectorAll('img')).filter(i => i.src === 'http://localhost/MGM%20SCHOOL/' || i.src.endsWith('/MGM%20SCHOOL/'));
    return broken.map(i => ({
      outerHTML: i.outerHTML,
      parent: i.parentElement ? i.parentElement.outerHTML.substring(0, 200) : 'none'
    }));
  });

  console.log('Broken img info:', JSON.stringify(info, null, 2));
  await browser.close();
}

run().catch(console.error);
