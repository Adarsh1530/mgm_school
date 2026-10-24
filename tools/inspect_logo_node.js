const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.jpeg');
  const details = await page.evaluate(() => {
    const img = document.querySelector('img');
    const canvas = document.createElement('canvas');
    canvas.width = img.naturalWidth;
    canvas.height = img.naturalHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);
    const p1 = ctx.getImageData(0, 0, 1, 1).data;
    const p2 = ctx.getImageData(img.naturalWidth - 1, 0, 1, 1).data;
    const p3 = ctx.getImageData(0, img.naturalHeight - 1, 1, 1).data;
    const p4 = ctx.getImageData(img.naturalWidth - 1, img.naturalHeight - 1, 1, 1).data;
    const center = ctx.getImageData(Math.floor(img.naturalWidth / 2), Math.floor(img.naturalHeight / 2), 1, 1).data;
    return {
      w: img.naturalWidth,
      h: img.naturalHeight,
      tl: Array.from(p1),
      tr: Array.from(p2),
      bl: Array.from(p3),
      br: Array.from(p4),
      center: Array.from(center)
    };
  });
  console.log('Logo details:', JSON.stringify(details));
  await browser.close();
})();
