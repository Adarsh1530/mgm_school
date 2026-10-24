const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

const PAGES = [
  'mandatory-disclosure',
  'yoga',
  'voice-of-mgm',
  'hindustan-scouts-guides',
  'swimming-pool',
  'ncc',
  'attendance',
  'admission-procedure',
  'alumni',
  'merit-day',
  'pta',
  'courses-offered',
  'our-founder',
  'gallery',
  'our-mission',
  'about-us'
];

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  const res = [];
  for (const slug of PAGES) {
    await page.goto(`${BASE_URL}/${slug}/`, { waitUntil: 'networkidle2' });
    const info = await page.evaluate(() => {
      // Find element immediately following .elementor-6225
      const bc = document.querySelector('.elementor-6225');
      if (!bc) return null;
      let next = bc.nextElementSibling;
      while (next && next.tagName === 'SCRIPT') next = next.nextElementSibling;
      if (!next) return null;
      const s = window.getComputedStyle(next);
      return {
        tag: next.tagName,
        cls: next.className,
        pt: s.paddingTop,
        pb: s.paddingBottom,
        mt: s.marginTop,
        mb: s.marginBottom,
        h: next.offsetHeight
      };
    });
    res.push({ slug, next: info });
  }

  console.log(JSON.stringify(res, null, 2));
  await browser.close();
})();
