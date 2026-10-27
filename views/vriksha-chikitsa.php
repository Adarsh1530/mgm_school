<?php
/**
 * Vriksha Chikitsa View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "vriksha-chikitsa";
$pageTitle = "Vriksha Chikitsa";
$breadcrumbTitle = "Vriksha Chikitsa";
$metaDescription = "In the year 2024, MGM Model School, Ayiroor, Varkala took a unique step towards environmental conservation by organizing a &quot;Vriksha Chikitsa&quot; – Traditional Ayurvedic Tree Treatment project in our campus.";

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
        <i class="fa-solid fa-tree text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Campus & Green Initiatives</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Traditional Eco-Conservation</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Vriksha Chikitsa
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Healing Nature the Ayurvedic Way
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            In the year 2024, MGM Model School, Ayiroor, Varkala took a unique step towards environmental conservation by organizing a "Vriksha Chikitsa" – Traditional Ayurvedic Tree Treatment project in our campus.
          </p>
        </div>
      </div>
    </div>

        <!-- Featured Video Frame (Exact Homepage Video Frame) -->
    <div class="mb-5">
      <div class="mgm-video-container" data-video-wrapper>
        <video class="mgm-autoplay-video" playsinline webkit-playsinline muted loop preload="none" poster="<?= rtrim(BASE_URL, '/') ?>/assets/images/polyhouse-garden.jpeg">
          <source src="<?= rtrim(BASE_URL, '/') ?>/assets/videos/vriksha-chikitsa.mp4" type="video/mp4">
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
            <span>VRIKSHA CHIKITSA PROJECT</span>
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
            About Vriksha Chikitsa
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            In the year 2024, MGM Model School, Ayiroor, Varkala took a unique step towards environmental conservation by organizing a "Vriksha Chikitsa" – Traditional Ayurvedic Tree Treatment project in our campus.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            The program was led by renowned tree healer and environmental activist Shri. K. Binu, popularly known as Vriksha Vaidyan or 'Tree Doctor'. The Kerala-based Tree Doctor enlightened our students about the meticulous process involved in the preparation of Ayurvedic medicines for healing injured trees. As part of this green initiative, we invited Shri. Binu and his team to treat and rejuvenate our beloved jackfruit tree, aged over 40 years, standing tall in our campus. The ancient Ayurvedic healing ritual gave our children a rare and inspiring lesson on compassion, conservation and co-existing with nature.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Led by renowned tree healer Shri. K. Binu (popularly known as Vriksha Vaidyan / 'Tree Doctor')</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Hands-on demonstration of traditional Ayurvedic medicine preparation for plants</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Rejuvenation of campus 40+ year-old heritage jackfruit tree</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Inspiring practical lesson on compassion, conservation and co-existing with nature</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Project Year</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Organized in 2024</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Conducted By</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Shri. K. Binu (Tree Doctor / Vriksha Vaidyan)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Heritage Flora</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">40+ Year-Old Campus Jackfruit Tree</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Methodology</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Classical Ayurvedic Tree Healing Rituals</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
