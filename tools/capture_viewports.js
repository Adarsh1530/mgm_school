const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 850 });
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle0' });

  // 1. Hero area
  await page.screenshot({ path: 'test_results/viewport_home_hero.png' });
  console.log('Saved test_results/viewport_home_hero.png');

  // 2. Scroll to services
  await page.evaluate(() => window.scrollTo(0, 900));
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: 'test_results/viewport_home_services.png' });
  console.log('Saved test_results/viewport_home_services.png');

  // 3. Scroll to programs / statistics
  await page.evaluate(() => window.scrollTo(0, 2000));
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: 'test_results/viewport_home_programs.png' });
  console.log('Saved test_results/viewport_home_programs.png');

  // 4. Scroll to footer
  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: 'test_results/viewport_home_footer.png' });
  console.log('Saved test_results/viewport_home_footer.png');

  await browser.close();
}

run().catch(console.error);
