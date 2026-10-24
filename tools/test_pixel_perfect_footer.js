const puppeteer = require('puppeteer-core');
const fs = require('fs');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  
  // Let's inspect the visual appearance and vertical alignment
  await page.setContent(`
    <style>
      body { background: #12141A; margin: 0; padding: 30px; font-family: 'Outfit', sans-serif; }
      .tp-footer-logo-wrap {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
      }
      .tp-footer-badge {
        background: #ffffff;
        border-radius: 50%;
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.35);
        flex-shrink: 0;
      }
      .tp-footer-badge img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        display: block;
      }
      .brand-title {
        color: #ffffff;
        font-weight: 700;
        font-size: 16px;
        line-height: 1.2;
        letter-spacing: 0.5px;
      }
      .brand-sub {
        color: rgba(255, 255, 255, 0.65);
        font-size: 10.5px;
        font-weight: 600;
        line-height: 1.2;
        margin-top: 4px;
        letter-spacing: 0.4px;
      }
    </style>
    <div class="tp-footer-logo-wrap">
      <div class="tp-footer-badge">
        <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" />
      </div>
      <div>
        <div class="brand-title">MGM MODEL SCHOOL</div>
        <div class="brand-sub">AYIROOR, VARKALA &bull; ESTD 1983</div>
      </div>
    </div>
  `);
  
  await page.screenshot({ path: 'tools/pixel_perfect_footer_logo.png' });
  console.log('Saved tools/pixel_perfect_footer_logo.png');
  await browser.close();
})();
