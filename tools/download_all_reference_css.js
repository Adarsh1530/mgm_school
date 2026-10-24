const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

// Read all unique CSS links extracted from the live site
const allCssLinks = JSON.parse(fs.readFileSync('audit/all_css_links.json', 'utf8'));

// Filter out duplicates and google fonts
const cssToFetch = allCssLinks.filter(url => 
  url.startsWith('https://mgm-school.nbtksa.in/') && 
  url.includes('.css')
);

const uniqueUrls = Array.from(new Set(cssToFetch));
console.log(`Found ${uniqueUrls.length} unique CSS files to download from reference site.`);

async function run() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000 });
  await new Promise(r => setTimeout(r, 6000));
  let title = '';
  for (let i = 0; i < 20; i++) {
    try {
      title = await page.title();
      if (title && !title.includes('Checking your browser')) break;
    } catch (e) {}
    await new Promise(r => setTimeout(r, 1000));
  }
  await new Promise(r => setTimeout(r, 3000));

  const cssDir = path.join(__dirname, '..', 'assets', 'css');
  if (!fs.existsSync(cssDir)) fs.mkdirSync(cssDir, { recursive: true });

  const downloaded = [];

  for (let i = 0; i < uniqueUrls.length; i++) {
    const url = uniqueUrls[i];
    const urlObj = new URL(url);
    const cleanBasename = path.basename(urlObj.pathname);
    // If name collides, prefix with folder hash or part
    let localName = cleanBasename;
    if (url.includes('/elementor/')) {
      localName = 'elementor-' + cleanBasename;
    } else if (url.includes('/acadia-core/')) {
      localName = 'acadia-core-' + cleanBasename;
    }

    const dest = path.join(cssDir, localName);
    console.log(`[${i+1}/${uniqueUrls.length}] Fetching ${localName}...`);

    try {
      const text = await page.evaluate(async (u) => {
        try {
          const r = await fetch(u);
          if (!r.ok) return { error: r.status };
          return { data: await r.text() };
        } catch (e) {
          return { error: e.message };
        }
      }, url);

      if (text && text.data) {
        fs.writeFileSync(dest, text.data);
        console.log(`  -> Saved ${localName} (${text.data.length} bytes)`);
        downloaded.push({ originalUrl: url, localFile: localName, size: text.data.length });
      } else {
        console.warn(`  -> Failed ${localName}:`, text.error);
      }
    } catch (e) {
      console.error(`  -> Error fetching ${localName}:`, e.message);
    }
  }

  fs.writeFileSync('audit/downloaded_css_manifest.json', JSON.stringify(downloaded, null, 2));
  console.log('All reference CSS files downloaded successfully!');

  await browser.close();
}

run().catch(console.error);
