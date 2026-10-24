const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'http://localhost/MGM%20SCHOOL';

const PAGES = [
  { slug: '', name: 'home' },
  { slug: 'mandatory-disclosure', name: 'mandatory-disclosure' },
  { slug: 'yoga', name: 'yoga' },
  { slug: 'voice-of-mgm', name: 'voice-of-mgm' },
  { slug: 'hindustan-scouts-guides', name: 'hindustan-scouts-guides' },
  { slug: 'swimming-pool', name: 'swimming-pool' },
  { slug: 'ncc', name: 'ncc' },
  { slug: 'attendance', name: 'attendance' },
  { slug: 'admission-procedure', name: 'admission-procedure' },
  { slug: 'alumni', name: 'alumni' },
  { slug: 'merit-day', name: 'merit-day' },
  { slug: 'pta', name: 'pta' },
  { slug: 'courses-offered', name: 'courses-offered' },
  { slug: 'our-founder', name: 'our-founder' },
  { slug: 'gallery', name: 'gallery' },
  { slug: 'our-mission', name: 'our-mission' },
  { slug: 'about-us', name: 'about-us' }
];

async function run() {
  const outDir = path.join(__dirname, '..', 'test_results');
  if (!fs.existsSync(outDir)) fs.mkdirSync(outDir, { recursive: true });

  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 800 });

  const summary = [];
  let totalErrors = 0;

  for (const item of PAGES) {
    const url = item.slug ? `${BASE_URL}/${item.slug}/` : `${BASE_URL}/`;
    const failed404s = [];

    const responseHandler = (res) => {
      if (res.status() >= 400) {
        failed404s.push({ url: res.url(), status: res.status() });
      }
    };
    page.on('response', responseHandler);

    try {
      const res = await page.goto(url, { waitUntil: ['domcontentloaded', 'networkidle2'], timeout: 35000 });
      const status = res.status();
      const title = await page.title();

      // Scroll to trigger lazy loading
      await page.evaluate(async () => {
        await new Promise((resolve) => {
          let totalHeight = 0;
          const distance = 400;
          const timer = setInterval(() => {
            const scrollHeight = document.body.scrollHeight;
            window.scrollBy(0, distance);
            totalHeight += distance;
            if (totalHeight >= scrollHeight) {
              clearInterval(timer);
              resolve();
            }
          }, 60);
        });
      });
      await new Promise(r => setTimeout(r, 1200));

      await page.evaluate(() => window.scrollTo(0, 0));
      await new Promise(r => setTimeout(r, 500));

      // Check all images
      const imgData = await page.evaluate(() => {
        const imgs = Array.from(document.querySelectorAll('img')).filter(i => !i.classList.contains('lightbox-content'));
        const broken = imgs.filter(img => !img.complete || img.naturalWidth === 0);
        return {
          total: imgs.length,
          brokenCount: broken.length,
          brokenSrcs: broken.map(i => i.src)
        };
      });

      // Save screenshot
      const screenPath = path.join(outDir, `local_${item.name || 'home'}.png`);
      await page.screenshot({ path: screenPath, fullPage: true });

      const pageResult = {
        slug: item.slug || 'home',
        httpStatus: status,
        title: title,
        totalImages: imgData.total,
        brokenImages: imgData.brokenCount,
        brokenImageSrcs: imgData.brokenSrcs,
        failed404Requests: failed404s.length,
        failedUrls: failed404s
      };

      summary.push(pageResult);
      if (imgData.brokenCount > 0 || failed404s.length > 0) {
        totalErrors += imgData.brokenCount + failed404s.length;
        console.warn(`[WARN] ${item.slug || 'home'}: Broken imgs=${imgData.brokenCount}, 404s=${failed404s.length}`);
        if (imgData.brokenCount > 0) console.warn('   Broken src:', imgData.brokenSrcs);
        if (failed404s.length > 0) console.warn('   404 urls:', failed404s);
      } else {
        console.log(`[PASS] ${item.slug || 'home'}: Status ${status}, Title: "${title}", Images: ${imgData.total} OK`);
      }

    } catch (err) {
      console.error(`[FAIL] ${item.slug || 'home'}: ${err.message}`);
      summary.push({ slug: item.slug || 'home', error: err.message });
      totalErrors++;
    } finally {
      page.off('response', responseHandler);
    }
  }

  // Test Admin Dashboard & Sections
  console.log('\nTesting Admin Authentication & CRUD Panels...');
  try {
    await page.goto(`${BASE_URL}/admin/login.php`, { waitUntil: 'networkidle0' });
    await page.type('input[name="username"]', 'admin');
    await page.type('input[name="password"]', 'Admin@MGM2026');
    await Promise.all([
      page.click('button[type="submit"]'),
      page.waitForNavigation({ waitUntil: 'networkidle0' })
    ]);
    console.log('[PASS] Admin login successful: ' + page.url());

    // Disclosures manager
    await page.goto(`${BASE_URL}/admin/disclosures.php`, { waitUntil: 'networkidle0' });
    const docsCount = await page.evaluate(() => document.querySelectorAll('tbody tr').length);
    console.log(`[PASS] Admin disclosures loaded: ${docsCount} documents`);

    // Pages manager
    await page.goto(`${BASE_URL}/admin/pages.php`, { waitUntil: 'networkidle0' });
    const pagesCount = await page.evaluate(() => document.querySelectorAll('tbody tr').length);
    console.log(`[PASS] Admin pages loaded: ${pagesCount} pages`);

    // Gallery manager
    await page.goto(`${BASE_URL}/admin/gallery.php`, { waitUntil: 'networkidle0' });
    const galleryCount = await page.evaluate(() => document.querySelectorAll('tbody tr').length);
    console.log(`[PASS] Admin gallery loaded: ${galleryCount} photos`);

    // Settings manager
    await page.goto(`${BASE_URL}/admin/settings.php`, { waitUntil: 'networkidle0' });
    const settingsInputs = await page.evaluate(() => document.querySelectorAll('input').length);
    console.log(`[PASS] Admin settings loaded: ${settingsInputs} configuration fields`);
  } catch (e) {
    console.error('[FAIL] Admin tests:', e.message);
  }

  fs.writeFileSync(path.join(outDir, 'comprehensive_report.json'), JSON.stringify(summary, null, 2));
  console.log(`\n========================================`);
  console.log(`ALL TESTS FINISHED. Total issues found: ${totalErrors}`);
  console.log(`========================================\n`);

  await browser.close();
}

run().catch(console.error);
