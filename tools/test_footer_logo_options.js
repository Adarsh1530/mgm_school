const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  
  await page.setContent(`
    <div style="background: #12141a; padding: 40px; font-family: 'Outfit', sans-serif; display: flex; flex-direction: column; gap: 30px;">
      
      <!-- Option A: Clean Transparent Logo with Brand Text perfectly aligned -->
      <div>
        <p style="color: #aaa; margin-bottom: 8px;">Option A: Clean Transparent Logo + Typography (Vertically Centered)</p>
        <div style="display: inline-flex; align-items: center; gap: 14px;">
          <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" style="height: 54px; width: auto; object-fit: contain;" />
          <div>
            <div style="font-size: 16px; font-weight: 700; color: #ffffff; line-height: 1.2; letter-spacing: 0.5px;">MGM MODEL SCHOOL</div>
            <div style="font-size: 10.5px; color: rgba(255,255,255,0.6); margin-top: 3px; letter-spacing: 0.3px;">AYIROOR, VARKALA &bull; ESTD 1983</div>
          </div>
        </div>
      </div>

      <!-- Option B: Perfectly Centered Circular Shield Badge -->
      <div>
        <p style="color: #aaa; margin-bottom: 8px;">Option B: Perfectly Centered White Shield Badge</p>
        <div style="display: inline-flex; align-items: center; gap: 14px;">
          <div style="width: 54px; height: 54px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); flex-shrink: 0;">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" style="width: 44px; height: 44px; object-fit: contain; display: block;" />
          </div>
          <div>
            <div style="font-size: 16px; font-weight: 700; color: #ffffff; line-height: 1.2; letter-spacing: 0.5px;">MGM MODEL SCHOOL</div>
            <div style="font-size: 10.5px; color: rgba(255,255,255,0.6); margin-top: 3px; letter-spacing: 0.3px;">AYIROOR, VARKALA &bull; ESTD 1983</div>
          </div>
        </div>
      </div>

      <!-- Option C: Standalone Logo Image (like the reference footer) -->
      <div>
        <p style="color: #aaa; margin-bottom: 8px;">Option C: Standalone Logo Image (Clean Brand Emblem)</p>
        <div>
          <img src="http://localhost/MGM%20SCHOOL/assets/images/new-mgm-logo.png" style="height: 65px; width: auto; object-fit: contain;" />
        </div>
      </div>

    </div>
  `);
  
  await page.screenshot({ path: 'tools/footer_logo_options.png' });
  console.log('Saved tools/footer_logo_options.png');
  await browser.close();
})();
