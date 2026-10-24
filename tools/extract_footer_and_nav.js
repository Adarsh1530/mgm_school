const puppeteer = require('puppeteer-core');
const fs = require('fs');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });
  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { waitUntil: 'networkidle2', timeout: 35000 });
  
  // Initial wait for challenge to kick off and reload
  await new Promise(r => setTimeout(r, 6000));
  
  // Wait for challenge to pass
  let title = '';
  for (let i = 0; i < 20; i++) {
    try {
      title = await page.title();
      if (title && !title.includes('Checking your browser')) break;
    } catch (e) {}
    await new Promise(r => setTimeout(r, 1000));
  }
  await new Promise(r => setTimeout(r, 3000));

  const homeHtml = await page.content();
  fs.writeFileSync('audit/homepage_full.html', homeHtml);
  console.log('Saved audit/homepage_full.html (bytes: ' + homeHtml.length + ')');

  const data = await page.evaluate(() => {
    // Find all links on homepage
    const links = Array.from(document.querySelectorAll('a')).map(a => ({
      text: a.innerText.trim(),
      href: a.href,
      classes: a.className,
      parentTag: a.parentElement ? a.parentElement.tagName : null,
      parentClass: a.parentElement ? a.parentElement.className : null
    })).filter(l => l.text.length > 0 || l.href.includes('mgm'));

    // Find footer element
    let footerEl = document.querySelector('footer');
    if (!footerEl) {
      // Find element with footer in class
      const candidates = document.querySelectorAll('[class*="footer"], [id*="footer"]');
      for (const c of candidates) {
        if (c.innerText.length > 100) {
          footerEl = c;
          break;
        }
      }
    }
    const footerHtml = footerEl ? footerEl.outerHTML : '';
    const footerText = footerEl ? footerEl.innerText : '';

    return {
      linksCount: links.length,
      links,
      footerHtmlSnippet: footerHtml.substring(0, 1000),
      footerText
    };
  });

  fs.writeFileSync('audit/homepage_links.json', JSON.stringify(data.links, null, 2));
  fs.writeFileSync('audit/footer_extracted.txt', data.footerText);
  console.log('Homepage links count:', data.linksCount);
  console.log('Footer text:\n', data.footerText);

  await browser.close();
})();
