<?php
/**
 * National Cadet Corps (NCC &ndash; Army Wing) View
 * MGM Model School Campus Highlights
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "ncc";
$pageTitle = "NCC";
$breadcrumbTitle = "NCC";
$metaDescription = "Premier Junior Division National Cadet Corps wing instilling patriotism, military discipline, leadership character, physical endurance, and selfless service.";

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
        <i class="fa-solid fa-person-military-pointing text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Skills & Cadet Corps</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Patriotism, Character & Military Discipline</span>
          </div>
          <h1 class="fw-bold text-dark mb-3" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            National Cadet Corps (NCC &ndash; Army Wing)
          </h1>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Premier Junior Division National Cadet Corps wing instilling patriotism, military discipline, leadership character, physical endurance, and selfless service.
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
        <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/ncc-unit-1.jpeg" alt="NCC" class="w-100 h-100" style="object-fit: cover; min-height: 380px; max-height: 520px;">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
          <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-person-military-pointing me-1"></i> NCC</span>
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
            The National Cadet Corps (NCC) Army Wing at MGM Model School operates under 1 Kerala Battalion, nurturing patriotic, courageous, and disciplined leaders of tomorrow. Under the guidance of our Associate NCC Officer Retd. Subedar Major Rajesh S, cadets undergo systematic rifle drills, physical obstacle courses, map reading, and national integration camps, building indomitable character and teamwork.
          </p>

          <!-- Core Pillars Grid -->
          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Features &amp; Student Advantages</h4>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-person-military-rifle fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">1 Kerala Battalion Army Wing</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Officially affiliated Junior Division unit adhering strictly to Indian Army training protocols, ceremonial drills, and discipline.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-tents fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Combined Annual Training Camps</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Cadets represent the school in rigorous outdoor camps (CATC), firing simulations, obstacle courses, and national integration expeditions.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-hand-holding-hand fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Community Leadership & Service</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Pioneering blood donation drives, coastal clean-up expeditions, road safety awareness, and disaster relief preparedness rallies.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-medal fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Defense & Civil Service Gateway</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Earns official NCC 'A' certification conferring valuable bonus weighting in NDA, CDS, defense forces, and collegiate admissions.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Factsheet -->
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 bg-white h-100">
          <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
            <i class="fa-solid fa-list-check text-danger"></i> Facility Highlights at a Glance
          </h5>
          <div class="d-flex flex-column gap-3">
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Unit Affiliation</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">1 Kerala Battalion NCC (Army Wing)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Active Cadets</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">100+ Enrolled Cadets (Junior Division)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Officer Lead</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Retd. Subedar Major Rajesh S (Associate NCC Officer)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Certification</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Official NCC 'A' Certificate on Course Completion</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
