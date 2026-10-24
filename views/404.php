<?php
/**
 * 404 Not Found View
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$pageTitle = "Page Not Found";
$currentSlug = "404";

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="py-5 text-center" style="background-color: #F8F9FA; min-height: 450px; display: flex; align-items: center;">
  <div class="container custom-container-larg">
    <div class="py-5">
      <h1 class="display-1 fw-bold text-danger mb-3" style="color: var(--tp-theme-primary) !important;">404</h1>
      <h2 class="fw-bold mb-3" style="color: #141B2B;">Oops! Page Not Found</h2>
      <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
        The requested URL was not found on this server. Please check the spelling or return to the MGM School homepage.
      </p>
      <a href="<?= url('/') ?>" class="tp-btn-primary px-4 py-3">
        <i class="fa-solid fa-house me-2"></i> Return to Homepage
      </a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
