<?php
/**
 * Happiness Room View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "happiness-room";
$pageTitle = "Happiness Room";
$breadcrumbTitle = "Happiness Room";
$metaDescription = "Pause. Create. Express. Shine.";

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
        <i class="fa-solid fa-face-smile text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Student Well-being & Facilities</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Pause. Create. Express. Shine.</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Happiness Room
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Where Minds Relax, Creativity Blooms and Talents Shine
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Pause. Create. Express. Shine.
          </p>
        </div>
      </div>
    </div>

        <!-- Showcase Image (Exact Natural Ratio, No Cropping Frame) -->
    <div class="mb-5 text-center">
      <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/happiness-room-clean.jpeg" 
           alt="Happiness Room" 
           class="img-fluid rounded-4 shadow-sm" 
           style="max-width: 100%; height: auto; max-height: 640px; object-fit: contain; display: inline-block;">
    </div>

    <!-- In-Depth Content & Factsheet -->
    <div class="row g-4 mb-5">
      <!-- Left Column: Exact Content from Document -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
          <h3 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
            <span style="width: 8px; height: 28px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
            About Happiness Room
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Pause. Create. Express. Shine.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            At MGM Model School, the Happiness Room is a vibrant space designed to make free time more meaningful and joyful.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            It is a welcoming haven where students can read, create, express themselves, discover their talents and unwind. With dedicated zones for reading, creativity and relaxation, it encourages every student to pause, explore their interests, and nurture their well-being.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            A space to be yourself. A space to discover yourself.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Dedicated zones for reading, creative arts and sensory relaxation</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Designed to make free intervals meaningful, joyful and rejuvenating</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Encourages students to discover talents, express themselves and unwind</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">A welcoming sanctuary: 'A space to be yourself. A space to discover yourself.'</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Motto</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Pause. Create. Express. Shine.</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Dedicated Zones</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Reading Zone, Creativity Corner & Relaxation Space</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Purpose</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Mental Unwinding, Well-being & Talent Discovery</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Philosophy</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">A Space to Be Yourself, A Space to Discover Yourself</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
