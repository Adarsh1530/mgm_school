const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const urls = [
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/services-bg.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/09/subject-bg-bg.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/cta-bg-1.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/testimonial-bg-2.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/08/about-bg.png'
];

async function run() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 30000 }).catch(() => {});
  await new Promise(r => setTimeout(r, 4000));

  for (const url of urls) {
    const filename = path.basename(new URL(url).pathname);
    const dest = path.join(__dirname, '..', 'assets', 'images', filename);
    console.log('Downloading ' + filename + '...');
    try {
      const res = await page.evaluate(async (u) => {
        const r = await fetch(u);
        if (!r.ok) return { error: r.status };
        const b = await r.blob();
        const reader = new FileReader();
        return new Promise((resolve) => {
          reader.onloadend = () => resolve({ base64: reader.result.split(',')[1] });
          reader.readAsDataURL(b);
        });
      }, url);

      if (res && res.base64) {
        fs.writeFileSync(dest, Buffer.from(res.base64, 'base64'));
        console.log('  Saved ' + filename + ' (' + fs.statSync(dest).size + ' bytes)');
      } else {
        console.log('  Failed ' + filename + ':', res ? res.error : 'null');
      }
    } catch (e) {
      console.error('  Error:', e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
