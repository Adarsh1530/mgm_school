const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const urls = [
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/06/Untitled-design-4.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/06/Untitled-design-16.jpg',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-1.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-2.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-3.png',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/iconservice-4.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/08/image_003.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/08/image_002.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/08/image_001.jpg',
  'https://wp.themepure.net/acadia/wp-content/uploads/2024/07/testimonial-shape-1.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/testimonial-shape-2.png'
];

async function run() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000, waitUntil: 'domcontentloaded' }).catch(() => {});
  await new Promise(r => setTimeout(r, 5000));

  for (const url of urls) {
    const filename = path.basename(new URL(url).pathname);
    const dest = path.join(__dirname, '..', 'assets', 'images', filename);
    console.log('Downloading ' + filename + ' (' + url + ')...');

    try {
      const res = await page.evaluate(async (u) => {
        try {
          const r = await fetch(u);
          if (!r.ok) return { error: r.status };
          const b = await r.blob();
          const reader = new FileReader();
          return new Promise(resolve => {
            reader.onloadend = () => resolve({ base64: reader.result.split(',')[1] });
            reader.readAsDataURL(b);
          });
        } catch (e) {
          return { error: e.message };
        }
      }, url);

      if (res && res.base64) {
        fs.writeFileSync(dest, Buffer.from(res.base64, 'base64'));
        console.log('  Saved ' + filename + ' (' + fs.statSync(dest).size + ' bytes)');
      } else {
        console.log('  Failed via page context:', res ? res.error : 'null');
      }
    } catch (e) {
      console.error('  Eval error:', e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
