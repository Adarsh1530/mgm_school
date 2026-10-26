<?php
/**
 * Exact MGM Model School Homepage View
 * Full Elementor Recreation with Interactive Autoplay Videos & National Honors
 */
require_once __DIR__ . '/../config/config.php';

$pageTitle = "Home";
$currentSlug = "";
$wpId = 1119;

require_once __DIR__ . '/../templates/header.php';

$homeHtmlPath = file_exists(__DIR__ . '/homepage_clean_extracted.html')
    ? __DIR__ . '/homepage_clean_extracted.html'
    : __DIR__ . '/../audit/homepage_clean_extracted.html';
$homeHtml = file_exists($homeHtmlPath) ? file_get_contents($homeHtmlPath) : '';

// Define Innovation Centre & Robotics Lab Section with Autoplay Video
$innovationSection = <<<'HTML'
<!-- Innovation Centre & Robotics Lab Showcase with Autoplay Video -->
<section class="mgm-innovation-section py-5" style="background: #ffffff;">
  <div class="container custom-container-larg">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge px-3 py-2 text-uppercase mb-2" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700;">World-Class Amenities</span>
        <h2 class="tp-section-title mb-3" style="font-size: 32px; font-weight: 700;">State-of-the-Art Innovation Centre &amp; AI Robotics Hub</h2>
        <p class="text-secondary mb-3">Inaugurated by the <strong>Hon'ble Governor of Kerala, Shri Arif Mohammed Khan</strong>, our Innovation Centre is equipped with cutting-edge technology and world-class amenities designed to spark curiosity, exploration, and 21st-century problem-solving skills.</p>
        
        <div class="row g-3 mb-4">
          <div class="col-sm-6">
            <div class="p-3 rounded-3 h-100" style="background: #F8FAFC; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <h6 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-robot text-danger me-2"></i>OMNIS &ndash; The MGM Robot</h6>
              <p class="text-muted small mb-0">Interactive AI-powered learning companion explaining complex concepts and making learning interactive.</p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="p-3 rounded-3 h-100" style="background: #F8FAFC; border-left: 3px solid #2563eb;">
              <h6 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-microchip text-primary me-2"></i>NOVA &ndash; The AI Hub</h6>
              <p class="text-muted small mb-0">KG Innovation Lab with Cubelets, block-based coding, and MIKO student-friendly robot.</p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="p-3 rounded-3 h-100" style="background: #F8FAFC; border-left: 3px solid #16a34a;">
              <h6 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-cube text-success me-2"></i>3D Printing &amp; Prototyping</h6>
              <p class="text-muted small mb-0">Hands-on rapid prototyping allowing student engineering designs to materialize into physical models.</p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="p-3 rounded-3 h-100" style="background: #F8FAFC; border-left: 3px solid #d97706;">
              <h6 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-vr-cardboard text-warning me-2"></i>Virtual Reality (VR) Lab</h6>
              <p class="text-muted small mb-0">Immersive experiential simulations across space astronomy, marine biology, and world geography.</p>
            </div>
          </div>
        </div>

        <a href="about-us/" class="btn btn-danger px-4 py-2 rounded-pill fw-bold" style="background: var(--tp-theme-primary, #ab0c2f); border: none;">
          Explore Campus Facilities <i class="fa-solid fa-arrow-right ms-2"></i>
        </a>
      </div>

      <div class="col-lg-6">
        <!-- Interactive Autoplay Video on Scroll with Controls -->
        <div class="mgm-video-container" data-video-wrapper>
          <video class="mgm-autoplay-video" playsinline webkit-playsinline muted loop preload="none" poster="assets/images/omnis-robot.jpeg">
            <source src="assets/videos/innovation-centre.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
          </video>
          <div class="mgm-video-controls-overlay">
            <div class="mgm-video-btn-group">
              <button type="button" class="mgm-video-ctrl-btn mgm-btn-mute" aria-label="Unmute Video">
                <i class="fa-solid fa-volume-xmark"></i> <span class="mgm-btn-label">Unmute</span>
              </button>
            </div>
            <div class="mgm-video-badge">
              <span class="mgm-video-badge-dot"></span>
              <span>Innovation Centre Tour</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- National Honors & Presidential Recognition Section -->
