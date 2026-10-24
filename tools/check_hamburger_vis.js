const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  for (const w of [1920, 1440, 1366, 1280, 1200, 1199, 1024, 992, 991, 768, 576, 375]) {
    await page.setViewport({ width: w, height: 800 });
    await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
    const vis = await page.evaluate(() => {
      const btn = document.querySelector('.offcanvas-open-btn');
      const parent = document.querySelector('.offcanvas-btn');
      const navMenu = document.querySelector('.tp-nav-menu');
      return {
        btnDisplay: btn ? getComputedStyle(btn).display : null,
        parentDisplay: parent ? getComputedStyle(parent).display : null,
        btnVisible: btn ? (btn.offsetWidth > 0 && btn.offsetHeight > 0) : false,
        navMenuVisible: navMenu ? (navMenu.offsetWidth > 0 && navMenu.offsetHeight > 0) : false
      };
    });
    console.log(`Viewport ${w}px:`, JSON.stringify(vis));
  }
  await browser.close();
})();
