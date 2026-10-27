<?php
/**
 * Hindustan Scouts and Guides Troop View
 * MGM Model School Campus Highlights
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "hindustan-scouts-guides";
$pageTitle = "Hindustan Scouts and Guides";
$breadcrumbTitle = "Hindustan Scouts and Guides";
$metaDescription = "Prestigious troop decorated with multiple Rajya Puraskar Governor Awards, mastering wilderness outdoor survival, civic duty, first-aid, and leadership.";

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
        <i class="fa-solid fa-award text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Skills & Cadet Corps</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">State-Decorated Rajya Puraskar Troop</span>
          </div>
          <h1 class="fw-bold text-dark mb-3" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Hindustan Scouts and Guides Troop
          </h1>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Prestigious troop decorated with multiple Rajya Puraskar Governor Awards, mastering wilderness outdoor survival, civic duty, first-aid, and leadership.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="<?= rtrim(BASE_URL, '/') ?>/contact/" class="btn btn-danger rounded-pill px-4 py-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-calendar-check"></i> Book Campus Tour
          </a>
        </div>
      </div>
    </div>

    <!-- Featured High-Resolution Showcase Image -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
      <div class="position-relative" style="max-height: 520px; overflow: hidden;">
        <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/scouts-and-guides.jpeg" alt="Hindustan Scouts and Guides" class="w-100 h-100" style="object-fit: cover; min-height: 380px; max-height: 520px;">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
          <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-award me-1"></i> Hindustan Scouts and Guides</span>
        </div>
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
            As part of our commitment to moral fortitude and selfless civic duty, MGM Model School has partnered with Hindustan Scouts and Guides Kerala since 2019. Led by certified Scout Master Mr. Pravin S R, our troop of 104 active cadets is celebrated as one of the state's most distinguished. Notably, 45 cadets have won the prestigious Rajyapuraskar (Governor's Award) across successive state rallies.
          </p>

          <!-- Core Pillars Grid -->
          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Features &amp; Student Advantages</h4>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-trophy fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">45 Rajyapuraskar Governor Awards</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Honored by the Hon'ble Governor of Kerala for exemplary wilderness survival, civic leadership, and state jamboree performance.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-compass fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Wilderness Outdoor Survival</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Mastery of pioneering knot-tying, tracking, compass navigation, bridge construction, and bivouac tent pitching.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-kit-medical fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Emergency First Aid & Rescue</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Comprehensive disaster response training: CPR, stretcher fabrication, bandaging, and community emergency management.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-fire fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Campfire Brotherhood & Civic Duty</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Instills the timeless Scout Law: trustworthiness, loyalty, courtesy, cleanliness, and dedication to God and country.</p>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Active Membership</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">104 Active Cadets (1 Troop, 1 Guide Co, 1 Rover-Ranger Unit)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Governor Laureates</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">45 Prestigious Rajyapuraskar Award Winners</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Scout Master Lead</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Mr. Pravin S R (Certified Scout Master)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">State Rallies</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Consecutive Honors in 2019, 2022, 2023, and 2024</strong>
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
          <h3 class="fw-bold text-white mb-2">Witness Hindustan Scouts and Guides in Person</h3>
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
