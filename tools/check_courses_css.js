const puppeteer = require('puppeteer-core');
const fs = require('fs');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/courses-offered/', { timeout: 35000 });
  await new Promise(r => setTimeout(r, 6000));
  
  const css = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map(l => l.href);
  });

  const ninjaCss = css.filter(u => u.includes('ninja') || u.includes('footable'));
  console.log('Ninja/Footable CSS on courses-offered:', ninjaCss);
  fs.writeFileSync('audit/ninja_css.json', JSON.stringify(ninjaCss, null, 2));

  await browser.close();
})();
