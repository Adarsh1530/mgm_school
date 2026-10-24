const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/voice-of-mgm/', { waitUntil: 'networkidle2' });
  
  const content = await page.evaluate(() => {
    return {
      title: document.title,
      text: document.querySelector('.elementor-16036')?.innerText,
      images: Array.from(document.querySelectorAll('.elementor-16036 img')).map(i => ({ src: i.src, w: i.offsetWidth, h: i.offsetHeight })),
      carousels: Array.from(document.querySelectorAll('.swiper')).map(s => ({ classes: s.className, slides: s.querySelectorAll('.swiper-slide').length }))
    };
  });
  
  console.log('Voice of MGM page content:', JSON.stringify(content, null, 2));
  await page.screenshot({ path: 'tools/voice_of_mgm_rendered.jpg', fullPage: true, quality: 60 });
  console.log('Saved tools/voice_of_mgm_rendered.jpg');
  await browser.close();
})();
