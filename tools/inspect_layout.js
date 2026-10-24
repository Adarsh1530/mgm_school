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
  await page.goto('https://mgm-school.nbtksa.in/mandatory-disclosure/', { waitUntil: 'networkidle2', timeout: 35000 });
  await new Promise(r => setTimeout(r, 4000));

  const html = await page.content();
  fs.writeFileSync('audit/raw_pages/mandatory-disclosure_full.html', html);
  console.log('Saved mandatory-disclosure_full.html, bytes: ' + html.length);

  const info = await page.evaluate(() => {
    // Header HTML
    const headerEl = document.querySelector('header') || document.querySelector('.site-header') || document.querySelector('.tp-header-area');
    const headerHtml = headerEl ? headerEl.outerHTML : '';

    // Footer HTML
    const footerEl = document.querySelector('footer') || document.querySelector('.site-footer') || document.querySelector('.tp-footer-area') || document.querySelector('.footer-area');
    const footerHtml = footerEl ? footerEl.outerHTML : '';

    // Navigation menus
    const navItems = [];
    // Looking for menu structure: ul > li > a
    document.querySelectorAll('.main-menu > nav > ul > li, nav > ul > li, header ul.menu > li').forEach(li => {
      const topLink = li.querySelector('a');
      const subItems = [];
      li.querySelectorAll('ul.sub-menu > li > a, ul.dropdown-menu > li > a, .submenu > li > a').forEach(subA => {
        subItems.push({
          title: subA.innerText.trim(),
          url: subA.href
        });
      });
      if (topLink) {
        navItems.push({
          title: topLink.innerText.trim(),
          url: topLink.href,
          children: subItems
        });
      }
    });

    return {
      headerSnippet: headerHtml.substring(0, 500),
      footerSnippet: footerHtml.substring(0, 500),
      navItems,
      allLinks: Array.from(document.querySelectorAll('a')).map(a => ({ text: a.innerText.trim(), href: a.href })).filter(a => a.text)
    };
  });

  fs.writeFileSync('audit/nav_and_layout.json', JSON.stringify(info, null, 2));
  console.log('Saved audit/nav_and_layout.json. Found top menu items:', info.navItems.length);
  await browser.close();
})();
