const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 375, height: 667 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const info = await page.evaluate(() => {
    function toObj(rect) {
      if (!rect) return null;
      return { top: rect.top, left: rect.left, right: rect.right, bottom: rect.bottom, width: rect.width, height: rect.height };
    }
    return {
      header: toObj(document.querySelector('#header-sticky')?.getBoundingClientRect()),
      logoImg: toObj(document.querySelector('.header-logo-img')?.getBoundingClientRect()),
      loginImg: toObj(document.querySelector('.tp-header-inner-login img')?.getBoundingClientRect()),
      btn: toObj(document.querySelector('.offcanvas-open-btn')?.getBoundingClientRect()),
      btnParent: toObj(document.querySelector('.offcanvas-btn')?.getBoundingClientRect()),
      btnStyles: {
        color: getComputedStyle(document.querySelector('.offcanvas-open-btn')).color,
        border: getComputedStyle(document.querySelector('.offcanvas-open-btn')).border,
        outline: getComputedStyle(document.querySelector('.offcanvas-open-btn')).outline,
        borderRadius: getComputedStyle(document.querySelector('.offcanvas-open-btn')).borderRadius,
        padding: getComputedStyle(document.querySelector('.offcanvas-open-btn')).padding
      }
    };
  });

  console.log(JSON.stringify(info, null, 2));
  await browser.close();
})();
