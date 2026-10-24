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
  await page.setViewport({ width: 1280, height: 900 });

  const html = `
  <!DOCTYPE html>
  <html>
  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/MGM%20SCHOOL/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      body { background: #f8f9fa; padding: 40px; font-family: sans-serif; }
      .test-container { max-width: 550px; background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 40px; }
      
      .rajya-square-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      }
      .rajya-square-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(171, 12, 47, 0.18);
        border-color: #ab0c2f;
      }
      .rajya-img-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        background: #fdfdfd;
        border-radius: 12px 12px 0 0;
      }
      .rajya-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.4s ease;
      }
      .rajya-square-card:hover .rajya-img-wrap img {
        transform: scale(1.05);
      }
      .rajya-overlay {
        position: absolute;
        inset: 0;
        background: rgba(171, 12, 47, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
      }
      .rajya-square-card:hover .rajya-overlay {
        opacity: 1;
      }
      .rajya-overlay i {
        color: #fff;
        font-size: 24px;
        background: rgba(0,0,0,0.3);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .rajya-card-footer {
        padding: 10px 8px;
        text-align: center;
        background: #fff;
        border-top: 1px solid #f0f0f0;
      }
      .rajya-card-footer span {
        font-weight: 700;
        font-size: 13px;
        color: #222;
        display: block;
      }
    </style>
  </head>
  <body>
    <h3>Layout Option A: 2x2 Grid (Each square ~240px)</h3>
    <div class="test-container">
      <div class="card border-0 shadow-sm p-4" style="background: #FFF8F9; border-left: 4px solid #ab0c2f !important; border-radius: 14px;">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="mb-0 text-danger fw-bold"><i class="fa-solid fa-award me-2"></i>Rajyapuraskar Certificates</h5>
          <span class="badge bg-danger">45 Awards</span>
        </div>
        <p class="text-muted small mb-3">Click any certificate to view in popup:</p>
        <div class="row g-3">
          <div class="col-6">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png" alt="2024">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span>Rajyapuraskar 2024</span></div>
            </div>
          </div>
          <div class="col-6">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png" alt="2023">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span>Rajyapuraskar 2023</span></div>
            </div>
          </div>
          <div class="col-6">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png" alt="2022">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span>Rajyapuraskar 2022</span></div>
            </div>
          </div>
          <div class="col-6">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png" alt="2019">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span>Rajyapuraskar 2019</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h3>Layout Option B: 4 in a row (Each square ~110px)</h3>
    <div class="test-container">
      <div class="card border-0 shadow-sm p-4" style="background: #FFF8F9; border-left: 4px solid #ab0c2f !important; border-radius: 14px;">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="mb-0 text-danger fw-bold"><i class="fa-solid fa-award me-2"></i>Rajyapuraskar Certificates</h5>
          <span class="badge bg-danger">45 Awards</span>
        </div>
        <p class="text-muted small mb-3">Click any certificate to view in popup:</p>
        <div class="row g-2">
          <div class="col-3">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png" alt="2024">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span style="font-size: 11px;">2024</span></div>
            </div>
          </div>
          <div class="col-3">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png" alt="2023">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span style="font-size: 11px;">2023</span></div>
            </div>
          </div>
          <div class="col-3">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png" alt="2022">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span style="font-size: 11px;">2022</span></div>
            </div>
          </div>
          <div class="col-3">
            <div class="rajya-square-card">
              <div class="rajya-img-wrap">
                <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png" alt="2019">
                <div class="rajya-overlay"><i class="fa-solid fa-expand"></i></div>
              </div>
              <div class="rajya-card-footer"><span style="font-size: 11px;">2019</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
  `;

  await page.setContent(html, { waitUntil: 'networkidle2' });
  await page.screenshot({ path: 'tools/rajya_layout_comparison.png', fullPage: true });
  console.log('Saved comparison screenshot to tools/rajya_layout_comparison.png');
  await browser.close();
})();
