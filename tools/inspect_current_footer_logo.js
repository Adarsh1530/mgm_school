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
  
  // Inspect the actual footer logo in localhost
  const footerLogo = await page.evaluate(() => {
    const el = document.querySelector('.tp-footer-logo');
    if (!el) return null;
    const rect = el.getBoundingClientRect();
    const img = el.querySelector('img');
    const badge = el.querySelector('div');
    const text = el.querySelector('.text-start');
    return {
      rect: { top: rect.top, left: rect.left, width: rect.width, height: rect.height },
      img: img ? {
        src: img.src,
        w: img.offsetWidth,
        h: img.offsetHeight,
        naturalWidth: img.naturalWidth,
        naturalHeight: img.naturalHeight
      } : null,
      badge: badge ? {
        w: badge.offsetWidth,
        h: badge.offsetHeight,
        borderRadius: window.getComputedStyle(badge).borderRadius
      } : null,
      text: text ? {
        title: text.children[0]?.innerText,
        sub: text.children[1]?.innerText
      } : null
    };
  });
  
  console.log('Current localhost footer logo:', JSON.stringify(footerLogo, null, 2));

  // Take a clean clip screenshot of the footer logo
  const logoEl = await page.$('.tp-footer-logo');
  if (logoEl) {
    await logoEl.screenshot({ path: 'tools/current_footer_logo_clip.png' });
    console.log('Saved tools/current_footer_logo_clip.png');
  }

  await browser.close();
})();
