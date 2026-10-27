<?php
/**
 * Ceremonial School Band Troop View
 * MGM Model School Campus Highlights
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "school-band-troop";
$pageTitle = "School Band Troop";
$breadcrumbTitle = "School Band Troop";
$metaDescription = "Ceremonial marching brass and percussion band troop performing synchronized drills, patriotic anthems, and martial salutes with precision.";

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
        <i class="fa-solid fa-drum text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Skills & Cadet Corps</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Ceremonial Marching Brass & Percussion</span>
          </div>
          <h1 class="fw-bold text-dark mb-3" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Ceremonial School Band Troop
          </h1>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Ceremonial marching brass and percussion band troop performing synchronized drills, patriotic anthems, and martial salutes with precision.
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
        <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/investiture-ceremony.jpeg" alt="School Band Troop" class="w-100 h-100" style="object-fit: cover; min-height: 380px; max-height: 520px;">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
          <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-drum me-1"></i> School Band Troop</span>
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
            The ceremonial drumbeat and brass fanfare of the MGM Model School Band Troop elevate every solemn campus assembly. Dressed in striking ceremonial regalia with embroidered sashes, our band members undergo rigorous rhythmic drill practice. The troop leads all school investitures, annual sports meets, Independence Day parades, and honors visiting state dignitaries with crisp martial salutes.
          </p>

          <!-- Core Pillars Grid -->
          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Features &amp; Student Advantages</h4>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-drum fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Marching Percussion & Brass Ensemble</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Trained on bass drums, side snare drums, tenor drums, bugles, cymbals, and glockenspiel xylophones.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-person-walking fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Synchronized Marching Drill Formations</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Performing disciplined field manoeuvres, countermarches, and complex formation changes with impeccable spatial precision.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-flag fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Ceremonial Honors for Dignitaries</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Providing guard of honor fanfares and ceremonial national anthem salutes during gubernatorial and state visits.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-music fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Teamwork, Rhythm & Confidence</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Fosters collective synchronization, musical ear training, leadership character, and unshakeable stage poise.</p>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Instrumentation</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Side Snare Drums, Bass Drums, Bugles, Cymbals & Glockenspiels</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Ceremonial Regalia</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Official School Uniform with Epaulettes, Sashes & Plumes</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Key Performances</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Investiture Ceremony, Annual Sports Meet, Independence Day</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Student Leadership</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Band Major & Section Captains Leading Formations</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
