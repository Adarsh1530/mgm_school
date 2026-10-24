<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

$pdo = getDB();
$stmt = $pdo->prepare("SELECT content_html FROM pages WHERE slug = 'hindustan-scouts-guides'");
$stmt->execute();
$html = $stmt->fetchColumn();

$startTag = '<!-- Rajyapuraskar Award Certificates Image Gallery -->';
$endTag = '<div class="elementor-element elementor-element-4a139fb';

$startPos = strpos($html, $startTag);
$endPos = strpos($html, $endTag);

if ($startPos === false || $endPos === false) {
    die("Error: Could not locate boundary tags in page content.\n");
}

$cleanGallery = <<<'HTML'
<!-- Rajyapuraskar Award Certificates Image Gallery -->
<div class="card border-0 shadow-sm p-4 mb-4" style="background: #FFF8F9; border-left: 4px solid var(--tp-theme-primary, #ab0c2f) !important; border-radius: 12px;">
  <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
      <h5 class="mb-1" style="color: var(--tp-theme-primary, #ab0c2f); font-weight: 700;"><i class="fa-solid fa-award me-2"></i>Rajyapuraskar (Governor's Award) Certificates</h5>
      <p class="text-muted small mb-0">Official award certificates and cadet roll of honors (click any certificate to view in full resolution):</p>
    </div>
    <span class="badge bg-danger px-3 py-2">45 Rajyapuraskar Awards</span>
  </div>
  <div class="row g-3">
    <div class="col-6 col-md-3">
      <div class="card border h-100 shadow-sm overflow-hidden" style="border-radius: 8px;">
        <a href="assets/images/rajyapuraskar-2024.png" target="_blank" title="Rajyapuraskar 2024 Certificate">
          <img src="assets/images/rajyapuraskar-2024.png" class="w-100" style="height: 220px; object-fit: cover; object-position: top; transition: transform 0.3s ease;" alt="Rajyapuraskar 2024">
        </a>
        <div class="p-2 text-center bg-white border-top">
          <span class="fw-bold small text-dark d-block">Rajyapuraskar 2024</span>
          <div class="d-flex justify-content-center gap-1 mt-1">
            <a href="assets/images/rajyapuraskar-2024.png" target="_blank" class="badge bg-light text-primary text-decoration-none border"><i class="fa-solid fa-image me-1"></i>PNG</a>
            <a href="assets/docs/Rajyapuraskar-2024.pdf" target="_blank" class="badge bg-light text-danger text-decoration-none border"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border h-100 shadow-sm overflow-hidden" style="border-radius: 8px;">
        <a href="assets/images/rajyapuraskar-2023.png" target="_blank" title="Rajyapuraskar 2023 Certificate">
          <img src="assets/images/rajyapuraskar-2023.png" class="w-100" style="height: 220px; object-fit: cover; object-position: top; transition: transform 0.3s ease;" alt="Rajyapuraskar 2023">
        </a>
        <div class="p-2 text-center bg-white border-top">
          <span class="fw-bold small text-dark d-block">Rajyapuraskar 2023</span>
          <div class="d-flex justify-content-center gap-1 mt-1">
            <a href="assets/images/rajyapuraskar-2023.png" target="_blank" class="badge bg-light text-primary text-decoration-none border"><i class="fa-solid fa-image me-1"></i>PNG</a>
            <a href="assets/docs/Rajyapuraskar-2023.pdf" target="_blank" class="badge bg-light text-danger text-decoration-none border"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border h-100 shadow-sm overflow-hidden" style="border-radius: 8px;">
        <a href="assets/images/rajyapuraskar-2022.png" target="_blank" title="Rajyapuraskar 2022 Certificate">
          <img src="assets/images/rajyapuraskar-2022.png" class="w-100" style="height: 220px; object-fit: cover; object-position: top; transition: transform 0.3s ease;" alt="Rajyapuraskar 2022">
        </a>
        <div class="p-2 text-center bg-white border-top">
          <span class="fw-bold small text-dark d-block">Rajyapuraskar 2022</span>
          <div class="d-flex justify-content-center gap-1 mt-1">
            <a href="assets/images/rajyapuraskar-2022.png" target="_blank" class="badge bg-light text-primary text-decoration-none border"><i class="fa-solid fa-image me-1"></i>PNG</a>
            <a href="assets/docs/Rajyapuraskar-2022.pdf" target="_blank" class="badge bg-light text-danger text-decoration-none border"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border h-100 shadow-sm overflow-hidden" style="border-radius: 8px;">
        <a href="assets/images/rajyapuraskar-2019.png" target="_blank" title="Rajyapuraskar 2019 Certificate">
          <img src="assets/images/rajyapuraskar-2019.png" class="w-100" style="height: 220px; object-fit: cover; object-position: top; transition: transform 0.3s ease;" alt="Rajyapuraskar 2019">
        </a>
        <div class="p-2 text-center bg-white border-top">
          <span class="fw-bold small text-dark d-block">Rajyapuraskar 2019</span>
          <div class="d-flex justify-content-center gap-1 mt-1">
            <a href="assets/images/rajyapuraskar-2019.png" target="_blank" class="badge bg-light text-primary text-decoration-none border"><i class="fa-solid fa-image me-1"></i>PNG</a>
            <a href="assets/docs/Rajyapuraskar-2019.pdf" target="_blank" class="badge bg-light text-danger text-decoration-none border"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
		</div>
		
HTML;

$newHtml = substr($html, 0, $startPos) . $cleanGallery . substr($html, $endPos);

$up = $pdo->prepare("UPDATE pages SET content_html = ? WHERE slug = 'hindustan-scouts-guides'");
$up->execute([$newHtml]);
echo "Successfully cleaned and updated gallery! Rows affected: " . $up->rowCount() . "\n";
