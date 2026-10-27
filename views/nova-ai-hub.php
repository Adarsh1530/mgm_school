<?php
/**
 * NOVA – The AI HUB View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "nova-ai-hub";
$pageTitle = "NOVA – The AI HUB";
$breadcrumbTitle = "NOVA – The AI HUB";
$metaDescription = "NOVA is our KG Innovation Lab, where our youngest learners explore technology through fun and hands-on activities. The lab features Cubelets for building small robots, block-based coding to introduce programming in a simple and engaging way, and MIKO – a student-friendly robot that interacts with children and supports their learning.";

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
        <i class="fa-solid fa-microchip text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Academic & Innovation</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Junior AI & Robotics Lab</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            NOVA – The AI HUB
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            KG Innovation Lab for Young Learners
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            NOVA is our KG Innovation Lab, where our youngest learners explore technology through fun and hands-on activities. The lab features Cubelets for building small robots, block-based coding to introduce programming in a simple and engaging way, and MIKO – a student-friendly robot that interacts with children and supports their learning.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="<?= rtrim(BASE_URL, '/') ?>/contact/" class="btn btn-danger rounded-pill px-4 py-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-calendar-check"></i> Book Campus Tour
          </a>
        </div>
      </div>
    </div>

    <!-- Featured Video Showcase -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark">
      <div class="p-3 bg-dark border-bottom border-secondary d-flex align-items-center justify-content-between text-white flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-danger px-2 py-1"><i class="fa-solid fa-circle-play me-1"></i> VIDEO SHOWCASE</span>
          <strong class="text-white small text-uppercase" style="letter-spacing: 0.5px;">NOVA – The AI HUB &bull; MGM Model School</strong>
        </div>
        <span class="badge bg-light text-dark small"><i class="fa-solid fa-video me-1"></i> High Definition MP4</span>
      </div>
      <div class="p-2 p-md-4 text-center bg-black">
        <video id="highlightVideo_nova_ai_hub" 
               class="w-100 rounded-3 shadow" 
               controls 
               playsinline 
               preload="metadata" 
               poster="<?= rtrim(BASE_URL, '/') ?>/assets/images/1756461341.jpg"
               style="max-height: 560px; object-fit: contain; background: #000;">
          <source src="<?= rtrim(BASE_URL, '/') ?>/assets/videos/nova-ai-hub.mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
      </div>
      <div class="p-3 bg-white text-muted small border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span><i class="fa-solid fa-circle-info text-danger me-1"></i> Official demonstration &bull; MGM Model School, Ayiroor, Varkala</span>
        <span class="badge bg-light text-secondary border">Academic Year 2025-2026</span>
      </div>
    </div>

    <!-- In-Depth Content & Factsheet -->
    <div class="row g-4 mb-5">
      <!-- Left Column: Exact Content from Document -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
          <h3 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
            <span style="width: 8px; height: 28px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
            About NOVA – The AI HUB
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            NOVA is our KG Innovation Lab, where our youngest learners explore technology through fun and hands-on activities. The lab features Cubelets for building small robots, block-based coding to introduce programming in a simple and engaging way, and MIKO – a student-friendly robot that interacts with children and supports their learning.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            NOVA encourages students to explore, create and experiment, while developing creativity, logical thinking and problem-solving skills from an early age.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Cubelets modular magnetic robotics for building small autonomous robots</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Block-based coding introducing programming logic in an engaging, simple format</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">MIKO student-friendly interactive learning companion robot</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Develops creativity, logical algorithmic thinking and problem-solving early</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Lab Identity</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">NOVA - Kindergarten Innovation Lab</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Robotics Hardware</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Cubelets Modular Robot Blocks</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Interactive AI</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">MIKO Student-Friendly Companion Robot</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Coding Pedagogy</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Fun, Tangible Block-Based Programming</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
