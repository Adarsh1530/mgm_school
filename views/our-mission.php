<?php
/**
 * Our Mission View
 * MGM Model School Recreation Project - Official School Vision & Mission
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "our-mission";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Our Mission";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "Official Vision and Mission of MGM Model School, Ayiroor, Varkala.";
$wpId = 15908;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="tp-subpage-container py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Section Header -->
    <div class="text-center mb-5">
      <span class="badge px-3 py-2 text-uppercase mb-2" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700;">Guiding Philosophy</span>
      <h2 class="tp-section-title" style="font-size: 34px; font-weight: 700; color: #141B2B;">Vision &amp; Mission of MGM Model School</h2>
      <p class="text-muted mx-auto" style="max-width: 680px; font-size: 16px;">Nurturing young minds towards academic distinction, ethical integrity, and visionary leadership since 1983.</p>
    </div>

    <!-- Vision & Mission Cards Row -->
    <div class="row g-4 mb-5 align-items-stretch">
      
      <!-- Vision Card -->
      <div class="col-lg-6">
        <div class="h-100 p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border-top: 4px solid var(--tp-theme-primary, #ab0c2f);">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); display: flex; align-items: center; justify-content: center; font-size: 22px;">
              <i class="fa-solid fa-eye"></i>
            </div>
            <h3 class="mb-0 fw-bold" style="font-size: 24px; color: #141B2B;">School Vision</h3>
          </div>
          <p class="text-secondary leading-relaxed fw-medium" style="font-size: 16px; line-height: 1.85;">
            To make our school a centre of excellence that shapes confident, adaptable and research-oriented global citizens with strong communication skills and deep Indian values, empowering them to lead with courage, integrity, empathy and responsibility.
          </p>
          <ul class="list-unstyled mt-4 mb-0">
            <li class="d-flex align-items-center gap-2 mb-2 text-muted">
              <i class="fa-solid fa-circle-check text-success"></i> Centre of excellence for confident &amp; adaptable learners
            </li>
            <li class="d-flex align-items-center gap-2 mb-2 text-muted">
              <i class="fa-solid fa-circle-check text-success"></i> Research-oriented global citizenship &amp; strong communication
            </li>
            <li class="d-flex align-items-center gap-2 text-muted">
              <i class="fa-solid fa-circle-check text-success"></i> Rooted in courage, integrity, empathy and responsibility
            </li>
          </ul>
        </div>
      </div>

      <!-- Mission Card -->
      <div class="col-lg-6">
        <div class="h-100 p-4 p-md-5 rounded-4 shadow-sm" style="background: #ffffff; border-top: 4px solid #2563EB;">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(37,99,235,0.1); color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 22px;">
              <i class="fa-solid fa-bullseye"></i>
            </div>
            <h3 class="mb-0 fw-bold" style="font-size: 24px; color: #141B2B;">School Mission</h3>
          </div>
          <p class="text-secondary leading-relaxed fw-medium" style="font-size: 16px; line-height: 1.85;">
            To nurture children with utmost care, giving equal opportunity, providing creative and critical learning, computational thinking rooted in Indian culture and values; to inspire them to become empathetic and confident thinkers, responsible citizens and future leaders.
          </p>
          <ul class="list-unstyled mt-4 mb-0">
            <li class="d-flex align-items-center gap-2 mb-2 text-muted">
              <i class="fa-solid fa-circle-check text-primary"></i> Utmost care, equal opportunity &amp; positive environment
            </li>
            <li class="d-flex align-items-center gap-2 mb-2 text-muted">
              <i class="fa-solid fa-circle-check text-primary"></i> Creative, critical learning &amp; computational thinking
            </li>
            <li class="d-flex align-items-center gap-2 text-muted">
              <i class="fa-solid fa-circle-check text-primary"></i> Empathetic thinkers, responsible citizens &amp; future leaders
            </li>
          </ul>
        </div>
      </div>

    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
