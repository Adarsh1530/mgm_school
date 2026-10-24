<?php
/**
 * Merit Day View
 * MGM Model School Recreation Project - Academic & Leadership Felicitations & State Awards
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "merit-day";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Merit Day";
$breadcrumbTitle = "Merit Day";
$metaDescription = "Merit Day Celebrations, Investiture Ceremony, Convocation, Board Exam Toppers, and Rajyapuraskar Governor's Awards at MGM Model School.";
$wpId = 15985;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<style>
  /* Rounded corner square certificates */
  .rajya-thumb-box {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: #ffffff;
    cursor: pointer;
  }
  .rajya-thumb-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.4s ease;
  }
  .rajya-card-item:hover .rajya-thumb-box img {
    transform: scale(1.06);
  }
  .rajya-thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(171, 12, 47, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s ease;
  }
  .rajya-card-item:hover .rajya-thumb-overlay {
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
  .rajya-card-item {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  }
  .rajya-card-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(171, 12, 47, 0.15) !important;
    border-color: var(--tp-theme-primary, #ab0c2f) !important;
  }

  /* MGM Lightbox Modal */
  .mgm-lightbox-modal {
    position: fixed;
    inset: 0;
    z-index: 999999;
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
    z-index: 1000000;
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
    background: rgba(255, 255, 255, 0.15);
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
    z-index: 1000010;
    transition: all 0.25s ease;
    outline: none;
  }
  .mgm-lightbox-btn:hover {
    background: var(--tp-theme-primary, #ab0c2f);
    border-color: var(--tp-theme-primary, #ab0c2f);
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
    .mgm-lightbox-prev { left: 10px; width: 42px; height: 42px; }
    .mgm-lightbox-next { right: 10px; width: 42px; height: 42px; }
    .mgm-lightbox-close { top: 15px; right: 15px; width: 42px; height: 42px; }
    .mgm-lightbox-img { max-height: 72vh; }
  }
</style>

<div class="tp-subpage-container py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Page Header -->
    <div class="text-center mb-5">
      <span class="badge px-3 py-2 text-uppercase mb-2" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700;">Celebrating Excellence</span>
      <h2 class="tp-section-title mb-3" style="font-size: 34px; font-weight: 700; color: #141B2B;">Academic Honors &amp; Leadership Felicitations</h2>
      <p class="text-muted mx-auto" style="max-width: 720px; font-size: 16px; line-height: 1.8;">
        At MGM Model School, we celebrate hard work, character, and exceptional performance across academic disciplines, student governance, and state-level co-curricular pursuits.
      </p>
    </div>

    <!-- Section 1: Investiture Ceremony -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
      <div class="row g-0 align-items-center">
        <div class="col-lg-6">
          <div style="height: 380px; overflow: hidden;">
            <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/investiture-ceremony.jpeg" alt="Investiture Ceremony at MGM School" class="w-100 h-100" style="object-fit: cover;">
          </div>
        </div>
        <div class="col-lg-6 p-4 p-md-5">
          <span class="badge px-3 py-1 mb-2 text-uppercase" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary); font-size: 10px; font-weight: 700;">Student Governance</span>
          <h3 class="fw-bold text-dark mb-3" style="font-size: 26px;">Investiture Ceremony</h3>
          <p class="text-secondary leading-relaxed mb-3" style="font-size: 15px; line-height: 1.8;">
            The school's Investiture Ceremony is a time-honoured tradition where student leaders are chosen through a selective interview process to take on key roles as Head Boy, Head Girl, Deputy Head Boy &amp; Head Girl, Sports Captains, and House Prefects.
          </p>
          <p class="text-muted small mb-4">
            These student leaders play a vital role in maintaining discipline, coordinating morning assemblies, and spearheading intra-school events, developing essential teamwork and ethical decision-making skills.
          </p>
          <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-check text-success me-1"></i> Democratic Selection</span>
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-check text-success me-1"></i> House Leadership</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 2: Convocation Day -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
      <div class="row g-0 align-items-center flex-lg-row-reverse">
        <div class="col-lg-6">
          <div style="height: 380px; overflow: hidden;">
            <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/convocation-day.jpeg" alt="Convocation Day at MGM School" class="w-100 h-100" style="object-fit: cover;">
          </div>
        </div>
        <div class="col-lg-6 p-4 p-md-5">
          <span class="badge px-3 py-1 mb-2 text-uppercase" style="background: rgba(37,99,235,0.1); color: #2563EB; font-size: 10px; font-weight: 700;">Academic Milestone</span>
          <h3 class="fw-bold text-dark mb-3" style="font-size: 26px;">Annual Convocation Day</h3>
          <p class="text-secondary leading-relaxed mb-3" style="font-size: 15px; line-height: 1.8;">
            Held annually during the first and second weeks of April, the Convocation Day commemorates the transition of our young learners graduating from Kindergarten into Primary School, as well as acknowledging top performers throughout the academic year.
          </p>
          <p class="text-muted small mb-4">
            Dressed in ceremonial robes and caps, students receive merit scrolls from the Principal and distinguished guests in the presence of proud parents and faculty members.
          </p>
          <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-graduation-cap text-primary me-1"></i> KG Graduation</span>
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-award text-primary me-1"></i> Merit Scrolls</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 3: Toppers Day (Board Exam Stars) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="text-center mb-4">
        <span class="badge px-3 py-1 mb-2 text-uppercase" style="background: rgba(22,163,74,0.1); color: #16A34A; font-size: 10px; font-weight: 700;">Board Exam Felicitations</span>
        <h3 class="fw-bold text-dark mb-2" style="font-size: 26px;">Toppers Day &bull; AISSE &amp; SSCE Stars</h3>
        <p class="text-muted small mx-auto" style="max-width: 650px;">
          Honoring Class X and Class XII students who have achieved stellar distinction in the CBSE All India Secondary and Senior School Certificate Examinations.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-6">
          <div class="card border h-100 shadow-sm overflow-hidden" style="border-radius: 12px;">
            <div style="height: 300px; overflow: hidden;">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/toppers-day-1.jpeg" alt="Toppers Day Felicitations" class="w-100 h-100" style="object-fit: cover;">
            </div>
            <div class="p-3 text-center bg-white">
              <span class="fw-bold text-dark d-block">Class XII &bull; Senior School Toppers</span>
              <span class="text-muted small">Science and Commerce stream rank holders felicitated by School Management</span>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card border h-100 shadow-sm overflow-hidden" style="border-radius: 12px;">
            <div style="height: 300px; overflow: hidden;">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/toppers-day-2.jpeg" alt="AISSE Class X Merit Winners" class="w-100 h-100" style="object-fit: cover;">
            </div>
            <div class="p-3 text-center bg-white">
              <span class="fw-bold text-dark d-block">Class X &bull; AISSE Distinction Winners</span>
              <span class="text-muted small">Full A1 achievers and subject toppers awarded trophies and certificates</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 4: Rajyapuraskar (Governor's Award) Felicitations -->
    <div id="rajyapuraskar" class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
      <!-- Part A: Split Card Layout (Matching Section 1 & 2) -->
      <div class="row g-0 align-items-center">
        <div class="col-lg-6">
          <div style="height: 400px; overflow: hidden; position: relative;">
            <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/rajyapuraskar-2024.png" alt="Governor of Kerala presenting Rajyapuraskar Award" class="w-100 h-100" style="object-fit: cover; object-position: center;">
            <div style="position: absolute; bottom: 15px; left: 15px; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
              <i class="fa-solid fa-award text-warning me-1"></i> Raj Bhavan Ceremony
            </div>
          </div>
        </div>
        <div class="col-lg-6 p-4 p-md-5">
          <span class="badge px-3 py-1 mb-2 text-uppercase" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary); font-size: 10px; font-weight: 700;">State Governor's Honor</span>
          <h3 class="fw-bold text-dark mb-3" style="font-size: 26px;">Rajyapuraskar (Governor's Award)</h3>
          <p class="text-secondary leading-relaxed mb-3" style="font-size: 15px; line-height: 1.8;">
            The prestigious Rajyapuraskar (Governor's Award) represents the highest scouting honor conferred at the state level by the Honourable Governor of Kerala upon senior cadets demonstrating extraordinary dedication, character, and civic service.
          </p>
          <p class="text-muted small mb-4">
            Under the guidance of Scout Master <strong>Mr. Pravin S R</strong>, an exceptional cohort of <strong>45 cadets</strong> from MGM Model School has been decorated with this prestigious state honor across successive years.
          </p>
          <div class="d-flex align-items-center gap-3 flex-wrap">
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-award text-danger me-1"></i> 45 Cadets Conferred</span>
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-medal text-warning me-1"></i> Governor of Kerala</span>
            <span class="badge bg-light text-dark border px-3 py-2 small"><i class="fa-solid fa-shield-halved text-success me-1"></i> Hindustan Scouts &amp; Guides</span>
          </div>
        </div>
      </div>

      <!-- Part B: 4-Card Certificate Roll of Honor (Matching Section 3 Card Grid with Round-Corner Square Thumbnails & Lightbox) -->
      <div class="p-4 p-md-5 border-top" style="background: #FDFBF8;">
        <div class="text-center mb-4">
          <span class="badge px-3 py-1 mb-2 text-uppercase" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary); font-size: 10px; font-weight: 700;">Roll of Honor</span>
          <h4 class="fw-bold text-dark mb-2" style="font-size: 24px;">Rajyapuraskar Certificate Gallery</h4>
          <p class="text-muted small mx-auto mb-0" style="max-width: 650px;">
            Official award ceremony photographs and certificates conferred to MGM cadets. Click any certificate to view in high resolution:
          </p>
        </div>

        <div class="row g-4">
          <div class="col-6 col-lg-3">
            <div class="card border h-100 shadow-sm overflow-hidden rajya-card-item" style="border-radius: 14px; cursor: pointer;" onclick="openRajyaLightbox(0)">
              <div class="rajya-thumb-box">
                <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/rajyapuraskar-2024.png" alt="Rajyapuraskar 2024">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="p-3 text-center bg-white border-top">
                <span class="fw-bold text-dark d-block" style="font-size: 15px;">Rajyapuraskar 2024</span>
                <span class="text-muted small d-block mt-1">Governor's Award Ceremony</span>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3">
            <div class="card border h-100 shadow-sm overflow-hidden rajya-card-item" style="border-radius: 14px; cursor: pointer;" onclick="openRajyaLightbox(1)">
              <div class="rajya-thumb-box">
                <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/rajyapuraskar-2023.png" alt="Rajyapuraskar 2023">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="p-3 text-center bg-white border-top">
                <span class="fw-bold text-dark d-block" style="font-size: 15px;">Rajyapuraskar 2023</span>
                <span class="text-muted small d-block mt-1">Governor's Award Ceremony</span>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3">
            <div class="card border h-100 shadow-sm overflow-hidden rajya-card-item" style="border-radius: 14px; cursor: pointer;" onclick="openRajyaLightbox(2)">
              <div class="rajya-thumb-box">
                <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/rajyapuraskar-2022.png" alt="Rajyapuraskar 2022">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="p-3 text-center bg-white border-top">
                <span class="fw-bold text-dark d-block" style="font-size: 15px;">Rajyapuraskar 2022</span>
                <span class="text-muted small d-block mt-1">Governor's Award Ceremony</span>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3">
            <div class="card border h-100 shadow-sm overflow-hidden rajya-card-item" style="border-radius: 14px; cursor: pointer;" onclick="openRajyaLightbox(3)">
              <div class="rajya-thumb-box">
                <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/rajyapuraskar-2019.png" alt="Rajyapuraskar 2019">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="p-3 text-center bg-white border-top">
                <span class="fw-bold text-dark d-block" style="font-size: 15px;">Rajyapuraskar 2019</span>
                <span class="text-muted small d-block mt-1">Governor's Award Ceremony</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Lightbox Modal Popup -->
<div id="mgmRajyaLightbox" class="mgm-lightbox-modal" role="dialog" aria-modal="true" aria-label="Certificate Image Viewer">
  <div class="mgm-lightbox-backdrop" onclick="closeRajyaLightbox()"></div>
  <button type="button" class="mgm-lightbox-btn mgm-lightbox-close" onclick="closeRajyaLightbox()" aria-label="Close viewer">&times;</button>
  <button type="button" class="mgm-lightbox-btn mgm-lightbox-prev" onclick="prevRajyaSlide()" aria-label="Previous certificate"><i class="fa-solid fa-chevron-left"></i></button>
  <button type="button" class="mgm-lightbox-btn mgm-lightbox-next" onclick="nextRajyaSlide()" aria-label="Next certificate"><i class="fa-solid fa-chevron-right"></i></button>
  
  <div class="mgm-lightbox-container">
    <div class="mgm-lightbox-img-wrap">
      <img id="mgmLightboxImg" src="<?= rtrim(BASE_URL, '/') ?>/assets/images/rajyapuraskar-2024.png" alt="Rajyapuraskar Certificate" class="mgm-lightbox-img">
    </div>
    <div class="mgm-lightbox-bar">
      <span id="mgmLightboxTitle" class="mgm-lightbox-title">Rajyapuraskar 2024</span>
      <span id="mgmLightboxCounter" class="mgm-lightbox-counter">1 / 4</span>
    </div>
  </div>
</div>

<script>
  const rajyaBaseUrl = '<?= rtrim(BASE_URL, '/') ?>';
  const rajyaItems = [
    { src: rajyaBaseUrl + '/assets/images/rajyapuraskar-2024.png', title: 'Rajyapuraskar 2024 - Governor\'s Award Certificate' },
    { src: rajyaBaseUrl + '/assets/images/rajyapuraskar-2023.png', title: 'Rajyapuraskar 2023 - Governor\'s Award Certificate' },
    { src: rajyaBaseUrl + '/assets/images/rajyapuraskar-2022.png', title: 'Rajyapuraskar 2022 - Governor\'s Award Certificate' },
    { src: rajyaBaseUrl + '/assets/images/rajyapuraskar-2019.png', title: 'Rajyapuraskar 2019 - Governor\'s Award Certificate' }
  ];
  let currentRajyaIndex = 0;

  function openRajyaLightbox(index) {
    currentRajyaIndex = index;
    updateRajyaLightbox();
    const modal = document.getElementById('mgmRajyaLightbox');
    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeRajyaLightbox() {
    const modal = document.getElementById('mgmRajyaLightbox');
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  function updateRajyaLightbox() {
    const item = rajyaItems[currentRajyaIndex];
    const img = document.getElementById('mgmLightboxImg');
    const title = document.getElementById('mgmLightboxTitle');
    const counter = document.getElementById('mgmLightboxCounter');
    
    if (img) img.src = item.src;
    if (title) title.innerText = item.title;
    if (counter) counter.innerText = (currentRajyaIndex + 1) + ' / ' + rajyaItems.length;
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

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
