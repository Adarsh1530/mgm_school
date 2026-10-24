const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/mandatory-disclosure/', { waitUntil: 'networkidle2' });
  
  const links = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('a[href$=".pdf"]')).map(a => ({
      text: a.innerText.trim(),
      href: a.href,
      target: a.target
    }));
  });
  
  console.log(`Found ${links.length} PDF links on /mandatory-disclosure/:`);
  for (const l of links) {
    const testPage = await browser.newPage();
    const res = await testPage.goto(l.href);
    console.log(`  ${l.text || 'DOC'}: ${l.href} => Status: ${res.status()}`);
    await testPage.close();
  }

  await browser.close();
})();
