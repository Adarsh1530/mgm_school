const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const html = fs.readFileSync('audit/homepage_content.html', 'utf8');
const regex = /src=["']([^"']+)["']/gi;
const imgs = new Set();
let m;
while ((m = regex.exec(html)) !== null) {
  if (m[1].startsWith('http')) imgs.add(m[1]);
}

const list = Array.from(imgs);
console.log(`Found ${list.length} images to fetch for homepage.`);

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

  const imgDir = path.join(__dirname, '..', 'assets', 'images');

  for (let i = 0; i < list.length; i++) {
    const url = list[i];
    const basename = path.basename(new URL(url).pathname);
    const dest = path.join(imgDir, basename);
    if (fs.existsSync(dest)) {
      console.log(`[${i+1}/${list.length}] Already exists: ${basename}`);
      continue;
    }
    console.log(`[${i+1}/${list.length}] Fetching ${basename}...`);
    try {
      const b64 = await page.evaluate(async (u) => {
        try {
          const r = await fetch(u);
          if (!r.ok) return null;
          const blob = await r.blob();
          return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve(reader.result);
            reader.readAsDataURL(blob);
          });
        } catch(e) { return null; }
      }, url);

      if (b64) {
        const matches = b64.match(/^data:([A-Za-z-+\/]+);base64,(.+)$/);
        if (matches) {
          fs.writeFileSync(dest, Buffer.from(matches[2], 'base64'));
          console.log(`  -> Saved ${basename}`);
        }
      }
    } catch (e) {
      console.warn(`  -> Failed: ${basename}`);
    }
  }

  await browser.close();
}

run().catch(console.error);