<section class="mgm-national-awards-section py-5" style="background: linear-gradient(135deg, #FFF9FA 0%, #F5F7FB 100%); border-top: 1px solid #F0E6E8; border-bottom: 1px solid #F0E6E8;">
  <div class="container custom-container-larg">
    <div class="text-center mb-4">
      <span class="badge px-3 py-2 text-uppercase mb-2" style="background: var(--tp-theme-primary, #ab0c2f); color: #fff; font-size: 11px; letter-spacing: 1px;">National Distinction &amp; Excellence</span>
      <h2 class="tp-section-title" style="font-size: 32px; font-weight: 700;">National Honors &amp; Presidential Recognition</h2>
      <p class="text-muted mx-auto" style="max-width: 650px;">Celebrating historic benchmarks achieved by MGM Model School on prestigious national platforms.</p>
    </div>
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
          <div class="position-relative">
            <img src="assets/images/water-award-2024.jpeg" alt="National Water Award 2024" class="w-100" style="height: 280px; object-fit: cover;">
            <span class="position-absolute top-0 start-0 m-3 badge bg-primary px-3 py-2 shadow-sm">Ministry of Jal Shakti</span>
          </div>
          <div class="card-body p-4">
            <h4 class="card-title fw-bold text-dark mb-2">6th National Water Award 2024</h4>
            <p class="text-secondary small mb-3">MGM Model School, Ayiroor, Varkala has been conferred with a <strong>Special Mention &ndash; Best School/College Category</strong> at the 6th National Water Awards 2024 by the Ministry of Jal Shakti, Government of India. Selected from 751 schools and colleges across India, the honour was presented at Vigyan Bhawan, New Delhi on 18th November 2025 in the august presence of Hon'ble President of India Smt. Droupadi Murmu. Principal Dr. Pooja S received the award from Hon'ble Union Minister Shri C. R. Paatil for our campus Rainwater Harvesting system and 36 conservation pits replenishing the groundwater table.</p>
            <div class="d-flex align-items-center gap-2 text-muted small">
              <i class="fa-solid fa-trophy text-warning"></i> Selected from 751 schools &amp; colleges across India &bull; Vigyan Bhawan, New Delhi (18 Nov 2025)
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
          <div class="position-relative">
            <img src="assets/images/national-principal-award-2025.jpeg" alt="National Principal Award 2025" class="w-100" style="height: 280px; object-fit: cover;">
            <span class="position-absolute top-0 start-0 m-3 badge bg-danger px-3 py-2 shadow-sm">National Principal Award</span>
          </div>
          <div class="card-body p-4">
            <h4 class="card-title fw-bold text-dark mb-2">Dr. Sarvepalli Radhakrishnan National Principal Award 2025</h4>
            <p class="text-secondary small mb-3">Conferred upon Principal <strong>Dr. Pooja S</strong> by Dr. Subramanyam Sharma, grandson of Bharat Ratna Dr. S. Radhakrishnan (former President of India), at the Grand Conclave held on 22nd August 2025 at Neo Convention, Janwada, Hyderabad. This esteemed national honour recognizes her visionary leadership, exceptional contributions to empowering 21st-century learners, transformative pedagogy, and elevating MGM Model School to new heights of excellence.</p>
            <div class="d-flex align-items-center gap-2 text-muted small">
              <i class="fa-solid fa-medal text-danger"></i> Grand Conclave, Neo Convention, Hyderabad (22 Aug 2025) &bull; Visionary Leadership
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
HTML;

// Inject before testimonials section
$target = '<div class="elementor-element elementor-element-e1419c7 e-con-full e-flex e-con e-parent" data-id="e1419c7"';
if (strpos($homeHtml, $target) !== false) {
    $renderedHome = str_replace($target, $innovationSection . "\n" . $target, $homeHtml);
} else {
    $renderedHome = $homeHtml . "\n" . $innovationSection;
}

// Build Entrance Scrolling News Ticker
$tickerNotices = get_ticker_notices();
$tickerItemsHtml = '';
for ($loop = 0; $loop < 2; $loop++) {
    foreach ($tickerNotices as $tNotice) {
        $slug = htmlspecialchars($tNotice['slug']);
        $cat = htmlspecialchars($tNotice['category']);
        $title = htmlspecialchars($tNotice['title']);
        $date = htmlspecialchars($tNotice['display_date']);
        $tickerItemsHtml .= <<<HTML
<a href="notices/#notice-{$slug}" class="mgm-ticker-item">
  <span class="mgm-ticker-cat">{$cat}</span>
  <span class="mgm-ticker-text">{$title}</span>
  <span class="mgm-ticker-date"><i class="fa-regular fa-calendar-days me-1"></i>{$date}</span>
  <span class="mgm-ticker-sep">&bull;</span>
</a>
HTML;
    }
}

$tickerSection = <<<HTML
<!-- Entrance Scrolling News Ticker -->
<div class="mgm-ticker-wrapper">
  <div class="container custom-container-larg">
    <div class="mgm-news-ticker-container" role="region" aria-label="Latest Announcements">
      <div class="mgm-ticker-label">
        <span class="mgm-ticker-pill">
          <i class="fa-solid fa-bullhorn text-warning me-1"></i> NOTICES
        </span>
      </div>
      <div class="mgm-ticker-track-wrapper">
        <div class="mgm-ticker-track">
          {$tickerItemsHtml}
        </div>
      </div>
      <a href="notices/" class="mgm-ticker-viewall d-none d-md-flex align-items-center gap-1" title="View All Notices">
        <span>View All</span>
        <i class="fa-solid fa-arrow-right"></i>
      </a>
    </div>
  </div>
</div>
HTML;

// Inject Ticker before the 4 service cards container
$targetServices = '<div class="elementor-element elementor-element-e388438 e-con-full e-flex e-con e-parent e-lazyloaded"';
if (strpos($renderedHome, $targetServices) !== false) {
    $renderedHome = str_replace($targetServices, $tickerSection . "\n" . $targetServices, $renderedHome);
}
?>

<?= render_content($renderedHome) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
