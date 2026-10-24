const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

async function test() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  console.log('Navigating to https://mgm-school.nbtksa.in/...');
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 45000 });

  // Wait for Cloudflare navigation redirect
  for (let i = 0; i < 25; i++) {
    await new Promise(r => setTimeout(r, 1000));
    try {
      const title = await page.title();
      console.log(`[${i+1}s] Title: "${title}"`);
      if (title && !title.includes('Checking your browser') && title.length > 0) {
        console.log('Landed on real site! Title:', title);
        break;
      }
    } catch (e) {
      console.log(`[${i+1}s] Navigation in progress...`);
    }
  }

  console.log('Final URL:', page.url());
  console.log('Final Title:', await page.title());
  await browser.close();
}

test().catch(console.error);
