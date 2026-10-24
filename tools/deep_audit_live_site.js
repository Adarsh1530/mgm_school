const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const LIVE_BASE = 'https://mgm-school.nbtksa.in';

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
  const outDir = path.join(__dirname, '..', 'audit', 'live_deep_audit');
  if (!fs.existsSync(outDir)) fs.mkdirSync(outDir, { recursive: true });

  console.log('Starting Deep Audit of live site https://mgm-school.nbtksa.in/ ...');

  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,900', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 900 });

  // 1. Initial connection & Cloudflare pass
  console.log('Connecting to root to establish session...');
  await page.goto(`${LIVE_BASE}/`, { timeout: 45000 });
  for (let i = 0; i < 25; i++) {
    await new Promise(r => setTimeout(r, 1000));
    try {
      const title = await page.title();
      if (title && !title.includes('Checking your browser')) {
        console.log(`Cloudflare passed in ${i+1}s! Title: "${title}"`);
        break;
      }
    } catch (e) {}
  }

  const liveData = {};

  // 2. Audit Homepage
  console.log('\n--- Auditing Homepage ---');
  await page.goto(`${LIVE_BASE}/`, { waitUntil: 'networkidle0', timeout: 35000 });
  const homeData = await extractPageData(page);
  liveData['home'] = homeData;
  console.log(`  Home: Title="${homeData.title}", Text Length=${(homeData.fullText || '').length}, Imgs=${(homeData.images || []).length}, Links=${(homeData.links || []).length}`);

  // 3. Audit All 16 Pages
  for (const slug of PAGES) {
    const url = `${LIVE_BASE}/${slug}/`;
    console.log(`\n--- Auditing: /${slug}/ ---`);
    try {
      await page.goto(url, { waitUntil: 'networkidle0', timeout: 35000 });
      const pData = await extractPageData(page);
      liveData[slug] = pData;
      console.log(`  /${slug}/: Title="${pData.title}", Text Length=${(pData.fullText || '').length}, Imgs=${(pData.images || []).length}, Docs=${(pData.docLinks || []).length}, Tables=${(pData.tables || []).length}`);
    } catch (err) {
      console.error(`  Error on /${slug}/:`, err.message);
      liveData[slug] = { error: err.message };
    }
  }

  fs.writeFileSync(path.join(outDir, 'live_site_scraped_data.json'), JSON.stringify(liveData, null, 2));
  console.log('\nSaved all live site data to audit/live_deep_audit/live_site_scraped_data.json');

  await browser.close();
}

async function extractPageData(page) {
  return await page.evaluate(() => {
    const title = document.title;
    const metaDesc = document.querySelector('meta[name="description"]')?.content || '';
    
    // Find Elementor post id
    const elementorEl = document.querySelector('[data-elementor-type="wp-page"]');
    const wpId = elementorEl ? elementorEl.getAttribute('data-elementor-id') : null;

    // Headings
    const headings = Array.from(document.querySelectorAll('h1, h2, h3, h4, h5, h6')).map(h => ({
      tag: h.tagName,
      text: h.innerText.trim()
    })).filter(h => h.text.length > 0);

    // Images
    const images = Array.from(document.querySelectorAll('img')).map(img => ({
      src: img.src,
      alt: img.alt || '',
      width: img.naturalWidth || img.width,
      height: img.naturalHeight || img.height,
      classes: img.className
    })).filter(img => !img.src.includes('profile-photo') && !img.src.includes('cropped-1733381285'));

    // Links & Docs
    const links = Array.from(document.querySelectorAll('a')).map(a => ({
      text: a.innerText.trim(),
      href: a.href
    })).filter(l => l.href && !l.href.startsWith('javascript:'));

    const docLinks = links.filter(l => l.href.includes('.pdf') || l.href.includes('.doc') || l.href.includes('assets/docs/'));

    // Tables
    const tables = Array.from(document.querySelectorAll('table')).map(table => {
      const rows = Array.from(table.querySelectorAll('tr')).map(tr => {
        return Array.from(tr.querySelectorAll('th, td')).map(td => td.innerText.trim());
      });
      return rows;
    });

    // Content Text & HTML
    const contentEl = document.querySelector('[data-elementor-type="wp-page"]') || document.body;
    const fullText = contentEl.innerText.trim();
    const mainHtml = contentEl.innerHTML;

    return {
      title,
      metaDesc,
      wpId,
      headings,
      images,
      links,
      docLinks,
      tables,
      fullText,
      mainHtml
    };
  });
}

run().catch(console.error);
