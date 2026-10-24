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
  await page.setViewport({ width: 375, height: 667, isMobile: true, hasTouch: true });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  console.log('--- 1. CHECKING MOBILE HEADER ALIGNMENT ---');
  const headerAudit = await page.evaluate(() => {
    const header = document.querySelector('#header-sticky');
    const logoImg = document.querySelector('.header-logo-img');
    const btn = document.querySelector('.offcanvas-open-btn');
    const searchInDrawer = document.querySelector('.offcanvas-wrapper form');
    const searchInputs = document.querySelectorAll('.offcanvas-wrapper input[name="search"]');

    const btnRect = btn.getBoundingClientRect();
    const logoRect = logoImg.getBoundingClientRect();
    const headerRect = header.getBoundingClientRect();

    return {
      headerHeight: headerRect.height,
      logoCenterY: logoRect.top + (logoRect.height / 2),
      btnCenterY: btnRect.top + (btnRect.height / 2),
      btnWidth: btnRect.width,
      btnHeight: btnRect.height,
      btnRightMargin: headerRect.right - btnRect.right,
      searchFormCount: searchInDrawer ? 1 : 0,
      searchInputsCount: searchInputs.length
    };
  });

  console.log('Header Layout Audit:', JSON.stringify(headerAudit, null, 2));

  // Check vertical alignment difference between logo and button
  const verticalDiff = Math.abs(headerAudit.logoCenterY - headerAudit.btnCenterY);
  console.log(`Vertical alignment difference between logo and button center: ${verticalDiff.toFixed(2)}px`);

  if (verticalDiff <= 3) {
    console.log('[PASS] Logo and Mobile Hamburger button are vertically aligned!');
  } else {
    console.warn(`[WARN] Vertical difference is ${verticalDiff.toFixed(2)}px`);
  }

  // Check search bar removal
  if (headerAudit.searchFormCount === 0 && headerAudit.searchInputsCount === 0) {
    console.log('[PASS] Search bar successfully removed from mobile drawer!');
  } else {
    console.error('FAIL: Search bar still found in mobile drawer!');
  }

  // Test Hover / Focus Color
  await page.hover('.offcanvas-open-btn');
  const hoverStyles = await page.evaluate(() => {
    const btn = document.querySelector('.offcanvas-open-btn');
    const icon = btn.querySelector('i');
    return {
      btnBorder: getComputedStyle(btn).borderColor,
      iconColor: getComputedStyle(icon).color
    };
  });
  console.log('Hover/Focus Button Styles:', hoverStyles);

  // Take screenshot of closed mobile header
  const headerShotPath = path.resolve(__dirname, 'screenshots_audit/mobile_header_fixed.png');
  await page.screenshot({
    path: headerShotPath,
    clip: { x: 0, y: 0, width: 375, height: 100 }
  });
  console.log(`Saved mobile header screenshot to: ${headerShotPath}`);

  console.log('\n--- 2. OPENING MOBILE DRAWER ---');
  await page.click('.offcanvas-open-btn');
  await new Promise(r => setTimeout(r, 500));

  const drawerAudit = await page.evaluate(() => {
    const wrapper = document.querySelector('.offcanvas-wrapper');
    const overlay = document.querySelector('.offcanvas-overlay');
    const links = Array.from(document.querySelectorAll('.offcanvas-menu > ul > li > a > span')).map(s => s.innerText.trim());
    const hasSearch = !!wrapper.querySelector('form');

    return {
      drawerOpen: wrapper && parseInt(getComputedStyle(wrapper).right) >= 0,
      overlayActive: overlay && overlay.classList.contains('active'),
      menuItems: links,
      hasSearchInOpenDrawer: hasSearch
    };
  });

  console.log('Drawer Open Audit:', JSON.stringify(drawerAudit, null, 2));

  const drawerShotPath = path.resolve(__dirname, 'screenshots_audit/mobile_drawer_no_search.png');
  await page.screenshot({ path: drawerShotPath });
  console.log(`Saved mobile drawer screenshot to: ${drawerShotPath}`);

  await browser.close();
  console.log('\n=== MOBILE AUDIT COMPLETE ===');
})();
