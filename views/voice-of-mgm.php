<?php
/**
 * Voice of MGM View
 * MGM Model School Recreation Project - School Radio Club
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "voice-of-mgm";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Voice Of MGM";
$breadcrumbTitle = "Voice Of MGM";
$metaDescription = "Voice of MGM - The Official Campus Radio Club of MGM Model School.";
$wpId = 16036;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="tp-subpage-container py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Header with ON-AIR Indicator -->
    <div class="text-center mb-5">
      <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 shadow-sm" style="background: #ffffff; border: 1px solid #E2E8F0;">
        <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444; display: inline-block; animation: mgmPulse 1.5s infinite;"></span>
        <span class="text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1.5px; color: #ef4444;">On Air &bull; Campus Broadcasting</span>
      </div>
      <h2 class="tp-section-title mb-3" style="font-size: 34px; font-weight: 700; color: #141B2B;">"Voice of MGM" &ndash; Our School Radio Club</h2>
      <p class="text-muted mx-auto" style="max-width: 720px; font-size: 16px; line-height: 1.8;">
        The "Voice of MGM" Radio Club provides an authentic broadcasting platform for students to cultivate self-assurance, develop polished public speaking skills, and broadcast creative stories across our campus community.
      </p>
    </div>

    <!-- Studio Photography Cards -->
    <div class="row g-4 mb-5 justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
          <div style="height: 320px; overflow: hidden;">
            <img src="assets/images/1750233724.jpeg" alt="Voice of MGM Studio Session" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
          </div>
          <div class="p-3 text-center">
            <span class="fw-bold text-dark d-block">Campus Radio Broadcasting Station</span>
            <span class="text-muted small">Student sound engineers and radio jockeys in live broadcast</span>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
          <div style="height: 320px; overflow: hidden;">
            <img src="assets/images/1750233709.jpeg" alt="Voice of MGM Acoustic Studio" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
          </div>
          <div class="p-3 text-center">
            <span class="fw-bold text-dark d-block">Acoustic Recording &amp; Podcast Lab</span>
            <span class="text-muted small">Professional broadcast microphones and digital mixing consoles</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Core Features & Learning Outcomes -->
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3">
        <div class="p-4 rounded-4 h-100 shadow-sm bg-white" style="border-top: 3px solid var(--tp-theme-primary, #ab0c2f);">
          <div class="mb-3 text-danger" style="font-size: 26px;"><i class="fa-solid fa-microphone-lines"></i></div>
          <h5 class="fw-bold text-dark mb-2">Confidence Building</h5>
          <p class="text-muted small mb-0">Unlike intimidating stage performances, speaking into an acoustic studio microphone allows children to express themselves naturally and freely.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="p-4 rounded-4 h-100 shadow-sm bg-white" style="border-top: 3px solid #2563EB;">
          <div class="mb-3 text-primary" style="font-size: 26px;"><i class="fa-solid fa-bullhorn"></i></div>
          <h5 class="fw-bold text-dark mb-2">Public Speaking</h5>
          <p class="text-muted small mb-0">Mastering pronunciation, tone modulation, cadence, and eloquence to communicate impactful narratives with clarity and poise.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="p-4 rounded-4 h-100 shadow-sm bg-white" style="border-top: 3px solid #16A34A;">
          <div class="mb-3 text-success" style="font-size: 26px;"><i class="fa-solid fa-pen-nib"></i></div>
          <h5 class="fw-bold text-dark mb-2">Content Scripting</h5>
          <p class="text-muted small mb-0">Writing campus bulletins, cultural reviews, science explainers, and poetry to hone journalistic research and storytelling flair.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="p-4 rounded-4 h-100 shadow-sm bg-white" style="border-top: 3px solid #D97706;">
          <div class="mb-3 text-warning" style="font-size: 26px;"><i class="fa-solid fa-people-group"></i></div>
          <h5 class="fw-bold text-dark mb-2">Team Collaboration</h5>
          <p class="text-muted small mb-0">Managing live cue sheets, coordinating guest speaker interviews, and collaborating as a unified production crew.</p>
        </div>
      </div>
    </div>

    <!-- Official Inauguration Dignitary Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-md-2 text-center text-md-start">
          <div style="width: 70px; height: 70px; border-radius: 50%; background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); display: inline-flex; align-items: center; justify-content: center; font-size: 32px;">
            <i class="fa-solid fa-quote-left"></i>
          </div>
        </div>
        <div class="col-md-10">
          <h4 class="fw-bold text-dark mb-2">Inaugurated by Press Information Bureau Leadership</h4>
          <p class="text-secondary mb-2" style="font-size: 15.5px; line-height: 1.8;">
            The club was officially inaugurated by <strong>Smt. Rashmi Roja Thushara Nair IAS</strong>, Bureau Director of the <em>Press Information Bureau (PIB)</em>. Her encouragement marked a milestone for student media and democratic voice expression at MGM Model School.
          </p>
          <span class="badge bg-light text-dark border px-3 py-2 small fw-semibold">
            <i class="fa-solid fa-certificate text-danger me-1"></i> Official Bureau Director Inauguration
          </span>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
