const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  const res = await page.goto('http://localhost/MGM%20SCHOOL/contact/', { waitUntil: 'networkidle2' });
  
  const details = await page.evaluate(() => {
    return {
      title: document.title,
      h2: document.querySelector('h2')?.innerText,
      iframeSrc: document.querySelector('iframe')?.src,
      phoneLinks: Array.from(document.querySelectorAll('a[href^="tel:"]')).map(a => a.href),
      emailLinks: Array.from(document.querySelectorAll('a[href^="mailto:"]')).map(a => a.href)
    };
  });
  
  console.log(`Status: ${res.status()}`);
  console.log(JSON.stringify(details, null, 2));
  await browser.close();
})();
