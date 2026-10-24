const puppeteer = require('puppeteer-core');
const path = require('path');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

async function testAdmin() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 800 });

  console.log('Logging into Admin portal...');
  await page.goto(`${BASE_URL}/admin/login.php`, { waitUntil: 'networkidle0' });
  await page.type('input[name="username"]', 'admin');
  await page.type('input[name="password"]', 'Admin@MGM2026');
  await Promise.all([
    page.click('button[type="submit"]'),
    page.waitForNavigation({ waitUntil: 'networkidle0' })
  ]);
  console.log('Logged in. Current URL:', page.url());

  const adminTabs = [
    { url: `${BASE_URL}/admin/index.php`, name: 'dashboard' },
    { url: `${BASE_URL}/admin/pages.php`, name: 'pages' },
    { url: `${BASE_URL}/admin/disclosures.php`, name: 'disclosures' },
    { url: `${BASE_URL}/admin/gallery.php`, name: 'gallery' },
    { url: `${BASE_URL}/admin/courses.php`, name: 'courses' },
    { url: `${BASE_URL}/admin/admissions.php`, name: 'admissions' },
    { url: `${BASE_URL}/admin/settings.php`, name: 'settings' },
    { url: `${BASE_URL}/admin/audit_logs.php`, name: 'audit_logs' }
  ];

  for (const tab of adminTabs) {
    await page.goto(tab.url, { waitUntil: 'networkidle0' });
    const title = await page.title();
    console.log(`[PASS] Admin ${tab.name}: Status 200, Title: "${title}"`);
    await page.screenshot({ path: path.join('test_results', `admin_${tab.name}.png`) });
  }

  await browser.close();
}

testAdmin().catch(console.error);
