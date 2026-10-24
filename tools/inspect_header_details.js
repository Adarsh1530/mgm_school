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
  
  const headerDetails = await page.evaluate(() => {
    const header = document.querySelector('#header-sticky');
    const container = header.querySelector('.container');
    const row = header.querySelector('.row');
    const logoCol = row.children[0];
    const navCol = row.children[1];
    const btnCol = row.children[2];
    const logoImg = logoCol.querySelector('img');
    
    return {
      headerHeight: header.offsetHeight,
      containerHeight: container ? container.offsetHeight : null,
      rowHeight: row ? row.offsetHeight : null,
      logoCol: {
        height: logoCol ? logoCol.offsetHeight : null,
        imgHeight: logoImg ? logoImg.offsetHeight : null,
        imgNaturalHeight: logoImg ? logoImg.naturalHeight : null,
        imgSrc: logoImg ? logoImg.src : null,
        imgStyles: logoImg ? {
          padding: window.getComputedStyle(logoImg).padding,
          margin: window.getComputedStyle(logoImg).margin,
          maxHeight: window.getComputedStyle(logoImg).maxHeight,
          height: window.getComputedStyle(logoImg).height
        } : null
      },
      navCol: {
        height: navCol ? navCol.offsetHeight : null,
        ulHeight: navCol ? navCol.querySelector('ul').offsetHeight : null,
        liHeights: navCol ? Array.from(navCol.querySelectorAll('li.has-dropdown, li')).slice(0, 5).map(li => ({
          text: li.textContent.trim().split('\n')[0],
          height: li.offsetHeight,
          padding: window.getComputedStyle(li).padding
        })) : null
      },
      btnCol: {
        height: btnCol ? btnCol.offsetHeight : null
      }
    };
  });
  
  console.log(JSON.stringify(headerDetails, null, 2));
  await browser.close();
})();
