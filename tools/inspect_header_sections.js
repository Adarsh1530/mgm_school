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
  await page.setViewport({ width: 1366, height: 768 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });
  
  // Header inspection
  const headerInfo = await page.evaluate(() => {
    const topBar = document.querySelector('.tp-header-top');
    const mainHeader = document.querySelector('#header-sticky');
    const logo = document.querySelector('.tp-header-inner-logo');
    const menu = document.querySelector('.main-menu');
    const rightSide = document.querySelector('.tp-header-right');
    const hero = document.querySelector('.hero-area, .tp-slider-area, .slider-area');
    
    return {
      topBar: topBar ? { height: topBar.offsetHeight, display: window.getComputedStyle(topBar).display } : null,
      mainHeader: mainHeader ? { height: mainHeader.offsetHeight } : null,
      logoRect: logo ? logo.getBoundingClientRect() : null,
      menuRect: menu ? menu.getBoundingClientRect() : null,
      rightSideRect: rightSide ? rightSide.getBoundingClientRect() : null,
      heroRect: hero ? hero.getBoundingClientRect() : null
    };
  });
  
  console.log('Header Info:', JSON.stringify(headerInfo, null, 2));
  
  // Let's also inspect all sections on Homepage and their spacing
  const sections = await page.evaluate(() => {
    const list = [];
    document.querySelectorAll('body > main > section, body > main > div').forEach((s, idx) => {
      const style = window.getComputedStyle(s);
      list.push({
        idx,
        tag: s.tagName,
        className: s.className,
        id: s.id,
        height: s.offsetHeight,
        pt: style.paddingTop,
        pb: style.paddingBottom,
        mt: style.marginTop,
        mb: style.marginBottom
      });
    });
    return list;
  });
  
  console.log('Homepage Sections:', JSON.stringify(sections, null, 2));
  
  await browser.close();
})();
