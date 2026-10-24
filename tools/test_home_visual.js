const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function run() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,900', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 900 });

  const consoleMsgs = [];
  page.on('console', msg => consoleMsgs.push({ type: msg.type(), text: msg.text() }));

  const failedReqs = [];
  page.on('response', res => {
    if (res.status() >= 400) {
      failedReqs.push({ url: res.url(), status: res.status() });
    }
  });

  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle0', timeout: 30000 });

  // Evaluate hero background and dimensions
  const heroInfo = await page.evaluate(() => {
    const heroBg = document.querySelector('.tp-hero-bg');
    const heroTitle = document.querySelector('.tp-hero-title');
    const heroBtn = document.querySelector('.tp-hero-btn');
    const imgs = Array.from(document.querySelectorAll('img')).map(i => ({
      src: i.src,
      complete: i.complete,
      naturalWidth: i.naturalWidth,
      naturalHeight: i.naturalHeight
    }));
    const brokenImgs = imgs.filter(i => !i.complete || i.naturalWidth === 0);

    return {
      heroBgExists: !!heroBg,
      heroBgStyle: heroBg ? heroBg.getAttribute('style') : null,
      heroBgComputed: heroBg ? {
        backgroundImage: window.getComputedStyle(heroBg).backgroundImage,
        width: heroBg.offsetWidth,
        height: heroBg.offsetHeight,
        position: window.getComputedStyle(heroBg).position
      } : null,
      heroTitleColor: heroTitle ? window.getComputedStyle(heroTitle).color : null,
      totalImgs: imgs.length,
      brokenImgsCount: brokenImgs.length,
      brokenImgs: brokenImgs
    };
  });

  console.log('Hero Info:', JSON.stringify(heroInfo, null, 2));
  console.log('Failed Requests (4xx/5xx):', failedReqs);

  // Take screenshot
  await page.screenshot({ path: 'test_results/test_fixed_home.png', fullPage: true });
  console.log('Saved screenshot to test_results/test_fixed_home.png');

  await browser.close();
}

run().catch(console.error);
