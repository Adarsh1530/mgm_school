const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const path = require('path');

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const ctaLogoInfo = await page.evaluate(() => {
    const ctaSection = document.querySelector('.elementor-element-4932b88');
    const ctaImg = document.querySelector('.elementor-element-ec9a550 img');
    return {
      hasCtaSection: !!ctaSection,
      imgSrc: ctaImg ? ctaImg.src : null,
      complete: ctaImg ? ctaImg.complete : false,
      naturalWidth: ctaImg ? ctaImg.naturalWidth : 0,
      naturalHeight: ctaImg ? ctaImg.naturalHeight : 0,
      renderedWidth: ctaImg ? ctaImg.offsetWidth : 0,
      renderedHeight: ctaImg ? ctaImg.offsetHeight : 0,
      ctaRect: ctaSection ? {
        top: ctaSection.getBoundingClientRect().top + window.scrollY,
        height: ctaSection.offsetHeight
      } : null
    };
  });

  console.log('CTA Logo Info:', JSON.stringify(ctaLogoInfo, null, 2));

  if (ctaLogoInfo.hasCtaSection && ctaLogoInfo.ctaRect) {
    const shotPath = path.resolve(__dirname, 'screenshots_audit/cta_new_logo.png');
    await page.screenshot({
      path: shotPath,
      clip: {
        x: 0,
        y: ctaLogoInfo.ctaRect.top - 20,
        width: 1440,
        height: ctaLogoInfo.ctaRect.height + 40
      }
    });
    console.log(`Saved screenshot to: ${shotPath}`);
  }

  await browser.close();

  if (ctaLogoInfo.imgSrc && ctaLogoInfo.imgSrc.includes('new-mgm-logo.png') && ctaLogoInfo.naturalWidth > 0) {
    console.log('SUCCESS: CTA banner logo updated to new logo!');
  } else {
    console.error('FAILURE: CTA banner logo not updated properly.');
  }
})();
