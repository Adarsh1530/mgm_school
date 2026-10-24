<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();

$cleanScoutsHtml = <<<'HTML'
<div class="tp-subpage-container py-5">
  <div class="container custom-container-larg">
    <div class="row g-5 align-items-center">
      
      <!-- Left Column: Troop Photo -->
      <div class="col-lg-6">
        <div class="rounded-4 overflow-hidden shadow-sm" style="border: 1px solid #eaeaea;">
          <img src="assets/images/scouts-and-guides.jpeg" class="w-100" style="min-height: 420px; max-height: 500px; object-fit: cover;" alt="Hindustan Scouts and Guides Troop at MGM Model School">
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
          <h6 class="fw-bold mb-3" style="color: #141B2B;"><i class="fa-solid fa-flag me-2 text-danger"></i>Our School Proudly Hosts:</h6>
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
          <p class="text-secondary mb-3" style="font-size: 15px; line-height: 1.8;">
            Led by our trained Scout Master <strong>Mr. Pravin S R</strong>, our troop of 104 active cadets is learning the true spirit of discipline, leadership, and service to the nation. Notably, <strong>45 cadets have been awarded the prestigious Rajyapuraskar (Governor's Award)</strong> over the past several years.
          </p>
          <div>
            <a href="merit-day/#rajyapuraskar" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold">
              <i class="fa-solid fa-award me-1"></i> View Rajyapuraskar Honors on Merit Day <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
HTML;

$stmt = $pdo->prepare("UPDATE pages SET content_html = ? WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute([$cleanScoutsHtml]);
echo "Updated pages table for hindustan-scouts-guides. Rows: " . $stmt->rowCount() . "\n";
