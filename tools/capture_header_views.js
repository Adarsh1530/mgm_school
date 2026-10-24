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

  // Desktop
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  const desktopShot = path.resolve(__dirname, 'screenshots_audit/header_desktop_no_hamburger.png');
  await page.screenshot({ path: desktopShot, clip: { x: 0, y: 0, width: 1440, height: 100 } });
  console.log(`Desktop header saved to: ${desktopShot}`);

  // Mobile
  await page.setViewport({ width: 375, height: 667, isMobile: true, hasTouch: true });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  const mobileShot = path.resolve(__dirname, 'screenshots_audit/header_mobile_with_hamburger.png');
  await page.screenshot({ path: mobileShot, clip: { x: 0, y: 0, width: 375, height: 80 } });
  console.log(`Mobile header saved to: ${mobileShot}`);

  await browser.close();
})();
