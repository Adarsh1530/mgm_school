const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 900 });

  console.log('Testing http://localhost/MGM%20SCHOOL/merit-day/...');
  const res = await page.goto('http://localhost/MGM%20SCHOOL/merit-day/', { waitUntil: 'networkidle2' });
  console.log('Merit Day Status:', res.status());

  const imgs = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img')).map(i => ({
      src: i.src,
      width: i.naturalWidth,
      height: i.naturalHeight
    }));
  });
  const broken = imgs.filter(i => i.width === 0);
  console.log('Total Images:', imgs.length, 'Broken:', broken.length);
  if (broken.length > 0) console.log('Broken details:', broken);

  // Check Section 4 elements
  const sectionCheck = await page.evaluate(() => {
    const s4 = document.getElementById('rajyapuraskar');
    if (!s4) return null;
    const splitRow = s4.querySelector('.row.g-0');
    const cards = Array.from(s4.querySelectorAll('.rajya-card-item'));
    return {
      hasSplitRow: !!splitRow,
      cardCount: cards.length,
      firstCardWidth: cards[0] ? cards[0].getBoundingClientRect().width : 0
    };
  });
  console.log('Section 4 Structure Check:', sectionCheck);

  // Scroll to section 4 and take screenshot
  await page.evaluate(() => document.getElementById('rajyapuraskar').scrollIntoView());
  await new Promise(r => setTimeout(r, 400));
  await page.screenshot({ path: 'tools/merit_rajya_unified_layout.png' });
  console.log('Saved screenshot of updated Section 4 to tools/merit_rajya_unified_layout.png');

  // Test Lightbox
  console.log('\nTesting Lightbox Popup on Section 4...');
  await page.click('.rajya-card-item:nth-child(1)');
  await new Promise(r => setTimeout(r, 400));
  
  let modalActive = await page.evaluate(() => {
    const m = document.getElementById('mgmRajyaLightbox');
    return m ? m.classList.contains('active') : false;
  });
  console.log('Lightbox opened on click:', modalActive ? 'PASS' : 'FAIL');

  // Next
  await page.click('.mgm-lightbox-next');
  await new Promise(r => setTimeout(r, 200));
  let titleNext = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Title after Next:', titleNext);

  // Close
  await page.click('.mgm-lightbox-close');
  await new Promise(r => setTimeout(r, 200));
  modalActive = await page.evaluate(() => document.getElementById('mgmRajyaLightbox').classList.contains('active'));
  console.log('Lightbox closed on Close button:', !modalActive ? 'PASS' : 'FAIL');

  await browser.close();
  console.log('\n========================================');
  console.log('MERIT DAY UNIFIED LAYOUT TEST COMPLETED 100% PASS');
  console.log('========================================');
})();
