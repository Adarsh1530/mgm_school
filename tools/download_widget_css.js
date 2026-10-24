const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

const cssUrls = [
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/hero/hero.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/common/text-slider.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/services/services.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/common/academic-programs.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/event/event.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/testimonial/testimonial.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/video/video.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core//include/elementor/course/course.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/hover-reveal.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/uploads/elementor/css/post-762.css?ver=1792552741',
  'https://mgm-school.nbtksa.in/wp-content/uploads/elementor/css/post-200.css?ver=1792552741',
  'https://mgm-school.nbtksa.in/wp-content/uploads/elementor/css/local-1119-frontend-desktop.css?ver=6ad82f24d6948',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core/assets/css/fontawesome-all.min.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/plugins/acadia-core/assets/css/flaticon.css?ver=1.0.0',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/font-awesome-pro.css?ver=7.0.7',
  'https://mgm-school.nbtksa.in/wp-content/themes/acadia/assets/css/swiper-bundle.css?ver=7.0.7'
];

async function run() {
  const browser = await puppeteer.launch({ executablePath: CHROME_PATH, headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('https://mgm-school.nbtksa.in/', { timeout: 35000, waitUntil: 'domcontentloaded' }).catch(() => {});
  await new Promise(r => setTimeout(r, 4000));

  const outDir = path.join(__dirname, '..', 'assets', 'css');

  for (const u of cssUrls) {
    const rawName = path.basename(new URL(u).pathname);
    const dest = path.join(outDir, rawName);
    console.log(`Downloading ${rawName} from ${u}...`);

    try {
      const res = await page.evaluate(async (url) => {
        try {
          const r = await fetch(url);
          if (!r.ok) return { error: r.status };
          return { text: await r.text() };
        } catch (e) {
          return { error: e.message };
        }
      }, u);

      if (res && res.text) {
        fs.writeFileSync(dest, res.text);
        console.log(`  Saved ${rawName} (${res.text.length} chars)`);
      } else {
        console.log(`  Failed:`, res ? res.error : 'null');
      }
    } catch (e) {
      console.error(`  Error:`, e.message);
    }
  }

  await browser.close();
}

run().catch(console.error);
