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
  for (const w of [360, 375, 414]) {
    await page.setViewport({ width: w, height: 667 });
    await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

    const layout = await page.evaluate(() => {
      const row = document.querySelector('#header-sticky .row');
      const logo = document.querySelector('.tp-header-inner-logo');
      const brandText = document.querySelector('.brand-text-block');
      const contact = document.querySelector('.tp-header-2-contact');
      const login = document.querySelector('.tp-header-inner-login');
      const offcanvasBtn = document.querySelector('.offcanvas-btn');
      const openBtn = document.querySelector('.offcanvas-open-btn');

      return {
        rowHeight: row ? row.offsetHeight : null,
        logoRect: logo ? logo.getBoundingClientRect() : null,
        brandTextDisplay: brandText ? getComputedStyle(brandText).display : null,
        contactRect: contact ? contact.getBoundingClientRect() : null,
        loginRect: login ? login.getBoundingClientRect() : null,
        offcanvasBtnRect: offcanvasBtn ? offcanvasBtn.getBoundingClientRect() : null,
        openBtnRect: openBtn ? openBtn.getBoundingClientRect() : null
      };
    });

    console.log(`Viewport ${w}px:`, JSON.stringify(layout, null, 2));

    const shotPath = path.resolve(__dirname, `screenshots_audit/mobile_header_${w}.png`);
    await page.screenshot({
      path: shotPath,
      clip: { x: 0, y: 0, width: w, height: 100 }
    });
  }

  await browser.close();
})();
