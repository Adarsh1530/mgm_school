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
  
  const breadcrumbInfo = await page.evaluate(() => {
    const bc = document.querySelector('.tp-breadcrumb__area');
    if (!bc) return null;
    const style = window.getComputedStyle(bc);
    const content = bc.querySelector('.tp-breadcrumb__content');
    const title = bc.querySelector('.tp-breadcrumb__title');
    return {
      totalHeight: bc.offsetHeight,
      paddingTop: style.paddingTop,
      paddingBottom: style.paddingBottom,
      marginTop: style.marginTop,
      marginBottom: style.marginBottom,
      contentHeight: content ? content.offsetHeight : null,
      titleSize: title ? window.getComputedStyle(title).fontSize : null
    };
  });
  
  console.log('Breadcrumb on /about-us/:', JSON.stringify(breadcrumbInfo, null, 2));
  
  // Inspect the next section after breadcrumb
  const contentSection = await page.evaluate(() => {
    const sec = document.querySelector('.tp-breadcrumb__area + *');
    if (!sec) return null;
    const style = window.getComputedStyle(sec);
    return {
      tagName: sec.tagName,
      className: sec.className,
      paddingTop: style.paddingTop,
      paddingBottom: style.paddingBottom,
      marginTop: style.marginTop,
      marginBottom: style.marginBottom
    };
  });
  console.log('Section after breadcrumb:', JSON.stringify(contentSection, null, 2));

  await browser.close();
})();
