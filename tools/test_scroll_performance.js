const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function run() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,900', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 900 });

  console.log('Testing scrolling on homepage (http://localhost/MGM%20SCHOOL/)...');
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle0' });

  // Record scroll positions to detect oscillations / loops
  const scrollTest = await page.evaluate(async () => {
    const scrollLog = [];
    const maxScroll = document.body.scrollHeight - window.innerHeight;
    let stuckCount = 0;
    let oscillationCount = 0;

    // Simulate mouse wheel down scroll in steps
    let current = 0;
    const step = 80;

    for (let i = 0; i < 40; i++) {
      current += step;
      window.scrollTo(0, current);
      await new Promise(r => setTimeout(r, 30));
      const actual = window.scrollY;
      scrollLog.push(actual);

      if (i > 1) {
        const prev = scrollLog[i - 1];
        const prev2 = scrollLog[i - 2];
        // If scroll went backward while we were scrolling down, that's an oscillation loop!
        if (actual < prev) {
          oscillationCount++;
        }
        // If actual didn't change despite scrolling
        if (actual === prev && actual < maxScroll) {
          stuckCount++;
        }
      }
    }

    // Now test scrolling back up
    for (let i = 0; i < 40; i++) {
      current -= step;
      if (current < 0) current = 0;
      window.scrollTo(0, current);
      await new Promise(r => setTimeout(r, 30));
      const actual = window.scrollY;
      scrollLog.push(actual);

      if (actual > scrollLog[scrollLog.length - 2] && current < scrollLog[scrollLog.length - 2]) {
        oscillationCount++;
      }
    }

    const header = document.querySelector('.header-area');
    const headerRect = header ? header.getBoundingClientRect() : null;

    return {
      maxScroll,
      finalScrollY: window.scrollY,
      oscillationCount,
      stuckCount,
      headerIsSticky: header ? window.getComputedStyle(header).position === 'sticky' : false,
      headerTop: headerRect ? headerRect.top : null,
      sampleScrolls: scrollLog.slice(0, 15)
    };
  });

  console.log('Scroll Test Results:', JSON.stringify(scrollTest, null, 2));

  if (scrollTest.oscillationCount === 0 && scrollTest.stuckCount === 0) {
    console.log('[PASS] Scrolling is 100% fluid, smooth, and stable. Zero oscillation or sticking loops!');
  } else {
    console.warn('[WARN] Issues detected during scroll test:', scrollTest);
  }

  await browser.close();
}

run().catch(console.error);
