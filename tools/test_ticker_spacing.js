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

  // Add temporary test style to inspect
  await page.addStyleTag({
    content: `
      .mgm-ticker-wrapper {
        margin-top: -32px !important;
        margin-bottom: 16px !important;
      }
      .elementor-1119 .elementor-element.elementor-element-67b227f {
        --margin-top: 0px !important;
        margin-top: 0px !important;
      }
    `
  });

  const positions = await page.evaluate(() => {
    const ticker = document.querySelector('.mgm-news-ticker-container');
    const cards = document.querySelector('.elementor-element-67b227f');
    const hero = document.querySelector('.tp-hero-area');
    const firstCard = document.querySelector('.tp-service-item');
    return {
      tickerTop: ticker.getBoundingClientRect().top + window.scrollY,
      tickerBottom: ticker.getBoundingClientRect().bottom + window.scrollY,
      cardsTop: cards.getBoundingClientRect().top + window.scrollY,
      firstCardTop: firstCard.getBoundingClientRect().top + window.scrollY,
      heroBottom: hero.getBoundingClientRect().bottom + window.scrollY
    };
  });

  console.log('Tested Positions:', positions);

  const shotPath = path.resolve(__dirname, 'screenshots_audit/home_entrance_ticker_spaced.png');
  await page.screenshot({
    path: shotPath,
    clip: {
      x: 0,
      y: 650,
      width: 1440,
      height: 600
    }
  });

  console.log(`Saved screenshot to: ${shotPath}`);
  await browser.close();
})();
