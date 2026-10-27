<?php
/**
 * 20-20 Method of Teaching View
 * MGM Model School Campus Highlights
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "twenty-twenty-method";
$pageTitle = "20-20 Method of Teaching";
$breadcrumbTitle = "20-20 Method of Teaching";
$metaDescription = "MGM Model School's signature pedagogical model dividing class periods into 20 minutes of dynamic concept foundation followed by 20 minutes of interactive problem solving and peer discussion.";

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
        <i class="fa-solid fa-chalkboard-user text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Academic & Innovation</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Signature Pedagogical Framework</span>
          </div>
          <h1 class="fw-bold text-dark mb-3" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            20-20 Method of Teaching
          </h1>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            MGM Model School's signature pedagogical model dividing class periods into 20 minutes of dynamic concept foundation followed by 20 minutes of interactive problem solving and peer discussion.
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
        <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/1741692636.jpeg" alt="20-20 Method of Teaching" class="w-100 h-100" style="object-fit: cover; min-height: 380px; max-height: 520px;">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
          <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-chalkboard-user me-1"></i> 20-20 Method of Teaching</span>
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
            Traditional passive lectures often lead to student inattention and superficial understanding. The signature "20-20 Method of Teaching" pioneered at MGM Model School transforms standard periods into engaging learning cycles. The first 20 minutes are dedicated to teacher-led multimedia concept exploration. The subsequent 20 minutes engage students in active problem-solving, collaborative peer discussions, and instant doubt clarification.
          </p>

          <!-- Core Pillars Grid -->
          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Features &amp; Student Advantages</h4>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-brain fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">20 Mins Dynamic Foundation</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Instructors deliver high-impact conceptual explanations using smart interactive panels, animations, and real-world analogies.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-users-gear fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">20 Mins Active Application</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Learners solve exercise worksheets, analyze case problems, and engage in peer discussions to anchor the theoretical concepts.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-circle-question fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Immediate Doubt Clearance</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">No carrying doubts home. Teachers circulate among desks to provide personalized attention and address misunderstandings on the spot.</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="fa-solid fa-chart-line fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">Enhanced Long-Term Retention</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">Cognitive science demonstrates that active retrieval immediately following instruction boosts recall and examination performance significantly.</p>
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
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Target Grades</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Grades 1 through 12</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Subjects Covered</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Science, Mathematics, Social Studies & Languages</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Classroom Tech</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">Interactive Flat Panels & Digital Content</strong>
            </div>
            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">Pedagogy Impact</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">100% Classroom Engagement & Zero Doubt Backlog</strong>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
