const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const path = require('path');

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const colors = await page.evaluate(() => {
    const bottomP = document.querySelector('.tp-footer-bottom p');
    const bottomContainer = document.querySelector('.tp-footer-bottom');
    const widgetP = document.querySelector('.tp-footer-widget p');
    const widgetH4 = document.querySelector('.tp-footer-widget-title');

    return {
      copyrightText: bottomP ? bottomP.innerText.trim() : null,
      copyrightColor: bottomP ? getComputedStyle(bottomP).color : null,
      copyrightBg: bottomContainer ? getComputedStyle(bottomContainer).backgroundColor : null,
      widgetTextColor: widgetP ? getComputedStyle(widgetP).color : null,
      widgetTitleColor: widgetH4 ? getComputedStyle(widgetH4).color : null
    };
  });

  console.log('Footer Colors Audit:', JSON.stringify(colors, null, 2));

  // Screenshot of the copyright bottom bar
  const bottomRect = await page.evaluate(() => {
    const el = document.querySelector('.tp-footer-bottom');
    if (!el) return null;
    const r = el.getBoundingClientRect();
    return { x: 0, y: r.top + window.scrollY, width: 1440, height: r.height };
  });

  if (bottomRect) {
    const shotPath = path.resolve(__dirname, 'screenshots_audit/footer_bottom_black_text.png');
    await page.screenshot({ path: shotPath, clip: bottomRect });
    console.log(`Saved screenshot to: ${shotPath}`);
  }

  await browser.close();

  if (colors.copyrightColor === 'rgb(0, 0, 0)') {
    console.log('SUCCESS: Footer bottom copyright content is now black color text!');
  } else {
    console.error(`FAILURE: Unexpected color: ${colors.copyrightColor}`);
    process.exit(1);
  }
})();
