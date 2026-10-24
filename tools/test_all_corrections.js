const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

const routesToTest = [
  '',
  'our-mission',
  'admission-procedure',
  'courses-offered',
  'hindustan-scouts-guides',
  'voice-of-mgm',
  'merit-day',
  'alumni',
  'gallery',
  'mandatory-disclosure',
  'contact'
];

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  console.log('--- TESTING ALL 14 CORRECTIONS ON LOCALHOST ---');
  let failures = 0;

  for (const r of routesToTest) {
    const url = `${BASE_URL}/${r}${r ? '/' : ''}`;
    const res = await page.goto(url, { waitUntil: 'networkidle2' });
    const status = res.status();
    
    // Check broken images
    const brokenImages = await page.evaluate(() => {
      const imgs = Array.from(document.querySelectorAll('img'));
      return imgs.filter(i => i.naturalWidth === 0 && !i.src.startsWith('data:')).map(i => i.src);
    });

    if (status !== 200 || brokenImages.length > 0) {
      console.log(`[FAIL] ${r || 'home'}: Status ${status}, Broken Images: ${brokenImages.length}`);
      failures++;
    } else {
      console.log(`[PASS] ${r || 'home'}: Status 200, Images OK`);
    }
  }

  // Check specific tasks
  console.log('\n--- VERIFYING SPECIFIC CORRECTIONS ---');
  
  // 1. Homepage experience
  await page.goto(`${BASE_URL}/`, { waitUntil: 'networkidle2' });
  const expNum = await page.evaluate(() => document.querySelector('.elementor-counter-number')?.innerText);
  console.log(`Experience Counter: "${expNum}" (Expected: 43) => ${expNum === '43' ? 'PASS' : 'FAIL'}`);

  // 2. Navigation dropdown order
  const dropdownTexts = await page.evaluate(() => {
    const items = Array.from(document.querySelectorAll('.main-menu .tp-nav-menu > li:nth-child(2) ul li a'));
    return items.map(a => a.innerText.trim());
  });
  console.log('About Dropdown Items:', dropdownTexts);

  // 3. Contact link in nav
  const contactHref = await page.evaluate(() => {
    const link = Array.from(document.querySelectorAll('.main-menu .tp-nav-menu > li > a')).find(a => a.innerText.includes('Contact'));
    return link ? link.getAttribute('href') : null;
  });
  console.log(`Contact Menu URL: ${contactHref} (Expected: contains /contact/) => ${contactHref && contactHref.includes('contact') ? 'PASS' : 'FAIL'}`);

  // 4. Video play button removed
  const playBtns = await page.evaluate(() => document.querySelectorAll('.mgm-btn-play').length);
  console.log(`Play buttons on home: ${playBtns} (Expected: 0) => ${playBtns === 0 ? 'PASS' : 'FAIL'}`);

  // 5. Gallery 3x3 frames
  await page.goto(`${BASE_URL}/gallery/`, { waitUntil: 'networkidle2' });
  const galleryFrames = await page.evaluate(() => document.querySelectorAll('.mgm-gallery-frame').length);
  const galleryHeadings = await page.evaluate(() => {
    const headings = Array.from(document.querySelectorAll('h1, h2, h3, h4'));
    return headings.map(h => h.innerText.trim()).filter(t => t.toLowerCase() === 'gallery');
  });
  console.log(`Gallery Frames: ${galleryFrames}, Standalone "Gallery" Headings: ${galleryHeadings.length} (Expected <= 1 in breadcrumb) => ${galleryHeadings.length <= 1 ? 'PASS' : 'FAIL'}`);

  // 6. Mandatory disclosure check
  await page.goto(`${BASE_URL}/mandatory-disclosure/`, { waitUntil: 'networkidle2' });
  const instSection = await page.evaluate(() => document.querySelector('.mgm-doc-card'));
  console.log(`Institutional verification section present: ${instSection !== null} (Expected: false) => ${instSection === null ? 'PASS' : 'FAIL'}`);

  await browser.close();
  console.log('\n--- VERIFICATION FINISHED ---');
})();
