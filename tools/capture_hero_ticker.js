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
  await page.setViewport({ width: 1440, height: 1080 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  // Get ticker element position
  const tickerInfo = await page.evaluate(() => {
    const ticker = document.querySelector('.mgm-news-ticker-container');
    const cards = document.querySelector('.elementor-element-67b227f');
    const hero = document.querySelector('.tp-hero-area');
    return {
      ticker: ticker ? {
        top: ticker.getBoundingClientRect().top + window.scrollY,
        height: ticker.offsetHeight,
        width: ticker.offsetWidth
      } : null,
      hero: hero ? {
        top: hero.getBoundingClientRect().top + window.scrollY,
        height: hero.offsetHeight
      } : null,
      cards: cards ? {
        top: cards.getBoundingClientRect().top + window.scrollY,
        height: cards.offsetHeight
      } : null
    };
  });

  console.log('Layout Coordinates:', JSON.stringify(tickerInfo, null, 2));

  // Take screenshot of hero + ticker + cards
  const shotPath = path.resolve(__dirname, 'screenshots_audit/home_entrance_ticker.png');
  await page.screenshot({
    path: shotPath,
    clip: {
      x: 0,
      y: 0,
      width: 1440,
      height: 1100
    }
  });

  console.log(`Saved screenshot to: ${shotPath}`);
  await browser.close();
})();
