<?php
/**
 * Aksharammuttathe Krishithottam View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "krishi-thottam";
$pageTitle = "Aksharammuttathe Krishithottam";
$breadcrumbTitle = "Aksharammuttathe Krishithottam";
$metaDescription = "With the vision of instilling the value and importance of agriculture in our students, this green initiative – Aksharammuttathe Krishithottam – was dedicated to our children, to inspire them towards farming and to nurture the promises of tomorrow.";

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
        <i class="fa-solid fa-seedling text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Campus & Green Initiatives</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Campus Green Agriculture</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Aksharammuttathe Krishithottam
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Inspiring Students Towards Farming & Nurturing the Promises of Tomorrow
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            With the vision of instilling the value and importance of agriculture in our students, this green initiative – Aksharammuttathe Krishithottam – was dedicated to our children, to inspire them towards farming and to nurture the promises of tomorrow.
          </p>
        </div>
      </div>
    </div>

        <!-- Showcase Image (Exact Natural Ratio, No Cropping Frame) -->
    <div class="mb-5 text-center">
      <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg" 
           alt="Aksharammuttathe Krishithottam" 
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
            About Aksharammuttathe Krishithottam
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            With the vision of instilling the value and importance of agriculture in our students, this green initiative – Aksharammuttathe Krishithottam – was dedicated to our children, to inspire them towards farming and to nurture the promises of tomorrow.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Cultivating the culture of farming among the new generation, MGM Model School, Ayiroor, Varkala has established a Hi-Tech Vegetable Garden (Polyhouse) in our campus. The inaugural function was welcomed by Principal Dr. Pooja S. and presided over by PTA President Sri. V. Haridev. Felicitations were offered by Smt. Soorya, President, Elakamon Grama Panchayat and Sri. G. Anil Kumar, Assistant Agriculture Officer. Trust Secretary Dr. P. K. Sukumaran felicitated the chief guest.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Dedicated campus vegetable cultivation connecting students to nature</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Encourages organic agriculture and sustainable green habits</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Active mentorship from Agricultural Officers and Science Club teachers</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Nurtures environmental consciousness and practical farming skills</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Green Initiative</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Aksharammuttathe Krishithottam</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Campus Facility</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Hi-Tech Vegetable Garden Polyhouse</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Key Dignitaries</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Varkala Municipality Chairman & Elakamon Panchayat President</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Core Vision</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Inspiring Children Towards Sustainable Farming</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
