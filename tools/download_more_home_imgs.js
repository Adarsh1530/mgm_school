const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const urls = [
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/about-1-icon.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/services-3-icon-4.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/layer.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/designtools.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/command.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/language-square.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/bucket.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/1733381285-removebg-preview.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/cta-shape-1.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/06/unnamed-5.webp',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/06/2.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/06/3.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/06/unnamed-4.webp'
];

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000, waitUntil: 'domcontentloaded' }).catch(() => {});
  await new Promise(r => setTimeout(r, 4000));

  const imgDir = path.join(__dirname, '..', 'assets', 'images');

  for (const u of urls) {
    const filename = path.basename(new URL(u).pathname);
    const dest = path.join(imgDir, filename);
    console.log(`Downloading ${filename}...`);

    try {
      const res = await page.evaluate(async (url) => {
        try {
          const r = await fetch(url);
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
      }, u);

      if (res && res.base64) {
        fs.writeFileSync(dest, Buffer.from(res.base64, 'base64'));
        console.log(`  Saved ${filename} (${fs.statSync(dest).size} bytes)`);
      } else {
        console.log(`  Failed ${filename}:`, res ? res.error : 'null');
      }
    } catch (e) {
      console.error(`  Error:`, e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
