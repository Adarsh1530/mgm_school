const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

const outputDir = path.join(__dirname, 'screenshots_audit');
if (!fs.existsSync(outputDir)) {
  fs.mkdirSync(outputDir, { recursive: true });
}

const pages = [
  { slug: '', name: 'home' },
  { slug: 'about-us', name: 'about-us' },
  { slug: 'courses-offered', name: 'courses-offered' },
  { slug: 'mandatory-disclosure', name: 'mandatory-disclosure' },
  { slug: 'gallery', name: 'gallery' },
  { slug: 'merit-day', name: 'merit-day' },
  { slug: 'swimming-pool', name: 'swimming-pool' },
  { slug: 'our-founder', name: 'our-founder' }
];

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--window-size=1400,900']
  });
  
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  for (const p of pages) {
    const url = `${BASE_URL}/${p.slug}${p.slug ? '/' : ''}`;
    console.log(`Capturing: ${p.name} from ${url}`);
    await page.goto(url, { waitUntil: 'networkidle2', timeout: 30000 });
    
    // Check computed heights and unwanted space
    const layoutIssues = await page.evaluate(() => {
      const issues = [];
      // check all sections and containers
      const elements = document.querySelectorAll('section, div.container, header, footer, .tp-breadcrumb__area');
      elements.forEach(el => {
        const style = window.getComputedStyle(el);
        const rect = el.getBoundingClientRect();
        // check if element has huge empty margins or padding (> 120px)
        const pt = parseFloat(style.paddingTop);
        const pb = parseFloat(style.paddingBottom);
        const mt = parseFloat(style.marginTop);
        const mb = parseFloat(style.marginBottom);
        if (pt > 120 || pb > 120 || mt > 80 || mb > 80) {
          issues.push({
            tag: el.tagName,
            cls: el.className,
            pt, pb, mt, mb,
            height: rect.height
          });
        }
      });
      return issues;
    });

    console.log(`  Issues for ${p.name}:`, layoutIssues);

    await page.screenshot({
      path: path.join(outputDir, `${p.name}_desktop.jpg`),
      fullPage: true,
      quality: 75
    });
  }

  // Also check mobile view on Home and About Us
  await page.setViewport({ width: 375, height: 667, isMobile: true, hasTouch: true });
  for (const p of pages.slice(0, 3)) {
    const url = `${BASE_URL}/${p.slug}${p.slug ? '/' : ''}`;
    await page.goto(url, { waitUntil: 'networkidle2', timeout: 30000 });
    await page.screenshot({
      path: path.join(outputDir, `${p.name}_mobile.jpg`),
      fullPage: true,
      quality: 75
    });
  }

  await browser.close();
  console.log('Capture complete!');
})();
