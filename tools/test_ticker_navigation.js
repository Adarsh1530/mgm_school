const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  console.log('Testing clicking a notice from the ticker...');
  const firstTickerLink = await page.$('.mgm-ticker-item');
  const targetHref = await page.evaluate(el => el.getAttribute('href'), firstTickerLink);
  console.log(`Target notice href: ${targetHref}`);

  await Promise.all([
    page.waitForNavigation({ waitUntil: 'networkidle2' }),
    firstTickerLink.click()
  ]);

  const currentUrl = page.url();
  console.log(`Navigated to: ${currentUrl}`);

  if (currentUrl.includes('/notices/#notice-')) {
    console.log('[PASS] Clicking notice on the scroll successfully goes to the notice section!');
  } else {
    console.error('FAIL: Unexpected URL:', currentUrl);
  }

  await browser.close();
})();
