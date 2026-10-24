const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 900 });
  
  const response = await page.goto('http://localhost/MGM%20SCHOOL/hindustan-scouts-guides/', { waitUntil: 'networkidle2' });
  console.log('Page response status:', response.status());

  const imgs = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('img')).map(img => ({
      src: img.src,
      alt: img.alt,
      naturalWidth: img.naturalWidth,
      naturalHeight: img.naturalHeight,
      complete: img.complete
    }));
  });
  
  console.log('Total images found on page:', imgs.length);
  const broken = imgs.filter(i => i.naturalWidth === 0);
  console.log('Broken images count:', broken.length);
  if (broken.length > 0) {
    console.log('Broken images:', broken);
  }
  
  const rajyaImgs = imgs.filter(i => i.src.includes('rajyapuraskar'));
  console.log('Rajyapuraskar images found:');
  rajyaImgs.forEach(img => {
    console.log(' -', img.src, 'Dimensions:', img.naturalWidth, 'x', img.naturalHeight);
  });
  
  const galleryEl = await page.$('.card.border-0.shadow-sm.p-4.mb-4');
  if (galleryEl) {
    await galleryEl.screenshot({ path: 'tools/rajyapuraskar_gallery_screenshot.png' });
    console.log('Saved screenshot of Rajyapuraskar section to tools/rajyapuraskar_gallery_screenshot.png');
  }

  await browser.close();
})();
