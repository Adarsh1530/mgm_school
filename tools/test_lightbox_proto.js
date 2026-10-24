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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      body { background: #f7f8fa; padding: 40px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
      
      /* Card block */
      .rajya-award-card {
        background: #FFF8F9;
        border-left: 4px solid #ab0c2f !important;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        max-width: 580px;
      }
      
      /* Rounded corner square shape */
      .rajya-thumb-box {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        border-radius: 14px;
        overflow: hidden;
        border: 2px solid #eaeaea;
        background: #fff;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      }
      .rajya-thumb-box:hover {
        transform: translateY(-4px);
        border-color: #ab0c2f;
        box-shadow: 0 10px 24px rgba(171, 12, 47, 0.22);
      }
      .rajya-thumb-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.4s ease;
      }
      .rajya-thumb-box:hover img {
        transform: scale(1.06);
      }
      .rajya-thumb-overlay {
        position: absolute;
        inset: 0;
        background: rgba(171, 12, 47, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.25s ease;
      }
      .rajya-thumb-box:hover .rajya-thumb-overlay {
        opacity: 1;
      }
      .rajya-thumb-overlay i {
        color: #fff;
        font-size: 24px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(0,0,0,0.35);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .rajya-thumb-caption {
        margin-top: 8px;
        text-align: center;
        font-weight: 700;
        font-size: 13px;
        color: #2b2b2b;
      }

      /* Lightbox Modal */
      .mgm-lightbox-modal {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
      }
      .mgm-lightbox-modal.active {
        display: flex;
      }
      .mgm-lightbox-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(10, 14, 25, 0.94);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
      }
      .mgm-lightbox-container {
        position: relative;
        z-index: 100000;
        max-width: 92vw;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        user-select: none;
      }
      .mgm-lightbox-img-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 90vw;
        max-height: 80vh;
      }
      .mgm-lightbox-img {
        max-width: 90vw;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        border: 2px solid rgba(255, 255, 255, 0.15);
        background: #fff;
        animation: mgmZoomIn 0.25s ease-out;
      }
      @keyframes mgmZoomIn {
        from { transform: scale(0.92); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
      }
      .mgm-lightbox-bar {
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 800px;
        color: #fff;
        padding: 0 10px;
      }
      .mgm-lightbox-title {
        font-weight: 700;
        font-size: 16px;
        color: #f8f9fa;
        letter-spacing: 0.3px;
      }
      .mgm-lightbox-counter {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.75);
        background: rgba(255, 255, 255, 0.12);
        padding: 4px 12px;
        border-radius: 20px;
      }

      /* Navigation & Close Buttons */
      .mgm-lightbox-btn {
        position: absolute;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.35);
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 100010;
        transition: all 0.25s ease;
        outline: none;
      }
      .mgm-lightbox-btn:hover {
        background: #ab0c2f;
        border-color: #ab0c2f;
        color: #fff;
        transform: scale(1.1);
      }
      .mgm-lightbox-close {
        top: 24px;
        right: 28px;
        font-size: 28px;
        line-height: 1;
      }
      .mgm-lightbox-prev {
        left: 28px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 22px;
      }
      .mgm-lightbox-prev:hover {
        transform: translateY(-50%) scale(1.1);
      }
      .mgm-lightbox-next {
        right: 28px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 22px;
      }
      .mgm-lightbox-next:hover {
        transform: translateY(-50%) scale(1.1);
      }

      @media (max-width: 768px) {
        .mgm-lightbox-prev { left: 10px; width: 40px; height: 40px; }
        .mgm-lightbox-next { right: 10px; width: 40px; height: 40px; }
        .mgm-lightbox-close { top: 15px; right: 15px; width: 40px; height: 40px; }
        .mgm-lightbox-img { max-height: 72vh; }
      }
    </style>
  </head>
  <body>
    <div class="rajya-award-card">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h5 class="mb-0" style="color: #ab0c2f; font-weight: 700;">
          <i class="fa-solid fa-award me-2"></i>Rajyapuraskar Certificates
        </h5>
        <span class="badge bg-danger px-3 py-2">45 Awards</span>
      </div>
      <p class="text-muted small mb-3">Official Governor's Award certificates (click to view full certificate):</p>
      
      <div class="row g-3">
        <div class="col-6">
          <div class="rajya-thumb-box" onclick="openRajyaLightbox(0)">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png" alt="Rajyapuraskar 2024">
            <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
          </div>
          <div class="rajya-thumb-caption">Rajyapuraskar 2024</div>
        </div>
        <div class="col-6">
          <div class="rajya-thumb-box" onclick="openRajyaLightbox(1)">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png" alt="Rajyapuraskar 2023">
            <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
          </div>
          <div class="rajya-thumb-caption">Rajyapuraskar 2023</div>
        </div>
        <div class="col-6">
          <div class="rajya-thumb-box" onclick="openRajyaLightbox(2)">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png" alt="Rajyapuraskar 2022">
            <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
          </div>
          <div class="rajya-thumb-caption">Rajyapuraskar 2022</div>
        </div>
        <div class="col-6">
          <div class="rajya-thumb-box" onclick="openRajyaLightbox(3)">
            <img src="http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png" alt="Rajyapuraskar 2019">
            <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
          </div>
          <div class="rajya-thumb-caption">Rajyapuraskar 2019</div>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <div id="mgmRajyaLightbox" class="mgm-lightbox-modal" role="dialog" aria-modal="true" aria-label="Certificate Image Viewer">
      <div class="mgm-lightbox-backdrop" onclick="closeRajyaLightbox()"></div>
      <button type="button" class="mgm-lightbox-btn mgm-lightbox-close" onclick="closeRajyaLightbox()" aria-label="Close viewer">&times;</button>
      <button type="button" class="mgm-lightbox-btn mgm-lightbox-prev" onclick="prevRajyaSlide()" aria-label="Previous certificate"><i class="fa-solid fa-chevron-left"></i></button>
      <button type="button" class="mgm-lightbox-btn mgm-lightbox-next" onclick="nextRajyaSlide()" aria-label="Next certificate"><i class="fa-solid fa-chevron-right"></i></button>
      
      <div class="mgm-lightbox-container">
        <div class="mgm-lightbox-img-wrap">
          <img id="mgmLightboxImg" src="" alt="Rajyapuraskar Certificate" class="mgm-lightbox-img">
        </div>
        <div class="mgm-lightbox-bar">
          <span id="mgmLightboxTitle" class="mgm-lightbox-title">Rajyapuraskar 2024</span>
          <span id="mgmLightboxCounter" class="mgm-lightbox-counter">1 / 4</span>
        </div>
      </div>
    </div>

    <script>
      const rajyaItems = [
        { src: 'http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2024.png', title: 'Rajyapuraskar 2024 - Governor\'s Award' },
        { src: 'http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2023.png', title: 'Rajyapuraskar 2023 - Governor\'s Award' },
        { src: 'http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2022.png', title: 'Rajyapuraskar 2022 - Governor\'s Award' },
        { src: 'http://localhost/MGM%20SCHOOL/assets/images/rajyapuraskar-2019.png', title: 'Rajyapuraskar 2019 - Governor\'s Award' }
      ];
      let currentRajyaIndex = 0;

      function openRajyaLightbox(index) {
        currentRajyaIndex = index;
        updateRajyaLightbox();
        const modal = document.getElementById('mgmRajyaLightbox');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
      }

      function closeRajyaLightbox() {
        const modal = document.getElementById('mgmRajyaLightbox');
        modal.classList.remove('active');
        document.body.style.overflow = '';
      }

      function updateRajyaLightbox() {
        const item = rajyaItems[currentRajyaIndex];
        const img = document.getElementById('mgmLightboxImg');
        const title = document.getElementById('mgmLightboxTitle');
        const counter = document.getElementById('mgmLightboxCounter');
        
        img.src = item.src;
        title.innerText = item.title;
        counter.innerText = (currentRajyaIndex + 1) + ' / ' + rajyaItems.length;
      }

      function prevRajyaSlide() {
        currentRajyaIndex = (currentRajyaIndex - 1 + rajyaItems.length) % rajyaItems.length;
        updateRajyaLightbox();
      }

      function nextRajyaSlide() {
        currentRajyaIndex = (currentRajyaIndex + 1) % rajyaItems.length;
        updateRajyaLightbox();
      }

      document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('mgmRajyaLightbox');
        if (!modal || !modal.classList.contains('active')) return;
        if (e.key === 'Escape') closeRajyaLightbox();
        else if (e.key === 'ArrowLeft') prevRajyaSlide();
        else if (e.key === 'ArrowRight') nextRajyaSlide();
      });
    </script>
  </body>
  </html>
  `;

  await page.setContent(html, { waitUntil: 'networkidle2' });
  await page.screenshot({ path: 'tools/rajya_interactive_closed.png' });
  console.log('Saved closed screenshot');

  // Open modal on item 0
  await page.click('.rajya-thumb-box');
  await new Promise(r => setTimeout(r, 500));
  await page.screenshot({ path: 'tools/rajya_interactive_open.png' });
  console.log('Saved open modal screenshot');

  // Click next button
  await page.click('.mgm-lightbox-next');
  await new Promise(r => setTimeout(r, 500));
  await page.screenshot({ path: 'tools/rajya_interactive_next.png' });
  console.log('Saved next slide screenshot');

  await browser.close();
})();
