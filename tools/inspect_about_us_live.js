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
  await page.goto('http://localhost/MGM%20SCHOOL/about-us/', { waitUntil: 'networkidle2' });
  
  const info = await page.evaluate(() => {
    return {
      title: document.title,
      images: Array.from(document.querySelectorAll('img')).map(img => ({
        src: img.src,
        naturalWidth: img.naturalWidth,
        naturalHeight: img.naturalHeight,
        complete: img.complete
      })),
      videos: Array.from(document.querySelectorAll('video')).map(v => ({
        src: v.querySelector('source')?.src,
        paused: v.paused,
        muted: v.muted
      }))
    };
  });
  
  console.log('About Us Info:', JSON.stringify(info, null, 2));
  await browser.close();
})();
