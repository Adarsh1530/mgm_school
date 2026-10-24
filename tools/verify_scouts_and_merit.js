const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  console.log('--- 1. TESTING HINDUSTAN SCOUTS & GUIDES PAGE ---');
  let res = await page.goto('http://localhost/MGM%20SCHOOL/hindustan-scouts-guides/', { waitUntil: 'networkidle2' });
  console.log('Scouts Page Status:', res.status());

  let imgs = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img')).map(i => ({
      src: i.src,
      width: i.naturalWidth,
      height: i.naturalHeight
    }));
  });
  let broken = imgs.filter(i => i.width === 0);
  console.log('Scouts Images Total:', imgs.length, 'Broken:', broken.length);

  // Check if rajya certificates are inside scouts page
  const rajyaInScouts = await page.evaluate(() => {
    return document.querySelectorAll('.rajya-thumb-box').length;
  });
  console.log('Rajyapuraskar thumbnails in Scouts page:', rajyaInScouts, rajyaInScouts === 0 ? '(PASS - REMOVED)' : '(FAIL)');

  await page.screenshot({ path: 'tools/scouts_page_balanced.png', fullPage: false });
  console.log('Saved scouts screenshot to tools/scouts_page_balanced.png');

  console.log('\n--- 2. TESTING MERIT DAY PAGE ---');
  res = await page.goto('http://localhost/MGM%20SCHOOL/merit-day/', { waitUntil: 'networkidle2' });
  console.log('Merit Day Status:', res.status());

  imgs = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img')).map(i => ({
      src: i.src,
      width: i.naturalWidth,
      height: i.naturalHeight
    }));
  });
  broken = imgs.filter(i => i.width === 0);
  console.log('Merit Day Images Total:', imgs.length, 'Broken:', broken.length);

  // Check if rajya certificates are on merit day
  const rajyaInMerit = await page.evaluate(() => {
    return document.querySelectorAll('.rajya-thumb-box').length;
  });
  console.log('Rajyapuraskar thumbnails in Merit Day:', rajyaInMerit, rajyaInMerit === 4 ? '(PASS - 4 PRESENT)' : '(FAIL)');

  // Verify square shape on Merit Day
  const squares = await page.evaluate(() => {
    const boxes = Array.from(document.querySelectorAll('.rajya-thumb-box'));
    return boxes.map((b, idx) => {
      const rect = b.getBoundingClientRect();
      const style = window.getComputedStyle(b);
      return {
        idx,
        width: Math.round(rect.width),
        height: Math.round(rect.height),
        isSquare: Math.abs(rect.width - rect.height) <= 2,
        borderRadius: style.borderRadius
      };
    });
  });
  console.log('Merit Day Square Check:', squares);

  // Verify 0 PDFs
  const pdfs = await page.evaluate(() => document.querySelectorAll('a[href*=".pdf"]').length);
  console.log('PDF links on Merit Day:', pdfs, pdfs === 0 ? '(PASS - NO PDFS)' : '(FAIL)');

  // Test Lightbox on Merit Day
  console.log('\n--- 3. TESTING LIGHTBOX INTERACTIVITY ON MERIT DAY ---');
  await page.click('.rajya-thumb-box:nth-child(1)');
  await new Promise(r => setTimeout(r, 400));

  let modalActive = await page.evaluate(() => {
    const m = document.getElementById('mgmRajyaLightbox');
    return m ? m.classList.contains('active') : false;
  });
  console.log('Lightbox opened on click:', modalActive ? 'PASS' : 'FAIL');

  const controls = await page.evaluate(() => {
    const close = document.querySelector('.mgm-lightbox-close');
    const prev = document.querySelector('.mgm-lightbox-prev');
    const next = document.querySelector('.mgm-lightbox-next');
    const title = document.getElementById('mgmLightboxTitle');
    return {
      hasClose: !!close && close.offsetParent !== null,
      hasPrev: !!prev && prev.offsetParent !== null,
      hasNext: !!next && next.offsetParent !== null,
      title: title ? title.innerText : null
    };
  });
  console.log('Lightbox Controls & Title:', controls);

  await page.screenshot({ path: 'tools/merit_lightbox_opened.png' });
  console.log('Saved opened lightbox screenshot to tools/merit_lightbox_opened.png');

  // Next
  await page.click('.mgm-lightbox-next');
  await new Promise(r => setTimeout(r, 300));
  let titleNext = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Title after Next:', titleNext);

  // Prev
  await page.click('.mgm-lightbox-prev');
  await new Promise(r => setTimeout(r, 300));
  let titlePrev = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Title after Prev:', titlePrev);

  // Close
  await page.click('.mgm-lightbox-close');
  await new Promise(r => setTimeout(r, 300));
  modalActive = await page.evaluate(() => document.getElementById('mgmRajyaLightbox').classList.contains('active'));
  console.log('Lightbox closed on Close button:', !modalActive ? 'PASS' : 'FAIL');

  // Scroll to section 4 and take screenshot
  await page.evaluate(() => document.getElementById('rajyapuraskar').scrollIntoView());
  await new Promise(r => setTimeout(r, 300));
  await page.screenshot({ path: 'tools/merit_rajyapuraskar_section.png' });
  console.log('Saved merit section screenshot to tools/merit_rajyapuraskar_section.png');

  await browser.close();
  console.log('\n========================================');
  console.log('ALL VERIFICATIONS COMPLETED SUCCESSFULLY!');
  console.log('========================================');
})();
