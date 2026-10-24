const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');
const https = require('https');
const http = require('http');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const BASE_URL = 'https://mgm-school.nbtksa.in';

const PAGES = [
  { slug: 'mandatory-disclosure', url: `${BASE_URL}/mandatory-disclosure/`, id: 16051 },
  { slug: 'yoga', url: `${BASE_URL}/yoga/`, id: 16043 },
  { slug: 'voice-of-mgm', url: `${BASE_URL}/voice-of-mgm/`, id: 16036 },
  { slug: 'hindustan-scouts-guides', url: `${BASE_URL}/hindustan-scouts-guides/`, id: 16026 },
  { slug: 'swimming-pool', url: `${BASE_URL}/swimming-pool/`, id: 16019 },
  { slug: 'ncc', url: `${BASE_URL}/ncc/`, id: 16013 },
  { slug: 'attendance', url: `${BASE_URL}/attendance/`, id: 16004 },
  { slug: 'admission-procedure', url: `${BASE_URL}/admission-procedure/`, id: 15998 },
  { slug: 'alumni', url: `${BASE_URL}/alumni/`, id: 15992 },
  { slug: 'merit-day', url: `${BASE_URL}/merit-day/`, id: 15985 },
  { slug: 'pta', url: `${BASE_URL}/pta/`, id: 15979 },
  { slug: 'courses-offered', url: `${BASE_URL}/courses-offered/`, id: 15930 },
  { slug: 'our-founder', url: `${BASE_URL}/our-founder/`, id: 15913 },
  { slug: 'gallery', url: `${BASE_URL}/gallery/`, id: 15937 },
  { slug: 'our-mission', url: `${BASE_URL}/our-mission/`, id: 15908 },
  { slug: 'about-us', url: `${BASE_URL}/about-us/`, id: 10042 }
];

const VIEWPORTS = [
  { name: 'desktop', width: 1280, height: 800 },
  { name: 'tablet', width: 768, height: 1024 },
  { name: 'mobile', width: 375, height: 667 }
];

async function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

function ensureDirs() {
  const dirs = [
    'audit',
    'audit/screenshots',
    'audit/screenshots/desktop',
    'audit/screenshots/tablet',
    'audit/screenshots/mobile',
    'audit/raw_pages',
    'audit/assets',
    'audit/assets/images',
    'audit/assets/documents'
  ];
  for (const d of dirs) {
    if (!fs.existsSync(d)) {
      fs.mkdirSync(d, { recursive: true });
    }
  }
}

