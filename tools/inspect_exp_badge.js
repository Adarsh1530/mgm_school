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
  
  const exp = await page.evaluate(() => {
    const el = document.querySelector('[data-id="eeea485"]');
    if (!el) return null;
    const style = window.getComputedStyle(el);
    const num = el.querySelector('.elementor-counter-number');
    const title = el.querySelector('.elementor-heading-title');
    return {
      text: el.innerText.trim(),
      numberText: num ? num.innerText : null,
      titleText: title ? title.innerText : null,
      display: style.display,
      visibility: style.visibility,
      position: style.position,
      top: style.top,
      left: style.left,
      width: el.offsetWidth,
      height: el.offsetHeight,
      rect: el.getBoundingClientRect()
    };
  });
  
  console.log('Experience badge on Homepage:', JSON.stringify(exp, null, 2));
  await browser.close();
})();
