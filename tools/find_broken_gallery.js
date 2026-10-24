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
  await page.goto('http://localhost/MGM%20SCHOOL/gallery/', { waitUntil: 'networkidle2' });
  
  // Wait a bit or scroll down to check lazy loading!
  const broken = await page.evaluate(async () => {
    // Scroll down to load all images (if loading="lazy")
    window.scrollTo(0, document.body.scrollHeight);
    await new Promise(r => setTimeout(r, 1000));
    const imgs = Array.from(document.querySelectorAll('img'));
    return imgs.map(i => ({
      src: i.src,
      complete: i.complete,
      naturalWidth: i.naturalWidth,
      loading: i.loading
    })).filter(i => i.naturalWidth === 0 && !i.src.startsWith('data:'));
  });
  
  console.log('Broken images on gallery:', broken);
  await browser.close();
})();
