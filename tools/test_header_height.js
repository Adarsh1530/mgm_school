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
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  
  const header = await page.evaluate(() => {
    const el = document.querySelector('#header-sticky');
    return {
      offsetHeight: el ? el.offsetHeight : null,
      logoSrc: el ? el.querySelector('img').src : null,
      brandTitle: el ? el.querySelector('.brand-title')?.innerText : null
    };
  });
  
  console.log('Desktop Header (1366px):', header);
  
  // Test 1200px (standard laptop)
  await page.setViewport({ width: 1200, height: 768 });
  const header1200 = await page.evaluate(() => {
    const el = document.querySelector('#header-sticky');
    return { offsetHeight: el ? el.offsetHeight : null };
  });
  console.log('Laptop Header (1200px):', header1200);

  // Test Mobile (375px)
  await page.setViewport({ width: 375, height: 667, isMobile: true });
  const headerMobile = await page.evaluate(() => {
    const el = document.querySelector('#header-sticky');
    return { offsetHeight: el ? el.offsetHeight : null };
  });
  console.log('Mobile Header (375px):', headerMobile);

  await browser.close();
})();
