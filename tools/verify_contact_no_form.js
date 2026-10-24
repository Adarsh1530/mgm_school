const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const path = require('path');

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });
  
  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });

  const consoleErrors = [];
  page.on('console', msg => {
    if (msg.type() === 'error') consoleErrors.push(msg.text());
  });

  const response = await page.goto('http://localhost/MGM%20SCHOOL/contact/', {
    waitUntil: 'networkidle2'
  });

  const status = response.status();
  console.log(`Page HTTP Status: ${status}`);

  const audit = await page.evaluate(() => {
    const subpage = document.querySelector('.tp-subpage-container');
    const formsInSubpage = subpage ? subpage.querySelectorAll('form').length : 0;
    const inputsInSubpage = subpage ? subpage.querySelectorAll('input:not([type="hidden"]), textarea, button[type="submit"]').length : 0;
    const enquiryHeadings = Array.from(document.querySelectorAll('h1, h2, h3, h4, h5, h6'))
      .filter(h => /enquiry|send an enquiry|send a message/i.test(h.innerText))
      .map(h => h.innerText);
    
    const contactCard = subpage ? subpage.querySelector('.card') : null;
    const iframe = subpage ? subpage.querySelector('iframe') : null;
    
    const phoneLinks = Array.from(document.querySelectorAll('.tp-subpage-container a[href^="tel:"]')).map(a => ({
      href: a.href,
      text: a.innerText.trim()
    }));

    const emailLinks = Array.from(document.querySelectorAll('.tp-subpage-container a[href^="mailto:"]')).map(a => ({
      href: a.href,
      text: a.innerText.trim()
    }));

    const images = Array.from(document.querySelectorAll('img')).map(img => ({
      src: img.src,
      complete: img.complete,
      naturalWidth: img.naturalWidth
    }));

    const brokenImages = images.filter(img => !img.complete || img.naturalWidth === 0);

    return {
      formsInSubpage,
      inputsInSubpage,
      enquiryHeadings,
      hasContactCard: !!contactCard,
      iframeSrc: iframe ? iframe.src : null,
      phoneLinks,
      emailLinks,
      brokenImages
    };
  });

  console.log('Audit Results:');
  console.log(JSON.stringify(audit, null, 2));

  if (consoleErrors.length > 0) {
    console.log('Console errors:', consoleErrors);
  }

  // Screenshot
  const screenshotPath = path.resolve(__dirname, 'screenshots_audit/contact_page_no_form.png');
  await page.screenshot({ path: screenshotPath, fullPage: true });
  console.log(`Screenshot saved to: ${screenshotPath}`);

  await browser.close();

  if (audit.formsInSubpage === 0 && audit.inputsInSubpage === 0 && audit.brokenImages.length === 0) {
    console.log('SUCCESS: Enquiry form section fully removed! Only contact details & map present.');
  } else {
    console.error('FAILURE: Unexpected elements found.');
    process.exit(1);
  }
})();
