const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const PAGE_IDS = [
  16051, 16043, 16036, 16026, 16019, 16013, 16004, 15998,
  15992, 15985, 15979, 15930, 15913, 15937, 15908, 10042,
  1119 // Homepage
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
  let title = '';
  for (let i = 0; i < 20; i++) {
    try {
      title = await page.title();
      if (title && !title.includes('Checking your browser')) break;
    } catch (e) {}
    await new Promise(r => setTimeout(r, 1000));
  }
  await new Promise(r => setTimeout(r, 3000));

  const cssDir = path.join(__dirname, '..', 'assets', 'css');
  if (!fs.existsSync(cssDir)) fs.mkdirSync(cssDir, { recursive: true });

  for (const id of PAGE_IDS) {
    const url = `https://mgm-school.nbtksa.in/wp-content/uploads/elementor/css/post-${id}.css`;
    const dest = path.join(cssDir, `post-${id}.css`);
    console.log(`Checking post-${id}.css...`);
    try {
      const res = await page.evaluate(async (u) => {
        try {
          const r = await fetch(u);
          if (!r.ok) return { error: r.status };
          return { data: await r.text() };
        } catch (e) {
          return { error: e.message };
        }
      }, url);

      if (res && res.data) {
        fs.writeFileSync(dest, res.data);
        console.log(`  -> Saved post-${id}.css (${res.data.length} bytes)`);
      } else {
        console.log(`  -> Not found or HTTP ${res.error}`);
      }
    } catch (e) {
      console.error(`  -> Error:`, e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
