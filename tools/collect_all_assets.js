const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

// Load all gathered URLs
const mediaUrls = JSON.parse(fs.readFileSync('audit/media_urls.json', 'utf8'));
const docUrls = JSON.parse(fs.readFileSync('audit/doc_urls.json', 'utf8'));

// Additional essential URLs
const extraUrls = [
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/cropped-1733381285-removebg-preview.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/1733381285-removebg-preview.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/07/1733381285.jpg',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2024/08/breadcrumb-bg.jpg',
  'https://mgm-school.nbtksa.in/wp-content/plugins/tutor/assets/images/profile-photo.png',
  'https://mgm-school.nbtksa.in/wp-content/uploads/2026/07/download-pdf.png'
];

// Combine unique URLs
const allUrls = Array.from(new Set([...mediaUrls, ...docUrls, ...extraUrls]));

// Ensure local directories
const DIRS = [
  'public',
  'public/assets',
  'public/assets/images',
  'public/assets/docs',
  'public/assets/css',
  'public/assets/js'
];
for (const d of DIRS) {
  if (!fs.existsSync(d)) fs.mkdirSync(d, { recursive: true });
}

async function run() {
  console.log(`Starting download of ${allUrls.length} assets...`);
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--window-size=1280,800', '--disable-blink-features=AutomationControlled', '--no-sandbox']
  });

  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000 });
  
  // Wait for challenge
  await new Promise(r => setTimeout(r, 6000));
  let title = await page.title();
  while (title.includes('Checking your browser')) {
    await new Promise(r => setTimeout(r, 1000));
    title = await page.title();
  }

  const manifest = [];

  for (let i = 0; i < allUrls.length; i++) {
    const assetUrl = allUrls[i];
    const urlObj = new URL(assetUrl);
    const basename = path.basename(urlObj.pathname);
    const ext = path.extname(basename).toLowerCase();
    
    let subfolder = 'images';
    if (ext === '.pdf' || ext === '.doc' || ext === '.docx' || ext === '.xlsx') {
      subfolder = 'docs';
    }
    
    const localRelPath = `assets/${subfolder}/${basename}`;
    const localFullPath = path.join(__dirname, '..', 'public', localRelPath);
    const targetDir = path.dirname(localFullPath);
    if (!fs.existsSync(targetDir)) {
      fs.mkdirSync(targetDir, { recursive: true });
    }

    console.log(`[${i+1}/${allUrls.length}] Fetching ${basename}...`);

    try {
      const base64Data = await page.evaluate(async (url) => {
        try {
          const res = await fetch(url);
          if (!res.ok) return { error: `HTTP ${res.status}` };
          const blob = await res.blob();
          return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onloadend = () => resolve({ data: reader.result });
            reader.onerror = reject;
            reader.readAsDataURL(blob);
          });
        } catch (err) {
          return { error: err.message };
        }
      }, assetUrl);

      if (base64Data && base64Data.data) {
        const matches = base64Data.data.match(/^data:([A-Za-z-+\/]+);base64,(.+)$/);
        if (matches && matches.length === 3) {
          const buffer = Buffer.from(matches[2], 'base64');
          fs.writeFileSync(localFullPath, buffer);
          console.log(`  -> Saved ${localRelPath} (${buffer.length} bytes)`);
          manifest.push({
            originalUrl: assetUrl,
            localPath: localRelPath,
            size: buffer.length,
            status: 'Downloaded'
          });
        } else {
          console.warn(`  -> Unexpected data format for ${assetUrl}`);
          manifest.push({ originalUrl: assetUrl, status: 'Failed format' });
        }
      } else {
        console.warn(`  -> Could not fetch ${assetUrl}:`, base64Data.error);
        manifest.push({ originalUrl: assetUrl, status: `Failed: ${base64Data.error}` });
      }
    } catch (e) {
      console.error(`  -> Error downloading ${assetUrl}:`, e.message);
      manifest.push({ originalUrl: assetUrl, status: `Error: ${e.message}` });
    }
  }

  fs.writeFileSync('audit/asset_manifest.json', JSON.stringify(manifest, null, 2));
  console.log('\nAsset collection completed. Manifest saved to audit/asset_manifest.json');

  await browser.close();
}

run().catch(console.error);
