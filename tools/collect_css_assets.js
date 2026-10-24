const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const CSS_URLS = [
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/bootstrap.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/font-awesome-pro.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/spacing.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/acadia-core.css?ver=1792603600',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/acadia-custom.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/style.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/plugins/elementor/assets/css/frontend.min.css?ver=3.27.6'
];

async function run() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000 });
  await new Promise(r => setTimeout(r, 6000));
  let title = await page.title();
  while (title.includes('Checking your browser')) {
    await new Promise(r => setTimeout(r, 1000));
    title = await page.title();
  }

  const cssDir = path.join(__dirname, '..', 'public', 'assets', 'css');
  if (!fs.existsSync(cssDir)) fs.mkdirSync(cssDir, { recursive: true });

  for (const url of CSS_URLS) {
    const urlObj = new URL(url);
    const basename = path.basename(urlObj.pathname);
    const dest = path.join(cssDir, basename);
    console.log(`Fetching CSS: ${basename}...`);
    try {
      const text = await page.evaluate(async (u) => {
        const r = await fetch(u);
        return await r.text();
      }, url);
      fs.writeFileSync(dest, text);
      console.log(`  -> Saved ${basename} (${text.length} bytes)`);
    } catch (e) {
      console.error(`  -> Failed ${basename}:`, e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