async function run() {
  ensureDirs();
  console.log('Starting Reference Audit for MGM School...');
  
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  
  // Set User Agent
  await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');

  // Initial navigation to solve challenge once
  console.log('Navigating to homepage to initialize session...');
  await page.goto(BASE_URL, { waitUntil: 'domcontentloaded', timeout: 30000 });
  await sleep(6000);

  // Extract common site elements from homepage or any page: header, nav, footer
  console.log('Extracting global header, navigation, and footer...');
  const globalData = await page.evaluate(() => {
    // Logo
    const logoImg = document.querySelector('header img, .logo img, .navbar-brand img, .site-header img');
    const logoSrc = logoImg ? logoImg.src : null;

    // Navigation items
    const navItems = [];
    document.querySelectorAll('.menu-item, nav li, header li').forEach(li => {
      const a = li.querySelector('a');
      if (a && a.textContent.trim()) {
        const parentLi = li.parentElement.closest('li');
        navItems.push({
          text: a.textContent.trim(),
          href: a.href,
          isSub: !!parentLi,
          parentText: parentLi ? parentLi.querySelector('a')?.textContent.trim() : null
        });
      }
    });

    // Header contact info / topbar
    const headerText = document.querySelector('header, .site-header')?.innerText || '';

    // Footer info
    const footer = document.querySelector('footer, .site-footer');
    const footerHtml = footer ? footer.innerHTML : '';
    const footerText = footer ? footer.innerText : '';

    return {
      logoSrc,
      navItems,
      headerText,
      footerText,
      footerHtml
    };
  });

  fs.writeFileSync('audit/global_structure.json', JSON.stringify(globalData, null, 2));
  console.log('Saved audit/global_structure.json');

  const pageReports = [];

  for (let i = 0; i < PAGES.length; i++) {
    const item = PAGES[i];
    console.log(`\n[${i + 1}/${PAGES.length}] Auditing: ${item.slug} (${item.url})`);

    // Fetch REST API data
    const apiData = await page.evaluate(async (id) => {
      try {
        const r = await fetch(`/wp-json/wp/v2/pages/${id}`);
        if (!r.ok) return { error: `HTTP ${r.status}` };
        return await r.json();
      } catch (e) {
        return { error: e.message };
      }
    }, item.id);

    fs.writeFileSync(`audit/raw_pages/${item.slug}_api.json`, JSON.stringify(apiData, null, 2));

    // Audit page in browser
    for (const vp of VIEWPORTS) {
      await page.setViewport({ width: vp.width, height: vp.height, deviceScaleFactor: 1 });
      await page.goto(item.url, { waitUntil: 'networkidle2', timeout: 35000 }).catch(async () => {
        // Fallback retry
        await sleep(3000);
      });
      await sleep(1500);

      const shotPath = `audit/screenshots/${vp.name}/${item.slug}.png`;
      await page.screenshot({ path: shotPath, fullPage: true });
      console.log(`  -> Saved ${vp.name} screenshot (${vp.width}x${vp.height})`);
    }

    // Inspect page specifics at desktop
    await page.setViewport({ width: 1280, height: 800 });
    const pageDetails = await page.evaluate(() => {
      const getStyles = (el) => {
        if (!el) return null;
        const cs = window.getComputedStyle(el);
        return {
          fontFamily: cs.fontFamily,
          fontSize: cs.fontSize,
          fontWeight: cs.fontWeight,
          lineHeight: cs.lineHeight,
          color: cs.color,
          backgroundColor: cs.backgroundColor,
          margin: cs.margin,
          padding: cs.padding
        };
      };

      const title = document.title;
      const h1 = document.querySelector('h1')?.innerText || '';
      const breadcrumb = document.querySelector('.breadcrumb, .breadcrumbs, .woocommerce-breadcrumb, .tp-breadcrumb')?.innerText || '';

      // Breadcrumb background image or banner background
      const bannerEl = document.querySelector('.breadcrumb-area, .page-title-area, .breadcrumb-bg, .breadcrumb, [class*="breadcrumb"]');
      const bannerBg = bannerEl ? window.getComputedStyle(bannerEl).backgroundImage : null;

      // Extract all tables
      const tables = [];
      document.querySelectorAll('table').forEach((tbl, idx) => {
        const headers = Array.from(tbl.querySelectorAll('th')).map(th => th.innerText.trim());
        const rows = [];
        tbl.querySelectorAll('tr').forEach(tr => {
          const cells = Array.from(tr.querySelectorAll('td, th')).map(td => ({
            text: td.innerText.trim(),
            html: td.innerHTML.trim(),
            link: td.querySelector('a')?.href || null
          }));
          if (cells.length > 0) rows.push(cells);
        });
        tables.push({ index: idx, headers, rows });
      });

      // Extract all images in main content
      const contentImages = [];
      document.querySelectorAll('main img, article img, .entry-content img, .page-content img, .elementor img').forEach(img => {
        if (!img.closest('header') && !img.closest('footer')) {
          contentImages.push({
            src: img.src,
            alt: img.alt || '',
            width: img.naturalWidth || img.width,
            height: img.naturalHeight || img.height,
            class: img.className
          });
        }
      });

      // Extract all document links (.pdf, .doc, etc.)
      const docLinks = [];
      document.querySelectorAll('a[href]').forEach(a => {
        const href = a.href;
        if (href.match(/\.(pdf|docx?|xlsx?|pptx?)$/i) || href.includes('/wp-content/uploads/')) {
          docLinks.push({
            text: a.innerText.trim(),
            href: href
          });
        }
      });

      // Colors & styles
      const bodyStyles = getStyles(document.body);
      const h1Styles = getStyles(document.querySelector('h1'));
      const pStyles = getStyles(document.querySelector('p'));
      const aStyles = getStyles(document.querySelector('a'));

      // Main content HTML
      const mainEl = document.querySelector('main, article, .entry-content, .elementor-section-wrap, #content') || document.body;
      const mainHtml = mainEl ? mainEl.innerHTML : '';
      const mainText = mainEl ? mainEl.innerText : '';

      return {
        title,
        h1,
        breadcrumb,
        bannerBg,
        tables,
        contentImages,
        docLinks,
        bodyStyles,
        h1Styles,
        pStyles,
        aStyles,
        mainTextExcerpt: mainText.substring(0, 500)
      };
    });

    fs.writeFileSync(`audit/raw_pages/${item.slug}_details.json`, JSON.stringify(pageDetails, null, 2));

    pageReports.push({
      slug: item.slug,
      url: item.url,
      id: item.id,
      title: pageDetails.title,
      h1: pageDetails.h1,
      tableCount: pageDetails.tables.length,
      imageCount: pageDetails.contentImages.length,
      docLinkCount: pageDetails.docLinks.length,
      breadcrumb: pageDetails.breadcrumb,
      bannerBg: pageDetails.bannerBg
    });

    console.log(`  -> Audit done: Tables=${pageDetails.tables.length}, Images=${pageDetails.contentImages.length}, Docs=${pageDetails.docLinks.length}`);
  }

  fs.writeFileSync('audit/audit_summary.json', JSON.stringify(pageReports, null, 2));
  console.log('\nAll 16 pages audited successfully! Summary written to audit/audit_summary.json');

  await browser.close();
}

run().catch(err => {
  console.error('Audit failed with error:', err);
  process.exit(1);
});
