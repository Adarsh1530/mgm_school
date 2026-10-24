const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 375, height: 667, isMobile: true, hasTouch: true });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const btnDetails = await page.evaluate(() => {
    const btn = document.querySelector('.offcanvas-open-btn');
    const cs = getComputedStyle(btn);
    const rect = btn.getBoundingClientRect();
    const parent = btn.parentElement;
    const parentCs = getComputedStyle(parent);
    const icon = btn.querySelector('i');
    const iconCs = icon ? getComputedStyle(icon) : null;

    return {
      rect: {
        top: rect.top,
        left: rect.left,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height
      },
      btnStyles: {
        background: cs.background,
        color: cs.color,
        border: cs.border,
        borderColor: cs.borderColor,
        outline: cs.outline,
        padding: cs.padding,
        margin: cs.margin,
        borderRadius: cs.borderRadius
      },
      iconStyles: iconCs ? {
        color: iconCs.color,
        fontSize: iconCs.fontSize
      } : null,
      parentClasses: parent.className,
      parentStyles: {
        margin: parentCs.margin,
        padding: parentCs.padding
      }
    };
  });

  console.log(JSON.stringify(btnDetails, null, 2));
  await browser.close();
})();
