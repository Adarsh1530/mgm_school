<?php
/**
 * Libraries @ MGM View
 * Exact Content from Official School Highlights
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "libraries-at-mgm";
$pageTitle = "Libraries @ MGM";
$breadcrumbTitle = "Libraries @ MGM";
$metaDescription = "MGM Model School houses three well-stocked libraries catering to Primary, Secondary and Higher Secondary sections - fostering a love for reading, learning, and inquiry from an early age. Our Secondary Library is digitalized, giving students seamless access to e-books, reference materials and digital learning resources, while still preserving the joy of traditional reading.";

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
        <i class="fa-solid fa-book-open-reader text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Academic & Innovation</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Knowledge & Reading Sanctuary</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            Libraries @ MGM
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Where Curiosity Takes Flight and Knowledge Finds Its True Meaning
          </h5>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            MGM Model School houses three well-stocked libraries catering to Primary, Secondary and Higher Secondary sections - fostering a love for reading, learning, and inquiry from an early age. Our Secondary Library is digitalized, giving students seamless access to e-books, reference materials and digital learning resources, while still preserving the joy of traditional reading.
          </p>
        </div>
      </div>
    </div>

    <!-- Three Dedicated Libraries Showcase Grid (Exact Natural 3:2 Ratio) -->
    <div class="mb-5">
      <div class="text-center mb-4">
        <span class="badge px-3 py-2 text-uppercase mb-2" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700;">
          3 Dedicated Campus Libraries
        </span>
        <h3 class="fw-bold text-dark" style="font-size: 26px;">Primary, Secondary &amp; Higher Secondary Libraries</h3>
        <p class="text-muted mx-auto" style="max-width: 680px; font-size: 15px;">Three specialized reading environments thoughtfully designed to foster discovery, digital research, and a lifelong passion for reading at every learning stage.</p>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- 1. Higher Secondary Library -->
        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative overflow-hidden">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/libraries-1.jpeg" 
                   alt="Higher Secondary Library @ MGM" 
                   class="img-fluid w-100" 
                   style="aspect-ratio: 3/2; object-fit: cover;">
              <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm" 
                    style="background: rgba(171, 12, 47, 0.9); color: #fff; font-size: 11px; font-weight: 600;">
                Higher Secondary
              </span>
            </div>
            <div class="p-4 text-center d-flex flex-column justify-content-between flex-grow-1">
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Senior Reading &amp; Research Hall</h5>
                <p class="text-secondary small mb-0 leading-relaxed" style="line-height: 1.7;">
                  Equipped with individual study carrels, expansive academic bookshelves, encyclopedias, reference texts, and daily periodicals for senior learners.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- 2. Digital Secondary Library -->
        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative overflow-hidden">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/libraries-2.jpeg" 
                   alt="Digitalized Secondary Library @ MGM" 
                   class="img-fluid w-100" 
                   style="aspect-ratio: 3/2; object-fit: cover;">
              <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm" 
                    style="background: rgba(37, 99, 235, 0.9); color: #fff; font-size: 11px; font-weight: 600;">
                Secondary Section
              </span>
            </div>
            <div class="p-4 text-center d-flex flex-column justify-content-between flex-grow-1">
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Digitalized Secondary Library</h5>
                <p class="text-secondary small mb-0 leading-relaxed" style="line-height: 1.7;">
                  Computerized research terminals offering access to digital e-books, online encyclopedias, research publications, and interactive learning media.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Primary School Library -->
        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
            <div class="position-relative overflow-hidden">
              <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/libraries-3.jpeg" 
                   alt="Primary School Library @ MGM" 
                   class="img-fluid w-100" 
                   style="aspect-ratio: 3/2; object-fit: cover;">
              <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm" 
                    style="background: rgba(16, 185, 129, 0.9); color: #fff; font-size: 11px; font-weight: 600;">
                Primary Section
              </span>
            </div>
            <div class="p-4 text-center d-flex flex-column justify-content-between flex-grow-1">
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Primary School Library</h5>
                <p class="text-secondary small mb-0 leading-relaxed" style="line-height: 1.7;">
                  Vibrant reading benches with age-appropriate children's storybooks, early literature, and colourful pictorial resources inspiring young readers.
                </p>
              </div>
            </div>
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
            About Libraries @ MGM
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            MGM Model School houses three well-stocked libraries catering to Primary, Secondary and Higher Secondary sections - fostering a love for reading, learning, and inquiry from an early age. Our Secondary Library is digitalized, giving students seamless access to e-books, reference materials and digital learning resources, while still preserving the joy of traditional reading.
          </p>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            We believe a library is where curiosity takes flight and knowledge finds its true meaning.
          </p>

          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Highlights &amp; Features</h4>
          <div class="d-flex flex-column gap-2 mb-2">
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Three well-stocked libraries dedicated to Primary, Secondary & Higher Secondary</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Digitalized Secondary Library with e-books and online reference archives</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Preserves the timeless joy of traditional reading alongside digital resources</span>
            </div>
            <div class="d-flex align-items-start gap-2 p-2 rounded-2 bg-light">
              <i class="fa-solid fa-circle-check text-success mt-1"></i>
              <span class="text-dark fw-medium small" style="line-height: 1.6;">Fosters lifelong habits of inquiry, intellectual exploration and scholarship</span>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Number of Libraries</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">3 Libraries (Primary, Secondary & Higher Secondary)</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Digitalization</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Digital Secondary Library with E-Books & Reference DB</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Target Sections</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Primary, Secondary & Higher Secondary Students</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Atmosphere</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Inspiring, Quiet Scholarly Environment</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
