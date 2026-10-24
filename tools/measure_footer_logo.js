const puppeteer = require('puppeteer-core');
const fs = require('fs');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  
  const metrics = await page.evaluate(() => {
    const a = document.querySelector('.tp-footer-logo a');
    const badge = a.children[0];
    const img = badge.querySelector('img');
    const textWrap = a.children[1];
    const title = textWrap.children[0];
    const sub = textWrap.children[1];
    
    const aRect = a.getBoundingClientRect();
    const badgeRect = badge.getBoundingClientRect();
    const imgRect = img.getBoundingClientRect();
    const textRect = textWrap.getBoundingClientRect();
    const titleRect = title.getBoundingClientRect();
    const subRect = sub.getBoundingClientRect();
    
    return {
      aRect: { h: aRect.height },
      badge: {
        top: badgeRect.top - aRect.top,
        left: badgeRect.left - aRect.left,
        w: badgeRect.width,
        h: badgeRect.height,
        imgOffsetTop: imgRect.top - badgeRect.top,
        imgOffsetBottom: badgeRect.bottom - imgRect.bottom,
        imgOffsetLeft: imgRect.left - badgeRect.left,
        imgOffsetRight: badgeRect.right - imgRect.right,
        imgW: imgRect.width,
        imgH: imgRect.height
      },
      text: {
        top: textRect.top - aRect.top,
        h: textRect.height,
        titleBaseline: titleRect.top - aRect.top,
        subBaseline: subRect.top - aRect.top
      }
    };
  });
  
  console.log('Footer Logo Metrics:', JSON.stringify(metrics, null, 2));
  await browser.close();
})();
