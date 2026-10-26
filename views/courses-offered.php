<?php
/**
 * Courses Offered View
 * Exact Visual Recreation of Reference WordPress Website with Authentic Course Chart
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "courses-offered";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Courses Offered";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "Courses and curriculum streams offered at MGM Model School.";
$wpId = 15930;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<main id="content" class="site-main py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Introduction Block -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5" style="background: #ffffff; border-left: 5px solid var(--tp-theme-primary, #ab0c2f) !important;">
      <span class="badge px-3 py-2 text-uppercase mb-2 d-inline-block" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700; width: fit-content;">Academic Framework</span>
      <h2 class="tp-section-title mb-3" style="font-size: 28px; font-weight: 700; color: #141B2B;">CBSE Curriculum &amp; Academic Streams</h2>
      <p class="text-secondary mb-2" style="font-size: 16px; line-height: 1.8;">
        Our school, following the <strong>NCERT syllabus</strong>, prepares students for the <strong>All India Secondary School Examination (AISSE)</strong> and the <strong>Senior School Certificate Examination (SSCE)</strong> conducted by the <strong>Central Board of Secondary Education (CBSE)</strong>.
      </p>
      <p class="text-secondary mb-0" style="font-size: 15px; line-height: 1.7;">
        The medium of instruction is English. The curriculum balances intellectual rigor, digital empowerment, athletic vitality, arts, and value education across all learning tiers.
      </p>
    </div>

    <!-- Levels Grid (I - X) -->
    <div class="row g-4 mb-5">
      
      <!-- Classes I - V -->
      <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
          <div class="p-3" style="background: linear-gradient(135deg, #FFF1F2 0%, #FFE4E6 100%); border-bottom: 2px solid #FDA4AF;">
            <div class="d-flex align-items-center justify-content-between">
              <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: var(--tp-theme-primary, #ab0c2f); color: #fff; font-size: 13px;">Class I &ndash; V</span>
              <span class="text-danger fw-semibold small"><i class="fa-solid fa-shapes me-1"></i> Primary School</span>
            </div>
          </div>
          <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-3">Subjects Taught:</h6>
            <div class="d-flex flex-wrap gap-2">
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">English</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Hindi</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Malayalam</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Maths</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">E.V.S</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">IT</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Music</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Dance</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Drawing &amp; Painting</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Chess</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Karate</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Swimming</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Robotics (from grade 3 onwards)</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Health &amp; Physical Education</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Yoga and Abacus</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Life Skill</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Theatre &amp; Drama</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">GDC (General Development Council)</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Kalari</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Classes VI - VIII -->
      <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
          <div class="p-3" style="background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border-bottom: 2px solid #93C5FD;">
            <div class="d-flex align-items-center justify-content-between">
              <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: #2563EB; color: #fff; font-size: 13px;">Class VI &ndash; VIII</span>
              <span class="text-primary fw-semibold small"><i class="fa-solid fa-book-open-reader me-1"></i> Middle School</span>
            </div>
          </div>
          <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-3">Subjects Taught:</h6>
            <div class="d-flex flex-wrap gap-2">
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">English</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Hindi</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Malayalam</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Maths</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Science</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Social Science</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">CT &amp; AI</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Health &amp; Physical Education</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Art Education and Life Skills</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Karate</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Chess</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Yoga</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Kalari</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Zoomba dance</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Sanskrit</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Swimming</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Theatre and Drama</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Craft</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Robotics</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">GDC</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Kaushal Bodh</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Classes IX - X -->
      <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
          <div class="p-3" style="background: linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%); border-bottom: 2px solid #86EFAC;">
            <div class="d-flex align-items-center justify-content-between">
              <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: #16A34A; color: #fff; font-size: 13px;">Class IX &ndash; X</span>
              <span class="text-success fw-semibold small"><i class="fa-solid fa-graduation-cap me-1"></i> Secondary (AISSE)</span>
            </div>
          </div>
          <div class="card-body p-4">
            <h6 class="fw-bold text-dark mb-3">Subjects Taught:</h6>
            <div class="d-flex flex-wrap gap-2">
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">English</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Hindi</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Malayalam</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Maths</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Science &amp; Technology</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Social Science</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">AI (Artificial Intelligence)</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Health &amp; Physical Education</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Work Experience &amp; Art</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Kaushal Vikas</span>
              <span class="badge bg-light text-dark border py-2 px-2 fw-normal">Life Skills</span>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Senior Secondary (Classes XI - XII) - 16 Groups -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="background: #ffffff;">
      <div class="p-4" style="background: linear-gradient(135deg, #F8FAFC 0%, #EEF2F6 100%); border-bottom: 2px solid #E2E8F0;">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div>
            <span class="badge bg-dark px-3 py-2 rounded-pill text-uppercase mb-1" style="font-size: 11px; letter-spacing: 1px;">Senior Secondary Curriculum</span>
            <h3 class="fw-bold text-dark mb-0" style="font-size: 24px;">Class XI &ndash; XII Subject Combinations (16 Groups)</h3>
          </div>
          <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 fw-semibold">
            <i class="fa-solid fa-award me-1"></i> CBSE Senior School Certificate (SSCE)
          </span>
        </div>
      </div>

      <div class="card-body p-4 p-md-5">
        
        <!-- Science Stream (Groups I - VI) -->
        <div class="mb-5">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-primary px-3 py-2 rounded-pill"><i class="fa-solid fa-atom me-1"></i> Science Stream</span>
            <span class="text-muted small fw-semibold">Groups I to VI</span>
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle border mb-0 rounded-3 overflow-hidden">
              <thead class="table-light">
                <tr>
                  <th style="width: 140px;" class="fw-bold">Group</th>
                  <th class="fw-bold">Subject Combination</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Group I</span></td>
                  <td>English, Physics, Chemistry, Biology, Mathematics</td>
                </tr>
                <tr>
                  <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Group II</span></td>
                  <td>English, Physics, Chemistry, Mathematics, Computer Science</td>
                </tr>
                <tr>
                  <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Group III</span></td>
                  <td>English, Physics, Chemistry, Biology, Informatics Practices</td>
                </tr>
                <tr>
                  <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Group IV</span></td>
                  <td>English, Physics, Chemistry, Biology, Malayalam</td>
                </tr>
                <tr>
                  <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Group V</span></td>
                  <td>English, Physics, Chemistry, Biology, Psychology</td>
                </tr>
                <tr>
                  <td><span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1">Group VI</span></td>
                  <td>English, Physics, Chemistry, Biology, AI (Artificial Intelligence)</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Commerce Stream (Groups VII - XI) -->
        <div class="mb-5">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="fa-solid fa-chart-line me-1"></i> Commerce Stream</span>
            <span class="text-muted small fw-semibold">Groups VII to XI</span>
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle border mb-0 rounded-3 overflow-hidden">
              <thead class="table-light">
                <tr>
                  <th style="width: 140px;" class="fw-bold">Group</th>
                  <th class="fw-bold">Subject Combination</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">Group VII</span></td>
                  <td>English, Accountancy, Business Studies, Economics, Informatics Practices</td>
                </tr>
                <tr>
                  <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">Group VIII</span></td>
                  <td>English, Accountancy, Business Studies, Economics, Mathematics</td>
                </tr>
                <tr>
                  <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">Group IX</span></td>
                  <td>English, Accountancy, Business Studies, Economics, Malayalam</td>
                </tr>
                <tr>
                  <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">Group X</span></td>
                  <td>English, Accountancy, Business Studies, Economics, AI (Artificial Intelligence)</td>
                </tr>
                <tr>
                  <td><span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1">Group XI</span></td>
                  <td>English, Accountancy, Business Studies, Economics, Psychology</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Humanities Stream (Groups XII - XVI) -->
        <div>
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fa-solid fa-landmark me-1"></i> Humanities Stream</span>
            <span class="text-muted small fw-semibold">Groups XII to XVI</span>
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle border mb-0 rounded-3 overflow-hidden">
              <thead class="table-light">
                <tr>
                  <th style="width: 140px;" class="fw-bold">Group</th>
                  <th class="fw-bold">Subject Combination</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="badge bg-warning bg-opacity-10 text-dark fw-bold px-2 py-1">Group XII</span></td>
                  <td>English, History, Geography, Economics, Informatics Practices</td>
                </tr>
                <tr>
                  <td><span class="badge bg-warning bg-opacity-10 text-dark fw-bold px-2 py-1">Group XIII</span></td>
                  <td>English, History, Geography, Economics, Mathematics</td>
                </tr>
                <tr>
                  <td><span class="badge bg-warning bg-opacity-10 text-dark fw-bold px-2 py-1">Group XIV</span></td>
                  <td>English, History, Geography, Economics, Malayalam</td>
                </tr>
                <tr>
                  <td><span class="badge bg-warning bg-opacity-10 text-dark fw-bold px-2 py-1">Group XV</span></td>
                  <td>English, History, Geography, Economics, Psychology</td>
                </tr>
                <tr>
                  <td><span class="badge bg-warning bg-opacity-10 text-dark fw-bold px-2 py-1">Group XVI</span></td>
                  <td>English, History, Geography, Economics, AI (Artificial Intelligence)</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

  </div>
</main>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
