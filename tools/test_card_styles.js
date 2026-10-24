const puppeteer = require('puppeteer-core');
const CHROME_PATH = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 900 });

  const html = `
  <!DOCTYPE html>
  <html>
  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      body { background: #f4f6f8; padding: 40px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
      .test-container { max-width: 580px; background: #fff; padding: 24px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
      
      /* Style 1: object-fit cover in square */
      .card-cover {
        position: relative;
        aspect-ratio: 1 / 1;
        border-radius: 14px;
        overflow: hidden;
        border: 2px solid #f0f0f0;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
      }
      .card-cover:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 24px rgba(171, 12, 47, 0.2);
        border-color: #ab0c2f;
      }
      .card-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
      }
      
      /* Style 2: object-fit contain in square */
      .card-contain {
        position: relative;
        aspect-ratio: 1 / 1;
        border-radius: 14px;
        overflow: hidden;
        border: 2px solid #eaeaea;
        background: #fff;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
      }
      .card-contain:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 24px rgba(171, 12, 47, 0.2);
        border-color: #ab0c2f;
      }
      .card-contain img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
      }
      
      .label-title {
        font-weight: 700;
        font-size: 13px;
        color: #333;
        text-align: center;
        margin-top: 8px;
      }

      .overlay-icon {
        position: absolute;
        inset: 0;
        background: rgba(171, 12, 47, 0.55);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #fff;
        opacity: 0;
        transition: opacity 0.25s ease;
        border-radius: 12px;
      }
      .card-cover:hover .overlay-icon,
      .card-contain:hover .overlay-icon {
        opacity: 1;
      }
      .overlay-icon i {
        font-size: 26px;
        margin-bottom: 4px;
      }
      .overlay-icon span {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
    </style>
  </head>
  <body>
    <h3>Test 1: 2x2 Grid with Object-Fit Contain (Full Certificate Visible in Square)</h3>
    <div class="test-container">
      <div class="row g-3">
        <div class="col-6">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png" alt="2024">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2024</div>
        </div>
        <div class="col-6">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png" alt="2023">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2023</div>
        </div>
        <div class="col-6">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png" alt="2022">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2022</div>
        </div>
        <div class="col-6">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png" alt="2019">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2019</div>
        </div>
      </div>
    </div>

    <h3>Test 2: 2x2 Grid with Object-Fit Cover (Fills entire square, cropped to center)</h3>
    <div class="test-container">
      <div class="row g-3">
        <div class="col-6">
          <div class="card-cover">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png" alt="2024">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2024</div>
        </div>
        <div class="col-6">
          <div class="card-cover">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png" alt="2023">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2023</div>
        </div>
        <div class="col-6">
          <div class="card-cover">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png" alt="2022">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2022</div>
        </div>
        <div class="col-6">
          <div class="card-cover">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png" alt="2019">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i><span>View</span></div>
          </div>
          <div class="label-title">Rajyapuraskar 2019</div>
        </div>
      </div>
    </div>

    <h3>Test 3: 4 in a row (col-3) with Object-Fit Contain</h3>
    <div class="test-container">
      <div class="row g-2">
        <div class="col-3">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png" alt="2024">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i></div>
          </div>
          <div class="label-title" style="font-size: 11px;">2024</div>
        </div>
        <div class="col-3">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png" alt="2023">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i></div>
          </div>
          <div class="label-title" style="font-size: 11px;">2023</div>
        </div>
        <div class="col-3">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png" alt="2022">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i></div>
          </div>
          <div class="label-title" style="font-size: 11px;">2022</div>
        </div>
        <div class="col-3">
          <div class="card-contain">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png" alt="2019">
            <div class="overlay-icon"><i class="fa-solid fa-expand"></i></div>
          </div>
          <div class="label-title" style="font-size: 11px;">2019</div>
        </div>
      </div>
    </div>
  </body>
  </html>
  `;

  await page.setContent(html, { waitUntil: 'networkidle2' });
  await page.screenshot({ path: 'tools/rajya_card_styles.png', fullPage: true });
  console.log('Saved card styles screenshot to tools/rajya_card_styles.png');
  await browser.close();
})();
