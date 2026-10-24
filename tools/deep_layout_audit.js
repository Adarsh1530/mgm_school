const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

const PAGES = [
  '',
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

  const allIssues = {};

  for (const slug of PAGES) {
    const url = `${BASE_URL}/${slug}${slug ? '/' : ''}`;
    await page.goto(url, { waitUntil: 'networkidle2' });

    const pageReport = await page.evaluate(() => {
      const issues = [];
      
      // 1. Check Header height
      const header = document.querySelector('#header-sticky');
      if (header && header.offsetHeight > 90) {
        issues.push({
          type: 'HEADER_TOO_TALL',
          selector: '#header-sticky',
          height: header.offsetHeight,
          detail: 'Header is taller than 90px (nav items likely wrapping or excessive padding)'
        });
      }

      // 2. Check for empty divs with large height (> 30px)
      const allDivs = document.querySelectorAll('div, section');
      allDivs.forEach(div => {
        // If div has no text, no images, no svgs, no videos, but has height > 30px
        const text = div.innerText.trim();
        const hasMedia = div.querySelector('img, video, iframe, svg, canvas, input, button, table');
        if (!text && !hasMedia && div.offsetHeight > 30) {
          // Check if it has background image
          const bg = window.getComputedStyle(div).backgroundImage;
          if (bg === 'none') {
            issues.push({
              type: 'EMPTY_BLOCK_GAP',
              selector: div.className || div.tagName,
              height: div.offsetHeight,
              id: div.getAttribute('data-id') || null
            });
          }
        }
      });

      // 3. Check for excessive padding or margins (> 100px)
      document.querySelectorAll('section, .elementor-section, .elementor-element.e-parent, .tp-breadcrumb__area, footer').forEach(el => {
        const style = window.getComputedStyle(el);
        const pt = parseFloat(style.paddingTop);
        const pb = parseFloat(style.paddingBottom);
        const mt = parseFloat(style.marginTop);
        const mb = parseFloat(style.marginBottom);
        if (pt > 100 || pb > 100 || mt > 60 || mb > 60) {
          issues.push({
            type: 'EXCESSIVE_SPACING',
            selector: el.className.split(' ').slice(0, 3).join('.'),
            pt, pb, mt, mb,
            height: el.offsetHeight
          });
        }
      });

      return issues;
    });

    if (pageReport.length > 0) {
      allIssues[slug || 'home'] = pageReport;
    }
  }

  console.log(JSON.stringify(allIssues, null, 2));
  await browser.close();
})();
