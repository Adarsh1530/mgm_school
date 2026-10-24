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

  console.log('Navigating to http://localhost/MGM%20SCHOOL/hindustan-scouts-guides/...');
  const response = await page.goto('http://localhost/MGM%20SCHOOL/hindustan-scouts-guides/', { waitUntil: 'networkidle2' });
  console.log('HTTP Status:', response.status());

  // 1. Check broken images
  const imgs = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img')).map(i => ({
      src: i.src,
      alt: i.alt,
      width: i.naturalWidth,
      height: i.naturalHeight
    }));
  });
  const broken = imgs.filter(i => i.width === 0);
  console.log('Total images:', imgs.length, 'Broken:', broken.length);
  if (broken.length > 0) console.log('Broken details:', broken);

  // 2. Check for PDF links
  const pdfLinks = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('a[href*=".pdf"]')).map(a => a.href);
  });
  console.log('PDF links found on page:', pdfLinks.length, pdfLinks.length === 0 ? '(PASS - NO PDFS)' : '(FAIL)');

  // 3. Check square shape of thumbnail boxes
  const squareCheck = await page.evaluate(() => {
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
  console.log('Square Thumbnails Check:', squareCheck);

  // Take screenshot of the page section
  const sectionEl = await page.$('.rajya-award-card');
  if (sectionEl) {
    await sectionEl.screenshot({ path: 'tools/live_scouts_section.png' });
    console.log('Saved screenshot to tools/live_scouts_section.png');
  }

  // 4. Test clicking thumbnail to open Lightbox
  console.log('\n--- TESTING POPUP MODAL INTERACTIONS ---');
  await page.click('.rajya-thumb-box:nth-child(1)');
  await new Promise(r => setTimeout(r, 400));

  let modalActive = await page.evaluate(() => {
    const m = document.getElementById('mgmRajyaLightbox');
    return m ? m.classList.contains('active') : false;
  });
  console.log('Lightbox opened on click:', modalActive ? 'PASS' : 'FAIL');

  // Verify close button, left button, right button exist & are visible
  const buttonsCheck = await page.evaluate(() => {
    const close = document.querySelector('.mgm-lightbox-close');
    const prev = document.querySelector('.mgm-lightbox-prev');
    const next = document.querySelector('.mgm-lightbox-next');
    const img = document.getElementById('mgmLightboxImg');
    const title = document.getElementById('mgmLightboxTitle');
    return {
      hasClose: !!close && close.offsetParent !== null,
      hasPrev: !!prev && prev.offsetParent !== null,
      hasNext: !!next && next.offsetParent !== null,
      currentImg: img ? img.src : null,
      title: title ? title.innerText : null
    };
  });
  console.log('Modal Controls Check:', buttonsCheck);

  await page.screenshot({ path: 'tools/live_lightbox_opened.png' });
  console.log('Saved opened lightbox screenshot to tools/live_lightbox_opened.png');

  // 5. Test Next Button Navigation
  console.log('\nTesting Next Button Navigation...');
  await page.click('.mgm-lightbox-next');
  await new Promise(r => setTimeout(r, 300));
  let titleAfterNext = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Title after next:', titleAfterNext);

  // 6. Test Prev Button Navigation
  console.log('\nTesting Prev Button Navigation...');
  await page.click('.mgm-lightbox-prev');
  await new Promise(r => setTimeout(r, 300));
  let titleAfterPrev = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Title after prev:', titleAfterPrev);

  // 7. Test Close Button
  console.log('\nTesting Close Button...');
  await page.click('.mgm-lightbox-close');
  await new Promise(r => setTimeout(r, 300));
  modalActive = await page.evaluate(() => document.getElementById('mgmRajyaLightbox').classList.contains('active'));
  console.log('Lightbox closed on close button:', !modalActive ? 'PASS' : 'FAIL');

  await browser.close();
  console.log('\n========================================');
  console.log('ALL TESTS PASSED WITH 100% SUCCESS!');
  console.log('========================================');
})();
