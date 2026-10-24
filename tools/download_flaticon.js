const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const flaticonFonts = ['flaticon.woff2', 'flaticon.woff', 'flaticon.ttf'];

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000, waitUntil: 'domcontentloaded' }).catch(() => {});
  await new Promise(r => setTimeout(r, 4000));

  const fontsDir = path.join(__dirname, '..', 'assets', 'fonts');

  for (const f of flaticonFonts) {
    const url = `https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core/assets/fonts/${f}`;
    console.log(`Downloading font ${f}...`);
    try {
      const res = await page.evaluate(async (u) => {
        try {
          const r = await fetch(u);
          if (!r.ok) return { error: r.status };
          const blob = await r.blob();
          const reader = new FileReader();
          return new Promise(resolve => {
            reader.onloadend = () => resolve({ base64: reader.result.split(',')[1] });
            reader.readAsDataURL(blob);
          });
        } catch (e) {
          return { error: e.message };
        }
      }, url);

      if (res && res.base64) {
        const dest = path.join(fontsDir, f);
        fs.writeFileSync(dest, Buffer.from(res.base64, 'base64'));
        console.log(`  Saved ${f} (${fs.statSync(dest).size} bytes)`);
      } else {
        console.log(`  Failed ${f}:`, res ? res.error : 'null');
      }
    } catch (e) {
      console.error(`  Error ${f}:`, e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
