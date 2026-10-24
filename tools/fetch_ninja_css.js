const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000 });
  await new Promise(r => setTimeout(r, 6000));

  const url = 'https://mgm-school.nbtksa.in/wp-content/plugins/ninja-tables/assets/css/ninjatables-public.css';
  const text = await page.evaluate(async (u) => {
    const r = await fetch(u);
    return await r.text();
  }, url);

  fs.writeFileSync(path.join(__dirname, '..', 'assets', 'css', 'ninjatables-public.css'), text);
  console.log('Saved ninjatables-public.css (' + text.length + ' bytes)');

  await browser.close();
})();
