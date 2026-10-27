<?php
/**
 * Counselling Centre View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "counselling-centre";
$pageTitle = "Counselling Centre";
$breadcrumbTitle = "Counselling Centre";
$metaDescription = "The Counselling Centre at MGM Model School is a dedicated platform that coordinates student advocacy and promotes mental well-being. We believe that academic success is rooted in emotional well-being. The Centre focuses on providing both individual and group counselling in a safe, confidential, and supportive environment.";

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
        <i class="fa-solid fa-comments text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Student Well-being & Facilities</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Student Advocacy & Mental Well-being</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Counselling Centre
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Nurturing Minds, Empowering Lives
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            The Counselling Centre at MGM Model School is a dedicated platform that coordinates student advocacy and promotes mental well-being. We believe that academic success is rooted in emotional well-being. The Centre focuses on providing both individual and group counselling in a safe, confidential, and supportive environment.
          </p>
        </div>
      </div>
    </div>

        <!-- Showcase Image (Exact Natural Ratio, No Cropping Frame) -->
    <div class="mb-5 text-center">
      <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/counselling-centre-clean.jpeg" 
           alt="Counselling Centre" 
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
            About Counselling Centre
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            The Counselling Centre at MGM Model School is a dedicated platform that coordinates student advocacy and promotes mental well-being. We believe that academic success is rooted in emotional well-being. The Centre focuses on providing both individual and group counselling in a safe, confidential, and supportive environment.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Our services include identifying and addressing issues such as lack of interest in studies, stress, anxiety, depression and interpersonal relationship challenges. Offering remedial and preventive support to enhance academic, personal and career development. Organizing various well-being activities, awareness programs and orientation classes for students, parents and teachers. Providing referral services to concerned experts for further support when required.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            We also leverage the CBSE tele-counselling initiative 'MANODARPAN' (Ph: 8448440632) to ensure extended care and support for our students. Because at MGM, every mind matters.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Individual and group counselling in a safe, confidential and supportive atmosphere</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Addresses academic stress, anxiety, depression and interpersonal challenges</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Conducts wellness programs, awareness seminars and orientations for students and parents</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Integrated with CBSE MANODARPAN Tele-Counselling Helpline (Ph: 8448440632)</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Core Philosophy</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Nurturing Minds, Empowering Lives (Every Mind Matters)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Services</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Individual & Group Counselling, Preventive Support</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">CBSE Helpline</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">MANODARPAN Support (Ph: 8448440632)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Confidentiality</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">100% Safe, Empathetic & Confidential</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
