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
  
  const container6 = await page.evaluate(() => {
    const allDivs = document.querySelectorAll('.elementor-element.e-parent');
    let target = null;
    allDivs.forEach(el => {
      if (el.offsetHeight > 3000) target = el;
    });
    if (!target) return null;
    
    const children = Array.from(target.children).map(c => ({
      tag: c.tagName,
      className: c.className,
      height: c.offsetHeight,
      textPreview: c.textContent.trim().substring(0, 80).replace(/\s+/g, ' ')
    }));
    
    return {
      id: target.getAttribute('data-id'),
      height: target.offsetHeight,
      children
    };
  });
  
  console.log('Container 6 Details:', JSON.stringify(container6, null, 2));
  await browser.close();
})();
