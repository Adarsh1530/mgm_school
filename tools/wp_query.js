const puppeteer = require('puppeteer-core');
const fs = require('fs');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function waitForReady(page) {
  let attempts = 0;
  while (attempts < 20) {
    try {
      const title = await page.title();
      if (!title.includes('Checking your browser')) {
        return true;
      }
    } catch (e) {}
    await new Promise(r => setTimeout(r, 1000));
    attempts++;
  }
  return false;
}

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000 });
  await waitForReady(page);
  await new Promise(r => setTimeout(r, 3000));

  const menus = await page.evaluate(async () => {
    const endpoints = [
      '/wp-json/wp/v2/menus',
      '/wp-json/wp/v2/menu-items?per_page=100',
      '/wp-json/menus/v1/menus',
      '/wp-json/wp-api-menus/v2/menus'
    ];
    const res = {};
    for (const ep of endpoints) {
      try {
        const r = await fetch(ep);
        res[ep] = { status: r.status, data: await r.json() };
      } catch (e) {
        res[ep] = { error: e.message };
      }
    }
    return res;
  });

  fs.writeFileSync('audit/menu_api_results.json', JSON.stringify(menus, null, 2));
  console.log('Saved audit/menu_api_results.json');
  await browser.close();
})();
