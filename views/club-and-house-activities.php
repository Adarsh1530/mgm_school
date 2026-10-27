<?php
/**
 * Club & House Activities View
 * MGM Model School Recreation Project
 * Exact Content from Official School Updates
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "club-and-house-activities";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Club & House Activities";
$breadcrumbTitle = "Club & House Activities";
$metaDescription = "Club & House Activities at MGM Model School, Ayiroor, Varkala - Nature Club, Literary Clubs, Science, IT, Sports, House Competitions and Holistic Development.";

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<main id="content" class="site-main py-5" style="background: #FAF8F5; min-height: 100vh;">
  <div class="container custom-container-larg">

    <!-- Top Navigation Return & Category Pill -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
      <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white shadow-sm border">
        <i class="fa-solid fa-shapes text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">Activities &amp; Student Life</span>
      </div>
      <div class="d-inline-flex align-items-center gap-2">
        <span class="badge bg-danger rounded-pill px-3 py-2 fw-semibold">
          <i class="fa-solid fa-award me-1"></i> Credits &amp; Grades Awarded
        </span>
      </div>
    </div>

    <!-- Main Header Banner (Exact Content from Document) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white" style="border-left: 5px solid var(--tp-theme-primary, #ab0c2f) !important;">
      <div class="row align-items-center g-4">
        <div class="col-lg-12">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">Co-Curricular Excellence</span>
          </div>
          <h1 class="fw-bold text-dark mb-2" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            CLUB &amp; HOUSE ACTIVITIES
          </h1>
          <h5 class="text-danger fw-semibold mb-3" style="font-size: 18px;">
            Fostering Leadership, Team Spirit, Creativity and Physical Vitality
          </h5>
          <p class="text-secondary mb-3 leading-relaxed" style="font-size: 17px; line-height: 1.85;">
            Various activities and competitions will be organised by the school for all students. All are expected to take part in these activities. Credits will be given for good performance.
          </p>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.85;">
            Games such as Football, Cricket, Kho-kho, Kabbadi, Badminton, Throw ball, Volley ball and Swimming etc will be organised apart from drill and athletics. All are expected to take advantage of these opportunities. Moreover, grades are awarded for participation and excellence.
          </p>
        </div>
      </div>
    </div>

    <!-- Featured Activities Image Showcase (Exact Image from Folder) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white p-3 p-md-4">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 px-2 pt-2">
        <div>
          <span class="badge bg-danger px-3 py-1 rounded-pill small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Campus Action</span>
          <h4 class="fw-bold text-dark mt-2 mb-1">MGM Model School Clubs in Action</h4>
          <p class="text-muted small mb-0">Empowering student eco-initiatives with the SEED Club and community outreach through the Nanma Club.</p>
        </div>
        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill small">
          <i class="fa-solid fa-camera text-danger me-1"></i> Authentic Campus Photograph
        </span>
      </div>
      <div class="rounded-4 overflow-hidden shadow-sm" style="background: #f8fafc;">
        <img src="<?= rtrim(BASE_URL, '/') ?>/assets/images/club-activities.jpeg" 
             alt="MGM Model School Club & House Activities - Seed Club and Nanma Club" 
             class="img-fluid w-100" 
             style="max-height: 640px; object-fit: contain; display: block; margin: 0 auto;">
      </div>
    </div>

    <!-- Games, Sports & Athletics Section (Exact Content from Document) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="d-flex align-items-center gap-3 mb-4">
        <span style="width: 8px; height: 32px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
        <div>
          <h3 class="fw-bold text-dark mb-1">Games, Sports &amp; Physical Fitness</h3>
          <p class="text-muted small mb-0">Comprehensive sports program developing agility, endurance, and true sportsmanship</p>
        </div>
      </div>
      <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
        Games such as <strong>Football, Cricket, Kho-kho, Kabbadi, Badminton, Throw ball, Volley ball and Swimming</strong> etc will be organised apart from <strong>drill and athletics</strong>. All are expected to take advantage of these opportunities. Moreover, <strong>grades and credits are awarded for participation and excellence</strong>.
      </p>

      <div class="row g-3">
        <!-- Football -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(171, 12, 47, 0.1); color: var(--tp-theme-primary, #ab0c2f);">
              <i class="fa-solid fa-futbol fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Football</h6>
            <span class="text-muted small">Inter-House &amp; Tournaments</span>
          </div>
        </div>

        <!-- Cricket -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.1); color: #2563EB;">
              <i class="fa-solid fa-baseball-bat-ball fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Cricket</h6>
            <span class="text-muted small">Coaching &amp; Matches</span>
          </div>
        </div>

        <!-- Kho-Kho -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(22, 163, 74, 0.1); color: #16A34A;">
              <i class="fa-solid fa-person-running fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Kho-Kho</h6>
            <span class="text-muted small">Speed &amp; Strategy</span>
          </div>
        </div>

        <!-- Kabbadi -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(217, 119, 6, 0.1); color: #D97706;">
              <i class="fa-solid fa-hand-fist fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Kabbadi</h6>
            <span class="text-muted small">Power &amp; Agility</span>
          </div>
        </div>

        <!-- Badminton -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(124, 58, 237, 0.1); color: #7C3AED;">
              <i class="fa-solid fa-table-tennis-paddle-ball fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Badminton</h6>
            <span class="text-muted small">Reflexes &amp; Court Play</span>
          </div>
        </div>

        <!-- Throw Ball -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(14, 165, 233, 0.1); color: #0EA5E9;">
              <i class="fa-solid fa-volleyball fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Throw Ball</h6>
            <span class="text-muted small">Team Coordination</span>
          </div>
        </div>

        <!-- Volley Ball -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(234, 88, 12, 0.1); color: #EA580C;">
              <i class="fa-solid fa-basketball fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Volley Ball</h6>
            <span class="text-muted small">Jumps, Serves &amp; Spikes</span>
          </div>
        </div>

        <!-- Swimming -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 rounded-3 h-100 border text-center bg-light transition-hover" style="transition: all 0.2s ease;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(6, 182, 212, 0.1); color: #06B6D4;">
              <i class="fa-solid fa-person-swimming fa-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Swimming</h6>
            <span class="text-muted small">Semi-Olympic Facility</span>
          </div>
        </div>

        <!-- Drill & Athletics -->
        <div class="col-12">
          <div class="p-3 rounded-3 border bg-white d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-left: 4px solid var(--tp-theme-primary, #ab0c2f) !important;">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(171, 12, 47, 0.1); color: var(--tp-theme-primary, #ab0c2f);">
                <i class="fa-solid fa-stopwatch fa-lg"></i>
              </div>
              <div>
                <h6 class="fw-bold text-dark mb-0">Drill, March Past &amp; Athletics Track Events</h6>
                <span class="text-muted small">Track races, high jump, long jump, shot put, relay races, and annual sports meet march past.</span>
              </div>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
              <i class="fa-solid fa-check me-1"></i> Compulsory Physical Vitality
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Student Clubs Section (Exact 15 Clubs from Document) -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="d-flex align-items-center gap-3 mb-4">
        <span style="width: 8px; height: 32px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
        <div>
          <span class="badge bg-danger px-3 py-1 rounded-pill small fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Student Enrichment</span>
          <h3 class="fw-bold text-dark mb-1">CLUBS OF MGM MODEL SCHOOL</h3>
          <p class="text-muted small mb-0">15 Dedicated Co-Curricular Clubs Nurturing Every Interest and Passion</p>
        </div>
      </div>

      <div class="row g-4">
        
        <!-- 1. Nature Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #16A34A !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(22, 163, 74, 0.12); color: #16A34A;">
                <i class="fa-solid fa-leaf"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #01</span>
                <h5 class="fw-bold text-dark mb-0">Nature Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Instills deep ecological sensitivity and awareness. Students participate in environmental conservation drives, tree planting, nature observation walks, and biodiversity preservation.
            </p>
          </div>
        </div>

        <!-- 2. Literary Clubs for English, Malayalam & Hindi -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #2563EB !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(37, 99, 235, 0.12); color: #2563EB;">
                <i class="fa-solid fa-book-open"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #02</span>
                <h5 class="fw-bold text-dark mb-0">Literary Clubs</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Dedicated multilingual wings for <strong>English, Malayalam &amp; Hindi</strong>. Nurtures creative writing, elocution, debates, recitation, storytelling, and linguistic eloquence.
            </p>
          </div>
        </div>

        <!-- 3. Maths Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #7C3AED !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(124, 58, 237, 0.12); color: #7C3AED;">
                <i class="fa-solid fa-calculator"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #03</span>
                <h5 class="fw-bold text-dark mb-0">Maths Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Demystifies mathematics through logic puzzles, Euler's formula investigations, geometry construction, Vedic maths shortcuts, and mathematical model building.
            </p>
          </div>
        </div>

        <!-- 4. Science Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #0284C7 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(2, 132, 199, 0.12); color: #0284C7;">
                <i class="fa-solid fa-flask-vial"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #04</span>
                <h5 class="fw-bold text-dark mb-0">Science Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Sparks scientific curiosity through experimental investigation, hands-on science lab demonstrations, working model innovations, and National Science Day exhibitions.
            </p>
          </div>
        </div>

        <!-- 5. Mass Media Club & IT -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #0D9488 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(13, 148, 136, 0.12); color: #0D9488;">
                <i class="fa-solid fa-laptop-code"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #05</span>
                <h5 class="fw-bold text-dark mb-0">Mass Media Club &amp; IT</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Prepares students for the digital era with training in computing, video editing, digital journalism, photography, broadcasting, coding, and cyber awareness.
            </p>
          </div>
        </div>

        <!-- 6. Health and Wellness Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #E11D48 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(225, 29, 72, 0.12); color: #E11D48;">
                <i class="fa-solid fa-heart-pulse"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #06</span>
                <h5 class="fw-bold text-dark mb-0">Health &amp; Wellness Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Promotes wholesome lifestyle habits, balanced nutrition, mental health awareness, yoga, stress relief techniques, and first-aid response preparedness.
            </p>
          </div>
        </div>

        <!-- 7. Consumer Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #D97706 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(217, 119, 6, 0.12); color: #D97706;">
                <i class="fa-solid fa-scale-balanced"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #07</span>
                <h5 class="fw-bold text-dark mb-0">Consumer Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Educates students on consumer rights, food adulteration tests, fair trade ethics, consumer protection laws, and intelligent financial decision making.
            </p>
          </div>
        </div>

        <!-- 8. Reader’s Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #4F46E5 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(79, 70, 229, 0.12); color: #4F46E5;">
                <i class="fa-solid fa-book-bookmark"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #08</span>
                <h5 class="fw-bold text-dark mb-0">Reader’s Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Fosters an enduring love for books, regular library reading sessions, book review discussions, author birthday tributes, and literary appreciation circles.
            </p>
          </div>
        </div>

        <!-- 9. Nanma Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #EA580C !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(234, 88, 12, 0.12); color: #EA580C;">
                <i class="fa-solid fa-hands-holding-child"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #09</span>
                <h5 class="fw-bold text-dark mb-0">Nanma Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              MGM’s flagship humanitarian club instilling empathy and compassion. Students organize visits to old age homes, care packages for the underprivileged, and social welfare drives.
            </p>
          </div>
        </div>

        <!-- 10. Visual & Performing Arts Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #DB2777 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(219, 39, 119, 0.12); color: #DB2777;">
                <i class="fa-solid fa-palette"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #10</span>
                <h5 class="fw-bold text-dark mb-0">Visual &amp; Performing Arts</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Celebrates artistic brilliance through painting, sketching, classical and contemporary dance forms, vocal &amp; instrumental music, drama, and campus stagecraft.
            </p>
          </div>
        </div>

        <!-- 11. GK & Quiz Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #475569 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(71, 85, 105, 0.12); color: #475569;">
                <i class="fa-solid fa-brain"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #11</span>
                <h5 class="fw-bold text-dark mb-0">GK &amp; Quiz Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Sharpens general knowledge, current affairs awareness, and rapid recall through inter-class quiz leagues, buzzer rounds, trivia contests, and national Olympiad training.
            </p>
          </div>
        </div>

        <!-- 12. EBSB (Ek Bharat Shreshtha Bharat) -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #CA8A04 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(202, 138, 4, 0.12); color: #CA8A04;">
                <i class="fa-solid fa-flag"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #12</span>
                <h5 class="fw-bold text-dark mb-0">EBSB Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Celebrates India's vibrant cultural diversity under the national <em>Ek Bharat Shreshtha Bharat</em> initiative with state pairing celebrations, language sharing, culinary fests, and cultural heritage exhibits.
            </p>
          </div>
        </div>

        <!-- 13. Seed Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #059669 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(5, 150, 105, 0.12); color: #059669;">
                <i class="fa-solid fa-seedling"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #13</span>
                <h5 class="fw-bold text-dark mb-0">Seed Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Mathrubhumi SEED (Student Empowerment for Environmental Development). Leads plastic segregation (low &amp; high micron), waste recycling, sapling planting, and campus water conservation.
            </p>
          </div>
        </div>

        <!-- 14. Yuva Tourism Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #0891B2 !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(8, 145, 178, 0.12); color: #0891B2;">
                <i class="fa-solid fa-compass"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #14</span>
                <h5 class="fw-bold text-dark mb-0">Yuva Tourism Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Ministry of Tourism initiative cultivating youth interest in India's monuments, eco-tourism ethics, cultural discovery, local heritage trails, and responsible travel.
            </p>
          </div>
        </div>

        <!-- 15. Nallapadam Club -->
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border rounded-4 p-4 shadow-sm bg-white hover-shadow transition-hover" style="border-top: 3px solid #B91C1C !important;">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(185, 28, 28, 0.12); color: #B91C1C;">
                <i class="fa-solid fa-hand-holding-heart"></i>
              </div>
              <div>
                <span class="badge bg-light text-muted border small">Club #15</span>
                <h5 class="fw-bold text-dark mb-0">Nallapadam Club</h5>
              </div>
            </div>
            <p class="text-secondary small mb-0 leading-relaxed">
              Malayala Manorama Nallapadam initiative nurturing moral uprightness, civic values, charity drives, kindness projects, and active social responsibility among young minds.
            </p>
          </div>
        </div>

      </div>
    </div>

    <!-- House System & Inter-House Competitions Section -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="d-flex align-items-center gap-3 mb-4">
        <span style="width: 8px; height: 32px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
        <div>
          <span class="badge bg-danger px-3 py-1 rounded-pill small fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">Camaraderie &amp; House Spirit</span>
          <h3 class="fw-bold text-dark mb-1">MGM School House System</h3>
          <p class="text-muted small mb-0">Instilling leadership, healthy rivalry, teamwork and house pride</p>
        </div>
      </div>

      <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
        To foster healthy competition, belonging, and leadership, students from primary through senior secondary are divided into four distinct Houses. Each House is guided by dedicated House Masters, Mistresses, House Captains, and Vice Captains.
      </p>

      <div class="row g-4 mb-4">
        <!-- Ruby House -->
        <div class="col-sm-6 col-lg-3">
          <div class="p-4 rounded-4 text-center border h-100" style="background: linear-gradient(135deg, #FFF1F2 0%, #FFFFFF 100%); border-top: 4px solid #E11D48 !important;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 52px; height: 52px; background: #E11D48; color: #fff;">
              <i class="fa-solid fa-gem fa-lg"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Ruby House</h5>
            <span class="badge bg-danger rounded-pill px-3 py-1 small">Passion &amp; Courage</span>
          </div>
        </div>

        <!-- Emerald House -->
        <div class="col-sm-6 col-lg-3">
          <div class="p-4 rounded-4 text-center border h-100" style="background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 100%); border-top: 4px solid #16A34A !important;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 52px; height: 52px; background: #16A34A; color: #fff;">
              <i class="fa-solid fa-gem fa-lg"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Emerald House</h5>
            <span class="badge bg-success rounded-pill px-3 py-1 small">Growth &amp; Harmony</span>
          </div>
        </div>

        <!-- Sapphire House -->
        <div class="col-sm-6 col-lg-3">
          <div class="p-4 rounded-4 text-center border h-100" style="background: linear-gradient(135deg, #EFF6FF 0%, #FFFFFF 100%); border-top: 4px solid #2563EB !important;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 52px; height: 52px; background: #2563EB; color: #fff;">
              <i class="fa-solid fa-gem fa-lg"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Sapphire House</h5>
            <span class="badge bg-primary rounded-pill px-3 py-1 small">Wisdom &amp; Integrity</span>
          </div>
        </div>

        <!-- Topaz House -->
        <div class="col-sm-6 col-lg-3">
          <div class="p-4 rounded-4 text-center border h-100" style="background: linear-gradient(135deg, #FEFCE8 0%, #FFFFFF 100%); border-top: 4px solid #CA8A04 !important;">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 52px; height: 52px; background: #CA8A04; color: #fff;">
              <i class="fa-solid fa-gem fa-lg"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Topaz House</h5>
            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 small">Energy &amp; Excellence</span>
          </div>
        </div>
      </div>

      <!-- House Activities Highlights -->
      <div class="row g-3">
        <div class="col-md-4">
          <div class="p-3 rounded-3 bg-light border h-100">
            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-trophy text-warning me-2"></i>Inter-House Cultural Fest</h6>
            <p class="text-secondary small mb-0">Music, dance, recitation, dramatics, and literary contests held across age groups throughout the academic year.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3 bg-light border h-100">
            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-medal text-danger me-2"></i>Annual Sports Meet &amp; March Past</h6>
            <p class="text-secondary small mb-0">Houses march in disciplined coordination, competing in track, field, and team games for the prestigious Rolling Trophy.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 rounded-3 bg-light border h-100">
            <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-chart-line text-success me-2"></i>Continuous Point System</h6>
            <p class="text-secondary small mb-0">Points are systematically awarded for academic distinctions, discipline, sports victories, and club participations.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Recognition & Credits Note -->
    <div class="card border-0 rounded-4 p-4 text-center text-white mb-5 shadow" style="background: linear-gradient(135deg, var(--tp-theme-primary, #ab0c2f) 0%, #70061e 100%);">
      <div class="py-2">
        <i class="fa-solid fa-certificate fa-2x mb-3 text-warning"></i>
        <h4 class="fw-bold text-white mb-2">Grading, Credits &amp; Performance Accolades</h4>
        <p class="mb-0 text-white-50 mx-auto" style="max-width: 720px; font-size: 16px; line-height: 1.7;">
          At MGM Model School, all students are expected to actively participate in club programs, sports games, and house events. Grades and performance credits are awarded in report cards and term evaluations, ensuring holistic recognition for every student's unique skills and dedication.
        </p>
      </div>
    </div>

  </div>
</main>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
