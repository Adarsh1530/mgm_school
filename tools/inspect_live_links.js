const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('http://localhost/MGM%20SCHOOL/', { waitUntil: 'networkidle2' });

  const links = await page.evaluate(() => {
    return Array.from(document.querySelectorAll('a')).map(a => ({
      text: a.innerText.trim().replace(/\s+/g, ' '),
      href: a.getAttribute('href'),
      resolvedHref: a.href
    })).filter(l => l.text.length > 0 || l.href.length > 0);
  });

  console.log('Total links on live homepage:', links.length);
  links.forEach((l, i) => {
    if (!l.href) return;
    if (l.href === '#' || l.href.includes('<?=') || (l.href.startsWith('/') && !l.href.startsWith('/MGM')) || l.href.includes('etn')) {
      console.log(`[${i}] text: "${l.text.substring(0, 40)}" | attr href: "${l.href}" | resolved: "${l.resolvedHref}"`);
    }
  });

  await browser.close();
})();
