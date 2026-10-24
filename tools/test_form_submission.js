const puppeteer = require('puppeteer-core');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const LOCAL_BASE = 'http://localhost/MGM%20SCHOOL';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--no-sandbox']
  });

  const page = await browser.newPage();
  console.log('Testing Admission Form submission on localhost...');
  await page.goto(`${LOCAL_BASE}/admission-procedure/`, { waitUntil: 'networkidle0' });

  await page.type('input[name="name"]', 'Automated Test Student');
  await page.type('input[name="phone"]', '9876543210');
  await page.type('input[name="email"]', 'test.student@example.com');
  await page.select('select[name="grade_applied"]', 'Class I - V');
  await page.type('textarea[name="message"]', 'Inquiring about syllabus and fee details for automated testing.');

  await Promise.all([
    page.click('.mgm-form-card button[type="submit"]'),
    page.waitForNavigation({ waitUntil: 'networkidle0' })
  ]);

  const bodyText = await page.evaluate(() => document.body.innerText);
  const success = bodyText.includes('Thank you! Your admission enquiry has been submitted');
  console.log('Submission Success Message Displayed:', success);

  await browser.close();
})();
