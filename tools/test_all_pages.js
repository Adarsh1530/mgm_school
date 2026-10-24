const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const LOCAL_BASE = 'http://localhost/MGM%20SCHOOL';

const PAGES = [
  'mandatory-disclosure',
  'yoga',
  'voice-of-mgm',
  'hindustan-scouts-guides',
  'swimming-pool',
  'ncc',
  'attendance',
  'admission-procedure',
  'alumni',
  'merit-day',
  'pta',
  'courses-offered',
  'our-founder',
  'gallery',
  'our-mission',
  'about-us'
];

async function run() {
  const outDir = path.join(__dirname, '..', 'test_results');
  if (!fs.existsSync(outDir)) fs.mkdirSync(outDir, { recursive: true });

  console.log('Testing all 16 pages and admin portal on local XAMPP Apache...');

  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 800 });

  const report = [];

  // Test Homepage
  console.log(`\nTesting: Homepage (${LOCAL_BASE}/)`);
  const homeRes = await page.goto(`${LOCAL_BASE}/`, { waitUntil: 'networkidle0' });
  const homeTitle = await page.title();
  await page.screenshot({ path: path.join(outDir, 'local_home.png'), fullPage: true });
  report.push({ page: 'Home', status: homeRes.status(), title: homeTitle });
  console.log(`  -> Status: ${homeRes.status()}, Title: "${homeTitle}"`);

  // Test 16 Pages
  for (const slug of PAGES) {
    const url = `${LOCAL_BASE}/${slug}/`;
    console.log(`\nTesting: /${slug}/`);
    try {
      const res = await page.goto(url, { waitUntil: 'networkidle0', timeout: 15000 });
      const status = res.status();
      const title = await page.title();
      
      // Check images
      const imagesCount = await page.evaluate(() => document.querySelectorAll('img').length);
      // Check links
      const linksCount = await page.evaluate(() => document.querySelectorAll('a').length);

      await page.screenshot({ path: path.join(outDir, `local_${slug}.png`), fullPage: true });

      report.push({
        slug,
        status,
        title,
        imagesCount,
        linksCount
      });

      console.log(`  -> Status: ${status}, Title: "${title}", Images: ${imagesCount}, Links: ${linksCount}`);
    } catch (e) {
      console.error(`  -> Failed: ${e.message}`);
      report.push({ slug, status: 'Error', error: e.message });
    }
  }

  // Test Admin Login
  console.log(`\nTesting Admin Portal Authentication...`);
  const loginUrl = `${LOCAL_BASE}/admin/login.php`;
  await page.goto(loginUrl, { waitUntil: 'networkidle0' });
  console.log('  -> Navigated to login page. Title:', await page.title());

  await page.type('input[name="username"]', 'admin');
  await page.type('input[name="password"]', 'Admin@MGM2026');
  await Promise.all([
    page.click('button[type="submit"]'),
    page.waitForNavigation({ waitUntil: 'networkidle0' })
  ]);

  const dashTitle = await page.title();
  const dashUrl = page.url();
  console.log(`  -> Logged in! Current URL: ${dashUrl}, Title: "${dashTitle}"`);
  await page.screenshot({ path: path.join(outDir, 'local_admin_dashboard.png') });

  // Test Admin Pages Management
  await page.goto(`${LOCAL_BASE}/admin/pages.php`, { waitUntil: 'networkidle0' });
  const pagesListCount = await page.evaluate(() => document.querySelectorAll('tbody tr').length);
  console.log(`  -> Admin Pages Manager loaded. Page rows listed: ${pagesListCount}`);
  await page.screenshot({ path: path.join(outDir, 'local_admin_pages.png') });

  // Test Admin Disclosures Management
  await page.goto(`${LOCAL_BASE}/admin/disclosures.php`, { waitUntil: 'networkidle0' });
  const discRowsCount = await page.evaluate(() => document.querySelectorAll('tbody tr').length);
  console.log(`  -> Admin Disclosures loaded. Document rows listed: ${discRowsCount}`);
  await page.screenshot({ path: path.join(outDir, 'local_admin_disclosures.png') });

  // Test Admin Gallery Management
  await page.goto(`${LOCAL_BASE}/admin/gallery.php`, { waitUntil: 'networkidle0' });
  const galleryRowsCount = await page.evaluate(() => document.querySelectorAll('tbody tr').length);
  console.log(`  -> Admin Gallery loaded. Photo rows listed: ${galleryRowsCount}`);
  await page.screenshot({ path: path.join(outDir, 'local_admin_gallery.png') });

  fs.writeFileSync('test_results/test_report.json', JSON.stringify(report, null, 2));
  console.log('\nAll tests completed! Report written to test_results/test_report.json');

  await browser.close();
}

run().catch(console.error);
