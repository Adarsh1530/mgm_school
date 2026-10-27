<?php
/**
 * 3D Maths Zone View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "3d-max-zone";
$pageTitle = "3D Maths Zone";
$breadcrumbTitle = "3D Maths Zone";
$metaDescription = "Our outdoor 3D Maths Zone turns abstract concepts into a hands-on experience. At MGM Model School, we believe learning is best when it can be seen, touched and experienced. Set within the school campus, this interactive zone features large, vividly coloured 3D models of solid shapes including Triangular Pyramid, Square Pyramid, Pentagonal Pyramid, Hexagonal Pyramid, Cubes, Rectangular Prisms, Frustum of a Cone, Cones and more.";

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
        <i class="fa-solid fa-cube text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Academic & Innovation</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Outdoor Interactive Geometry</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            3D Maths Zone
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Where Maths Comes to Life
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            Our outdoor 3D Maths Zone turns abstract concepts into a hands-on experience. At MGM Model School, we believe learning is best when it can be seen, touched and experienced. Set within the school campus, this interactive zone features large, vividly coloured 3D models of solid shapes including Triangular Pyramid, Square Pyramid, Pentagonal Pyramid, Hexagonal Pyramid, Cubes, Rectangular Prisms, Frustum of a Cone, Cones and more.
          </p>
        </div>
      </div>
    </div>

    <!-- Featured Video Frame (Exact School Highlights Standard) -->
    <div class="mb-5">
      <div class="mgm-video-container" data-video-wrapper>
        <video class="mgm-autoplay-video" playsinline webkit-playsinline muted loop preload="none" poster="<?= rtrim(BASE_URL, '/') ?>/assets/images/maths-zone-3d.jpeg">
          <source src="<?= rtrim(BASE_URL, '/') ?>/assets/videos/3d-max-zone.mp4" type="video/mp4">
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
            <span>3D MATHS ZONE TOUR</span>
          </div>
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
            About 3D Maths Zone
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Our outdoor 3D Maths Zone turns abstract concepts into a hands-on experience. At MGM Model School, we believe learning is best when it can be seen, touched and experienced. Set within the school campus, this interactive zone features large, vividly coloured 3D models of solid shapes including Triangular Pyramid, Square Pyramid, Pentagonal Pyramid, Hexagonal Pyramid, Cubes, Rectangular Prisms, Frustum of a Cone, Cones and more.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Each model is mounted on a pedestal that clearly displays its properties – Faces, Vertices, Edges, and the Euler's formula (F+V-E), along with Lateral Surface Area, Total Surface Area and Volume – making learning spontaneous and engaging.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            Instead of just memorizing formulas from a textbook, students walk through geometry, observe, count and correlate. It fosters spatial intelligence, logical reasoning and a genuine love for Mathematics from the foundational years.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Large, vividly coloured outdoor 3D solid shape models across campus</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Includes Triangular/Square/Pentagonal/Hexagonal Pyramids, Cubes, Prisms & Cones</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Pedestals display Faces, Vertices, Edges, Euler's formula (F+V-E), Surface Area & Volume</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Builds spatial intelligence and logical reasoning by seeing, touching and experiencing</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Zone Type</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Outdoor Hands-On 3D Mathematics Laboratory</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Models Featured</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Pyramids, Cubes, Prisms, Frustums, Cones & Spheres</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Displayed Formulas</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Faces, Vertices, Edges, Euler's Formula, LSA, TSA & Volume</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Pedagogical Goal</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Walk Through Geometry: Observe, Count & Correlate</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Campus Installation Photo Gallery -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center mb-5">
      <h4 class="fw-bold text-dark mb-4 d-flex align-items-center justify-content-center gap-2">
        <i class="fa-solid fa-camera text-danger"></i> Campus 3D Geometry Installation
      </h4>
      <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/maths-zone-3d.jpeg" 
           alt="3D Maths Zone Campus Installation" 
           class="img-fluid rounded-4 shadow-sm" 
           style="max-width: 100%; height: auto; max-height: 600px; object-fit: contain; display: inline-block;">
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
