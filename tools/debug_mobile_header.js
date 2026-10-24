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
  await page.setViewport({ width: 375, height: 812 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const headerInfo = await page.evaluate(() => {
    const header = document.querySelector('#header-sticky');
    const logoCol = document.querySelector('.tp-header-inner-logo')?.parentElement;
    const actionCol = document.querySelector('.tp-header-2-contact')?.parentElement;
    const btn = document.querySelector('.offcanvas-open-btn');
    const login = document.querySelector('.tp-header-inner-login');
    
    return {
      headerHeight: header ? header.offsetHeight : null,
      logoCol: logoCol ? {
        className: logoCol.className,
        width: logoCol.offsetWidth,
        height: logoCol.offsetHeight,
        top: logoCol.getBoundingClientRect().top
      } : null,
      actionCol: actionCol ? {
        className: actionCol.className,
        width: actionCol.offsetWidth,
        height: actionCol.offsetHeight,
        top: actionCol.getBoundingClientRect().top
      } : null,
      btn: btn ? {
        top: btn.getBoundingClientRect().top,
        left: btn.getBoundingClientRect().left,
        width: btn.offsetWidth,
        height: btn.offsetHeight,
        computedStyles: {
          display: getComputedStyle(btn).display,
          margin: getComputedStyle(btn).margin,
          padding: getComputedStyle(btn).padding,
          border: getComputedStyle(btn).border,
          color: getComputedStyle(btn).color
        }
      } : null,
      login: login ? {
        display: getComputedStyle(login).display,
        width: login.offsetWidth
      } : null
    };
  });

  console.log('Mobile Header Info:', JSON.stringify(headerInfo, null, 2));

  const shotPath = path.resolve(__dirname, 'screenshots_audit/mobile_header_debug.png');
  await page.screenshot({
    path: shotPath,
    clip: { x: 0, y: 0, width: 375, height: 160 }
  });
  console.log(`Saved screenshot to: ${shotPath}`);

  await browser.close();
})();
