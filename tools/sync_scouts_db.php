<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();

$cleanContentHtml = <<<'HTML'
<div class="tp-subpage-container py-5">
  <div class="container custom-container-larg">
    <div class="row g-4 align-items-start">
      
      <!-- Left Column: Troop Image & Certificates Grid -->
      <div class="col-lg-6">
        <!-- Troop Photo -->
        <div class="mb-4 rounded-4 overflow-hidden shadow-sm" style="border: 1px solid #eaeaea;">
          <img src="assets/images/scouts-and-guides.jpeg" class="w-100" style="max-height: 420px; object-fit: cover;" alt="Hindustan Scouts and Guides Troop">
        </div>

        <!-- Rajyapuraskar Award Certificates Image Gallery (Rounded Corner Square Shape) -->
        <div class="rajya-award-card" style="background: #FFF8F9; border-left: 4px solid var(--tp-theme-primary, #ab0c2f) !important; border-radius: 16px; padding: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
          <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
            <div>
              <h5 class="mb-1" style="color: var(--tp-theme-primary, #ab0c2f); font-weight: 700;">
                <i class="fa-solid fa-award me-2"></i>Rajyapuraskar Certificates
              </h5>
              <p class="text-muted small mb-0">Governor's Award (click any certificate to view):</p>
            </div>
            <span class="badge bg-danger px-3 py-2">45 Rajyapuraskar Awards</span>
          </div>

          <div class="row g-3 mt-1">
            <div class="col-6">
              <div class="rajya-thumb-box" onclick="openRajyaLightbox(0)">
                <img src="assets/images/rajyapuraskar-2024.png" alt="Rajyapuraskar 2024">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="rajya-thumb-caption">Rajyapuraskar 2024</div>
            </div>
            <div class="col-6">
              <div class="rajya-thumb-box" onclick="openRajyaLightbox(1)">
                <img src="assets/images/rajyapuraskar-2023.png" alt="Rajyapuraskar 2023">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="rajya-thumb-caption">Rajyapuraskar 2023</div>
            </div>
            <div class="col-6">
              <div class="rajya-thumb-box" onclick="openRajyaLightbox(2)">
                <img src="assets/images/rajyapuraskar-2022.png" alt="Rajyapuraskar 2022">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="rajya-thumb-caption">Rajyapuraskar 2022</div>
            </div>
            <div class="col-6">
              <div class="rajya-thumb-box" onclick="openRajyaLightbox(3)">
                <img src="assets/images/rajyapuraskar-2019.png" alt="Rajyapuraskar 2019">
                <div class="rajya-thumb-overlay"><i class="fa-solid fa-magnifying-glass-plus"></i></div>
              </div>
              <div class="rajya-thumb-caption">Rajyapuraskar 2019</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Scouts & Guides Details -->
      <div class="col-lg-6 ps-lg-4">
        <span class="badge px-3 py-1 mb-2 text-uppercase" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary); font-size: 11px; font-weight: 700;">Character &amp; Discipline</span>
        <h2 class="tp-section-title mb-3" style="font-size: 32px; font-weight: 700; color: #141B2B;">Hindustan Scouts &amp; Guides</h2>
        
        <p class="text-secondary leading-relaxed mb-4" style="font-size: 15px; line-height: 1.8;">
          As part of our mission to foster character development, moral fortitude, and responsible citizenry, MGM Model School, Ayiroor, Varkala has partnered with Hindustan Scouts and Guides Kerala since 2019.
        </p>

        <div class="card border-0 shadow-sm p-4 mb-4 rounded-4 bg-white">
          <h6 class="fw-bold mb-3" style="color: #141B2B;">Our School proudly hosts:</h6>
          <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
            <li class="d-flex align-items-center gap-2">
              <i class="fa-solid fa-circle-check text-success"></i>
              <span class="fw-medium text-dark">1 Scout Troop (104 Active Cadets)</span>
            </li>
            <li class="d-flex align-items-center gap-2">
              <i class="fa-solid fa-circle-check text-success"></i>
              <span class="fw-medium text-dark">1 Guide Company</span>
            </li>
            <li class="d-flex align-items-center gap-2">
              <i class="fa-solid fa-circle-check text-success"></i>
              <span class="fw-medium text-dark">1 Rover-Ranger unit</span>
            </li>
          </ul>
        </div>

        <div class="card border-0 shadow-sm p-4 rounded-4" style="background: #FDFBF8; border-left: 4px solid #F5A623 !important;">
          <p class="text-secondary mb-0" style="font-size: 15px; line-height: 1.8;">
            Led by our trained Scout Master <strong>Mr. Pravin S R</strong>, our troop of 104 active cadets is learning the true spirit of discipline, leadership, and service to the nation. Notably, <strong>45 cadets have been awarded the prestigious Rajyapuraskar (Governor's Award)</strong> over the past seven years.
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
HTML;

$stmt = $pdo->prepare("UPDATE pages SET content_html = ? WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute([$cleanContentHtml]);
echo "Updated pages table with clean scouts content! Rows: " . $stmt->rowCount() . "\n";
