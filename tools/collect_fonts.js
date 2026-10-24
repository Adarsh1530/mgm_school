const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const FONTS = [
  'fa-brands-400.woff2',
  'fa-regular-400.woff2',
  'fa-solid-900.woff2',
  'fa-light-300.woff2',
  'fa-thin-100.woff2',
  'fa-duotone-900.woff2'
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

  const fontsDir = path.join(__dirname, '..', 'public', 'assets', 'fonts');
  if (!fs.existsSync(fontsDir)) fs.mkdirSync(fontsDir, { recursive: true });

  for (const font of FONTS) {
    const url = `https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/fonts/${font}`;
    const dest = path.join(fontsDir, font);
    console.log(`Fetching font: ${font}...`);
    try {
      const base64Data = await page.evaluate(async (u) => {
        try {
          const res = await fetch(u);
          if (!res.ok) return { error: `HTTP ${res.status}` };
          const blob = await res.blob();
          return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve({ data: reader.result });
            reader.onerror = reject;
            reader.readAsDataURL(blob);
          });
        } catch (err) {
          return { error: err.message };
        }
      }, url);

      if (base64Data && base64Data.data) {
        const matches = base64Data.data.match(/^data:([A-Za-z-+\/]+);base64,(.+)$/);
        if (matches && matches.length === 3) {
          const buffer = Buffer.from(matches[2], 'base64');
          fs.writeFileSync(dest, buffer);
          console.log(`  -> Saved ${font} (${buffer.length} bytes)`);
        }
      }
    } catch (e) {
      console.error(`  -> Failed ${font}:`, e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
