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

  const errors = [];
  page.on('console', msg => {
    if (msg.type() === 'error') errors.push(msg.text());
  });

  console.log('--- 1. VERIFYING DESKTOP HEADER NAVIGATION ORDER ---');
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const navOrder = await page.evaluate(() => {
    const items = Array.from(document.querySelectorAll('.tp-nav-menu > li > a')).map(a => a.innerText.trim());
    const activitiesSub = Array.from(document.querySelectorAll('.tp-nav-menu > li:nth-child(4) .dropdown-menu-custom li a')).map(a => a.innerText.trim());
    return { topNav: items, activitiesSub };
  });

  console.log('Top Nav Items:', navOrder.topNav);
  console.log('Activities Sub-Items:', navOrder.activitiesSub);

  const expectedTop = [
    'Home',
    'About Us',
    'Academics',
    'Activities',
    'Gallery',
    'Notices',
    'Mandatory Disclosure',
    'Contact'
  ];

  let orderPass = true;
  for (let i = 0; i < expectedTop.length; i++) {
    if (!navOrder.topNav[i] || !navOrder.topNav[i].toLowerCase().includes(expectedTop[i].toLowerCase())) {
      console.error(`Nav Order Mismatch at index ${i}: Expected ${expectedTop[i]}, Got ${navOrder.topNav[i]}`);
      orderPass = false;
    }
  }

  const galleryInActivities = navOrder.activitiesSub.some(s => s.toLowerCase().includes('gallery'));
  if (galleryInActivities) {
    console.error('FAIL: Gallery is still inside Activities sub-menu!');
    orderPass = false;
  } else {
    console.log('[PASS] Gallery successfully separated from Activities dropdown.');
  }

  if (orderPass) {
    console.log('[PASS] Navigation order matches requirements 100%!');
  }

  console.log('\n--- 2. VERIFYING HOMEPAGE ENTRANCE SCROLLING NEWS TICKER ---');
  const tickerCheck = await page.evaluate(() => {
    const container = document.querySelector('.mgm-news-ticker-container');
    const track = document.querySelector('.mgm-ticker-track');
    const items = Array.from(document.querySelectorAll('.mgm-ticker-item'));
    return {
      hasContainer: !!container,
      hasTrack: !!track,
      itemCount: items.length,
      sampleTitles: items.slice(0, 3).map(i => i.querySelector('.mgm-ticker-text')?.innerText.trim()),
      sampleHrefs: items.slice(0, 3).map(i => i.getAttribute('href')),
      initialPlayState: track ? getComputedStyle(track).animationPlayState : null
    };
  });

  console.log('Ticker Check:', JSON.stringify(tickerCheck, null, 2));

  // Test Pause on Hover
  await page.hover('.mgm-news-ticker-container');
  const hoverPlayState = await page.evaluate(() => {
    const track = document.querySelector('.mgm-ticker-track');
    return track ? getComputedStyle(track).animationPlayState : null;
  });
  console.log(`Animation play state on hover: ${hoverPlayState} (Expected: paused)`);

  if (hoverPlayState === 'paused') {
    console.log('[PASS] Scrolling ticker pauses on cursor hover.');
  } else {
    console.error('FAIL: Scrolling ticker did not pause on hover.');
  }

  // Move cursor away and verify resume
  await page.mouse.move(0, 0);
  const resumePlayState = await page.evaluate(() => {
    const track = document.querySelector('.mgm-ticker-track');
    return track ? getComputedStyle(track).animationPlayState : null;
  });
  console.log(`Animation play state after unhover: ${resumePlayState} (Expected: running)`);

  console.log('\n--- 3. VERIFYING NOTICES PAGE (/notices/) ---');
  const noticesRes = await page.goto('http://localhost/MGM%20SCHOOL/notices/', { waitUntil: 'networkidle2' });
  console.log(`Notices Page HTTP Status: ${noticesRes.status()}`);

  const noticesAudit = await page.evaluate(() => {
    const cards = Array.from(document.querySelectorAll('.notice-item-card'));
    const sidebarEntries = Array.from(document.querySelectorAll('.sidebar-notice-link'));
    const filterBtns = Array.from(document.querySelectorAll('.notice-filter-btn'));
    const brokenImgs = Array.from(document.querySelectorAll('img')).filter(img => !img.complete || img.naturalWidth === 0);

    return {
      cardsCount: cards.length,
      sidebarEntriesCount: sidebarEntries.length,
      filtersCount: filterBtns.length,
      brokenImagesCount: brokenImgs.length,
      sampleCards: cards.slice(0, 2).map(c => ({
        id: c.id,
        category: c.getAttribute('data-category'),
        title: c.querySelector('h5')?.innerText.trim(),
        date: c.querySelector('.text-muted')?.innerText.trim()
      }))
    };
  });

  console.log('Notices Audit:', JSON.stringify(noticesAudit, null, 2));

  // Test category filter click
  await page.click('.notice-filter-btn[data-category="Admission"]');
  const filteredAdmission = await page.evaluate(() => {
    const visibleCards = Array.from(document.querySelectorAll('.notice-item-card'))
      .filter(c => c.style.display !== 'none');
    return visibleCards.map(c => c.getAttribute('data-category'));
  });
  console.log('Visible cards after clicking "Admissions" filter:', filteredAdmission);

  // Test modal popup
  await page.click('.notice-filter-btn[data-category="all"]');
  await page.click('.notice-detail-btn');
  await new Promise(r => setTimeout(r, 600));

  const modalOpen = await page.evaluate(() => {
    const modal = document.querySelector('#noticeModal');
    return modal && modal.classList.contains('show');
  });
  console.log(`Notice Modal open after clicking details: ${modalOpen}`);

  // Screenshot Notices Page
  const noticesShot = path.resolve(__dirname, 'screenshots_audit/notices_page.png');
  await page.screenshot({ path: noticesShot, fullPage: true });
  console.log(`Saved notices page screenshot to: ${noticesShot}`);

  console.log('\n--- 4. VERIFYING MOBILE DRAWER ORDER ---');
  await page.setViewport({ width: 375, height: 812 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  const mobileNav = await page.evaluate(() => {
    const links = Array.from(document.querySelectorAll('.offcanvas-menu > ul > li > a > span')).map(s => s.innerText.trim());
    return links;
  });
  console.log('Mobile Nav Items:', mobileNav);

  await browser.close();

  console.log('\n=== ALL AUDITS COMPLETE ===');
})();
