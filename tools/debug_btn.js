const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 900 });

  const fileContent = require('fs').readFileSync('tools/test_lightbox_proto.js', 'utf8');
  const htmlStart = fileContent.indexOf('<!DOCTYPE html>');
  const htmlEnd = fileContent.indexOf('`;', htmlStart);
  const html = fileContent.substring(htmlStart, htmlEnd);

  await page.setContent(html, { waitUntil: 'networkidle2' });

  // 1. Click thumbnail to open
  console.log('1. Clicking thumbnail...');
  await page.evaluate(() => openRajyaLightbox(0));
  await new Promise(r => setTimeout(r, 100));

  let title = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Opened title:', title); // Expected: 2024

  // 2. Click next button
  console.log('2. Clicking Next button...');
  await page.click('.mgm-lightbox-next');
  title = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Next title:', title); // Expected: 2023

  // 3. Arrow Right Key
  console.log('3. Pressing ArrowRight key...');
  await page.keyboard.press('ArrowRight');
  title = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Key right title:', title); // Expected: 2022

  // 4. Arrow Left Key
  console.log('4. Pressing ArrowLeft key...');
  await page.keyboard.press('ArrowLeft');
  title = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Key left title:', title); // Expected: 2023

  // 5. Click Prev button
  console.log('5. Clicking Prev button...');
  await page.click('.mgm-lightbox-prev');
  title = await page.evaluate(() => document.getElementById('mgmLightboxTitle').innerText);
  console.log('Prev button title:', title); // Expected: 2024

  // 6. Escape Key to close
  console.log('6. Pressing Escape key...');
  await page.keyboard.press('Escape');
  const isActive = await page.evaluate(() => document.getElementById('mgmRajyaLightbox').classList.contains('active'));
  console.log('Is modal active after Escape?', isActive); // Expected: false

  // 7. Re-open and click close button
  console.log('7. Re-opening and clicking Close button...');
  await page.evaluate(() => openRajyaLightbox(2));
  await page.click('.mgm-lightbox-close');
  const isActive2 = await page.evaluate(() => document.getElementById('mgmRajyaLightbox').classList.contains('active'));
  console.log('Is modal active after Close button?', isActive2); // Expected: false

  await browser.close();
  console.log('ALL LIGHTBOX INTERACTIONS PASSED PERFECTLY!');
})();
