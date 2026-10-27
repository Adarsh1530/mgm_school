<?php
/**
 * Governor-Inaugurated Innovation Centre View
 * MGM Model School Campus Highlights
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "innovation-centre";
$pageTitle = "Innovation Centre";
$breadcrumbTitle = "Innovation Centre";
$metaDescription = "Inaugurated by the Hon'ble Governor of Kerala Shri Arif Mohammed Khan, this cutting-edge facility unites robotics, IoT electronics, 3D prototyping, and design thinking.";

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="highlight-detail-page py-5" style="background: #FAF8F5; min-height: 100vh;">
  <div class="container custom-container-larg">

    <!-- Top Navigation Return & Category Pill -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
      <a href="<?= rtrim(BASE_URL, '/') ?>/highlights/" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Back to All Highlights
      </a>
      <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white shadow-sm border">
        <i class="fa-solid fa-flask-vial text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Academic & Innovation</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Governor-Inaugurated Maker Space</span>
          </div>
          <h1 class="fw-bold text-dark mb-3" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Governor-Inaugurated Innovation Centre
          </h1>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Inaugurated by the Hon'ble Governor of Kerala Shri Arif Mohammed Khan, this cutting-edge facility unites robotics, IoT electronics, 3D prototyping, and design thinking.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="<?= rtrim(BASE_URL, '/') ?>/contact/" class="btn btn-danger rounded-pill px-4 py-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-calendar-check"></i> Book Campus Tour
          </a>
        </div>
      </div>
    </div>

    <!-- Featured Video Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark">
      <div class="p-3 bg-dark border-bottom border-secondary d-flex align-items-center justify-content-between text-white flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-danger px-2 py-1"><i class="fa-solid fa-circle-play me-1"></i> VIDEO SHOWCASE</span>
          <strong class="text-white small text-uppercase" style="letter-spacing: 0.5px;">Innovation Centre in Action &bull; MGM Model School</strong>
        </div>
        <span class="badge bg-light text-dark small"><i class="fa-solid fa-video me-1"></i> High Definition MP4</span>
      </div>
      <div class="p-2 p-md-4 text-center bg-black">
        <video id="highlightVideo_innovation_centre" 
               class="w-100 rounded-3 shadow" 
               controls 
               playsinline 
               preload="metadata" 
               poster="<?= rtrim(BASE_URL, '/') ?>/assets/images/1756461341.jpg"
               style="max-height: 560px; object-fit: contain; background: #000;">
          <source src="<?= rtrim(BASE_URL, '/') ?>/assets/videos/innovation-centre.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
      </div>
      <div class="p-3 bg-white text-muted small border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span><i class="fa-solid fa-circle-info text-danger me-1"></i> Official demonstration &bull; MGM Model School, Ayiroor, Varkala</span>
        <span class="badge bg-light text-secondary border">Academic Year 2025-2026</span>
      </div>
    </div>

    <!-- In-Depth Overview & Key Pillars -->
    <div class="row g-4 mb-5">
      <!-- Left Column: Detailed Overview -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
          <h3 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
            <span style="width: 8px; height: 28px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
            Educational Vision &amp; Facility Overview
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            The MGM Innovation Centre represents our commitment to hands-on invention and technology creation. Dignified by the inaugural visit of the Hon'ble Governor of Kerala Shri Arif Mohammed Khan, the center is equipped with high-precision 3D printers, microcontroller kits, sensory apparatus, and electronic fabrication benches. Students transform imaginative concepts into working prototypes.
          </p>

          <!-- Core Pillars Grid -->
          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Features &amp; Student Advantages</h4>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-cube fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">3D Printing & Rapid Prototyping</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Students design CAD models and watch them materialize into tangible plastic prototypes using industrial 3D printers.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-microchip fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">IoT & Embedded Robotics</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Hands-on development with Arduino, Raspberry Pi, ultrasonic sensors, motors, and smart home automation breadboards.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-lightbulb fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Design Thinking Framework</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Mentored stages of empathy, problem definition, ideation, prototyping, and testing applied to real social challenges.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-trophy fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">National Competition Mentorship</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Dedicated coaching for student delegations competing in CBSE Science Exhibitions, Atal Tinkering Marathons, and Robotics Expos.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Factsheet & Gallery -->
      <div class="col-lg-5">
        <!-- Quick Factsheet Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 bg-white mb-4">
          <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
            <i class="fa-solid fa-list-check text-danger"></i> Facility Highlights at a Glance
          </h5>
          <div class="d-flex flex-column gap-3">
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Inaugural Dignitary</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Shri Arif Mohammed Khan (Hon'ble Governor of Kerala)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Key Equipment</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Industrial 3D Printers, Soldering Benches & IoT Kits</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Student Programs</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Robotics Club, STEM Olympiads & Invention Labs</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Target Grades</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Middle & Senior Secondary (Grades 6 to 12)</strong>
            </div>
          </div>
        </div>

        <!-- Related Highlights Links -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
          <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
            <i class="fa-solid fa-compass text-primary"></i> Explore Other Highlights
          </h5>
          <div class="d-flex flex-column gap-2">
            <a href="<?= rtrim(BASE_URL, '/') ?>/swimming-pool/" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none border bg-light text-dark hover-shadow transition">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/swimming-pool-1.jpeg" alt="Swimming Pool" class="rounded-2" style="width: 50px; height: 50px; object-fit: cover;">
              <div class="flex-grow-1">
                <strong class="d-block small">Swimming Pool</strong>
                <span class="text-muted" style="font-size: 11px;">Student Well-being & Facilities</span>
              </div>
              <i class="fa-solid fa-chevron-right text-muted small me-2"></i>
            </a>
            <a href="<?= rtrim(BASE_URL, '/') ?>/twenty-twenty-method/" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none border bg-light text-dark hover-shadow transition">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/1741692636.jpeg" alt="20-20 Method of Teaching" class="rounded-2" style="width: 50px; height: 50px; object-fit: cover;">
              <div class="flex-grow-1">
                <strong class="d-block small">20-20 Method of Teaching</strong>
                <span class="text-muted" style="font-size: 11px;">Academic & Innovation</span>
              </div>
              <i class="fa-solid fa-chevron-right text-muted small me-2"></i>
            </a>
            <a href="<?= rtrim(BASE_URL, '/') ?>/libraries-at-mgm/" class="d-flex align-items-center gap-3 p-2 rounded-3 text-decoration-none border bg-light text-dark hover-shadow transition">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/libraries-1.jpeg" alt="Libraries at MGM" class="rounded-2" style="width: 50px; height: 50px; object-fit: cover;">
              <div class="flex-grow-1">
                <strong class="d-block small">Libraries at MGM</strong>
                <span class="text-muted" style="font-size: 11px;">Academic & Innovation</span>
              </div>
              <i class="fa-solid fa-chevron-right text-muted small me-2"></i>
            </a>
          </div>
          <div class="mt-3 pt-3 border-top text-center">
            <a href="<?= rtrim(BASE_URL, '/') ?>/highlights/" class="fw-bold text-danger text-decoration-none small">
              View All 21 Campus Highlights <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- Interactive CTA Section -->
    <div class="card border-0 rounded-4 p-4 p-md-5 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #141B2B 0%, #2A1724 50%, #800000 100%);">
      <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-lg-8">
          <span class="badge bg-danger mb-2 px-3 py-1">Experience MGM Model School</span>
          <h3 class="fw-bold text-white mb-2">Witness Innovation Centre in Person</h3>
          <p class="text-light mb-0" style="opacity: 0.9; font-size: 15px;">
            Book a guided campus tour or schedule an interactive counseling consultation to explore our comprehensive infrastructure and academic opportunities.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
            <a href="<?= rtrim(BASE_URL, '/') ?>/contact/" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-dark shadow-sm">
              Contact Admissions
            </a>
            <a href="<?= rtrim(BASE_URL, '/') ?>/admission-procedure/" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold">
              Admission Details
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
