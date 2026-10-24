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
  
  const analysis = await page.evaluate(() => {
    const res = [];
    const allDivs = document.querySelectorAll('.elementor-section, .elementor-element.e-parent, header, footer, section');
    allDivs.forEach((el) => {
      const rect = el.getBoundingClientRect();
      const style = window.getComputedStyle(el);
      // check if visible
      if (rect.height > 10) {
        res.push({
          tag: el.tagName,
          classes: el.className.split(' ').filter(c => c && !c.startsWith('elementor-element-')).join(' '),
          height: Math.round(rect.height),
          pt: style.paddingTop,
          pb: style.paddingBottom,
          mt: style.marginTop,
          mb: style.marginBottom,
          bg: style.backgroundColor
        });
      }
    });
    return res;
  });
  
  console.log('Homepage Major Containers:');
  console.log(JSON.stringify(analysis, null, 2));
  
  await browser.close();
})();
