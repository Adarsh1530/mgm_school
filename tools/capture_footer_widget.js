const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  
  // Take screenshot of the actual footer on localhost
  const footerWidget = await page.$('.tp-footer-widget');
  if (footerWidget) {
    await footerWidget.screenshot({ path: 'tools/footer_widget_screenshot.png' });
    console.log('Saved tools/footer_widget_screenshot.png');
  }

  await browser.close();
})();
