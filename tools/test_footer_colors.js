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

  console.log('Navigating to http://localhost/MGM%20SCHOOL/...');
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  // Scroll to footer
  await page.evaluate(() => document.querySelector('.tp-footer-area').scrollIntoView());
  await new Promise(r => setTimeout(r, 400));

  // Inspect all text elements inside .tp-footer-area
  const footerElements = await page.evaluate(() => {
    const footer = document.querySelector('.tp-footer-area');
    if (!footer) return null;

    const allNodes = Array.from(footer.querySelectorAll('p, a, span, div, h4, li'));
    return allNodes.map(el => {
      const text = el.innerText ? el.innerText.trim().replace(/\s+/g, ' ') : '';
      if (!text || el.children.length > 2) return null; // Only evaluate leaf/direct text nodes
      const comp = window.getComputedStyle(el);
      return {
        tag: el.tagName.toLowerCase(),
        text: text.substring(0, 40),
        color: comp.color,
        isWhite: comp.color === 'rgb(255, 255, 255)'
      };
    }).filter(Boolean);
  });

  console.log('\n--- FOOTER COMPUTED TEXT COLORS ---');
  let nonWhite = 0;
  footerElements.forEach(item => {
    console.log(`[${item.isWhite ? 'WHITE' : 'NON-WHITE'}] <${item.tag}> "${item.text}" => ${item.color}`);
    if (!item.isWhite) nonWhite++;
  });

  console.log(`\nTotal text elements evaluated: ${footerElements.length}`);
  console.log(`Non-white text elements: ${nonWhite}`);

  // Take screenshot of the footer area
  const footerEl = await page.$('.tp-footer-area');
  if (footerEl) {
    await footerEl.screenshot({ path: 'tools/footer_full_white_test.png' });
    console.log('\nSaved footer screenshot to tools/footer_full_white_test.png');
  }

  await browser.close();
})();
