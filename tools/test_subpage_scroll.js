const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

const pages = [
  'mandatory-disclosure',
  'courses-offered',
  'admission-procedure',
  'gallery',
  'about-us',
  'our-founder'
];

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 800 });

  for (const slug of pages) {
    await page.goto(`${BASE_URL}/${slug}/`, { waitUntil: 'networkidle0' });
    const res = await page.evaluate(async () => {
      let stuck = 0;
      let osc = 0;
      const positions = [];
      for (let i = 0; i < 20; i++) {
        window.scrollBy(0, 100);
        await new Promise(r => setTimeout(r, 20));
        positions.push(window.scrollY);
        if (i > 0 && positions[i] < positions[i - 1]) osc++;
      }
      return { osc, finalScroll: window.scrollY, totalHeight: document.body.scrollHeight };
    });
    console.log(`[PASS] /${slug}/: Oscillations=${res.osc}, ScrollY=${res.finalScroll} / ${res.totalHeight}`);
  }

  await browser.close();
}

run().catch(console.error);
