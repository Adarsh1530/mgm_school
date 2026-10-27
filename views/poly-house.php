<?php
/**
 * Polyhouse - Aksharammuttathe Krishithottam View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "poly-house";
$pageTitle = "Polyhouse - Aksharammuttathe Krishithottam";
$breadcrumbTitle = "Polyhouse - Aksharammuttathe Krishithottam";
$metaDescription = "Cultivating the culture of farming among the new generation, MGM Model School, Ayiroor, Varkala has established a Hi-Tech Vegetable Garden (Polyhouse) in our campus. The Polyhouse was inaugurated by Adv. K. M. Laji, Chairman, Varkala Municipality. The inaugural function was welcomed by Principal Dr. Pooja S. and presided over by PTA President Sri. V. Haridev.";

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
        <i class="fa-solid fa-leaf text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Campus & Green Initiatives</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Hi-Tech Agriculture Initiative</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Polyhouse - Aksharammuttathe Krishithottam
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Cultivating the Culture of Farming Among the New Generation
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Cultivating the culture of farming among the new generation, MGM Model School, Ayiroor, Varkala has established a Hi-Tech Vegetable Garden (Polyhouse) in our campus. The Polyhouse was inaugurated by Adv. K. M. Laji, Chairman, Varkala Municipality. The inaugural function was welcomed by Principal Dr. Pooja S. and presided over by PTA President Sri. V. Haridev.
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
        <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg" alt="Polyhouse - Aksharammuttathe Krishithottam" class="w-100 h-100" style="object-fit: cover; min-height: 380px; max-height: 520px;">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
          <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-leaf me-1"></i> Polyhouse - Aksharammuttathe Krishithottam</span>
        </div>
      </div>
    </div>

    <!-- In-Depth Content & Factsheet -->
    <div class="row g-4 mb-5">
      <!-- Left Column: Exact Content from Document -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
          <h3 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
            <span style="width: 8px; height: 28px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
            About Polyhouse - Aksharammuttathe Krishithottam
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Cultivating the culture of farming among the new generation, MGM Model School, Ayiroor, Varkala has established a Hi-Tech Vegetable Garden (Polyhouse) in our campus. The Polyhouse was inaugurated by Adv. K. M. Laji, Chairman, Varkala Municipality. The inaugural function was welcomed by Principal Dr. Pooja S. and presided over by PTA President Sri. V. Haridev.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Felicitations were offered by Smt. Soorya, President, Elakamon Grama Panchayat and Sri. G. Anil Kumar, Assistant Agriculture Officer. Trust Secretary Dr. P. K. Sukumaran felicitated the chief guest. The function was graced by Science Club Coordinator Ms. Sini S. R. and members of the teaching faculty. With the vision of instilling the value and importance of agriculture in our students, this green initiative – Aksharammuttathe Krishithottam – was dedicated to our children, to inspire them towards farming and to nurture the promises of tomorrow.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Hi-Tech Vegetable Garden Polyhouse established on school campus</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Inaugurated by Adv. K. M. Laji, Chairman, Varkala Municipality</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Supported by Elakamon Grama Panchayat & Assistant Agriculture Officer</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Instills respect for agrarian labor, food sovereignty and sustainable cultivation</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Facility</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Hi-Tech Vegetable Garden Polyhouse</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Inaugurated By</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Adv. K. M. Laji (Chairman, Varkala Municipality)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Farming Initiative</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Aksharammuttathe Krishithottam</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Coordination</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Science Club & Agriculture Faculty</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
