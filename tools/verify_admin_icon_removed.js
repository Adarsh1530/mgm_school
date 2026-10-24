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

  // 1. Desktop Test
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const desktopAudit = await page.evaluate(() => {
    const loginDiv = document.querySelector('.tp-header-inner-login');
    const profileImg = document.querySelector('header img[src*="profile-photo.png"]');
    const adminLink = document.querySelector('header a[href*="admin/login"]');
    return {
      hasLoginDiv: !!loginDiv,
      hasProfileImg: !!profileImg,
      hasAdminLink: !!adminLink
    };
  });

  console.log('Desktop Header Audit:', desktopAudit);

  const desktopShot = path.resolve(__dirname, 'screenshots_audit/header_no_admin_desktop.png');
  await page.screenshot({ path: desktopShot, clip: { x: 0, y: 0, width: 1440, height: 120 } });
  console.log(`Desktop header screenshot: ${desktopShot}`);

  // 2. Mobile Test
  await page.setViewport({ width: 375, height: 667, isMobile: true, hasTouch: true });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const mobileAudit = await page.evaluate(() => {
    const loginDiv = document.querySelector('.tp-header-inner-login');
    const profileImg = document.querySelector('header img[src*="profile-photo.png"]');
    const adminLink = document.querySelector('header a[href*="admin/login"]');
    const hamburgerBtn = document.querySelector('.offcanvas-open-btn');
    return {
      hasLoginDiv: !!loginDiv,
      hasProfileImg: !!profileImg,
      hasAdminLink: !!adminLink,
      hasHamburger: !!hamburgerBtn,
      btnRect: hamburgerBtn ? hamburgerBtn.getBoundingClientRect() : null
    };
  });

  console.log('Mobile Header Audit:', JSON.stringify(mobileAudit, null, 2));

  const mobileShot = path.resolve(__dirname, 'screenshots_audit/header_no_admin_mobile.png');
  await page.screenshot({ path: mobileShot, clip: { x: 0, y: 0, width: 375, height: 90 } });
  console.log(`Mobile header screenshot: ${mobileShot}`);

  await browser.close();

  if (!desktopAudit.hasLoginDiv && !desktopAudit.hasProfileImg && !mobileAudit.hasLoginDiv && !mobileAudit.hasProfileImg) {
    console.log('SUCCESS: Admin panel icon completely removed from header!');
  } else {
    console.error('FAILURE: Admin icon still present!');
    process.exit(1);
  }
})();
