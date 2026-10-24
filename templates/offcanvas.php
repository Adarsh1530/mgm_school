<?php
/**
 * Offcanvas Mobile Navigation Drawer
 * MGM Model School Recreation Project
 */
?>
<!-- Offcanvas Overlay -->
<div class="offcanvas-overlay"></div>

<!-- Offcanvas Content Wrapper -->
<div class="offcanvas-wrapper">
  
  <div class="offcanvas-header">
    <a href="<?= url('/') ?>" class="d-flex align-items-center gap-2 text-decoration-none">
      <img src="<?= asset_url('images/new-mgm-logo.png') ?>" alt="MGM Logo" style="max-height: 50px; width: auto; object-fit: contain;">
      <div class="text-start">
        <div class="fw-bold text-dark lh-1" style="font-size: 13px; letter-spacing: 0.5px;">MGM MODEL SCHOOL</div>
        <div class="text-muted lh-1 mt-1" style="font-size: 9px;">AYIROOR, VARKALA</div>
      </div>
    </a>
    <button class="offcanvas-close-btn" aria-label="Close Mobile Menu">
      <i class="fa-solid fa-xmark"></i>
    </button>
  </div>

  <!-- Mobile Menu Tree -->
  <nav class="offcanvas-menu mb-4">
    <ul>
      <?php foreach ($navTree as $nav): 
        $hasChildren = !empty($nav['children']);
      ?>
        <li class="<?= $hasChildren ? 'has-dropdown' : '' ?>">
          <a href="<?= e(url($nav['url'])) ?>" class="d-flex justify-content-between align-items-center">
            <span><?= e($nav['label']) ?></span>
            <?php if ($hasChildren): ?>
              <i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i>
            <?php endif; ?>
          </a>

          <?php if ($hasChildren): ?>
            <ul class="offcanvas-submenu" style="display: none;">
              <?php foreach ($nav['children'] as $child): ?>
                <li>
                  <a href="<?= e(url($child['url'])) ?>">
                    <i class="fa-solid fa-angle-right me-1 text-danger"></i> <?= e($child['label']) ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <!-- Mobile Contact Details -->
  <div class="mt-4 pt-3 border-top">
    <h5 style="font-size: 15px; font-weight: 700; color: #141B2B; margin-bottom: 12px;">Contact Information</h5>
    <p class="mb-2" style="font-size: 13px;"><i class="fa-solid fa-location-dot text-danger me-2"></i> <?= e(get_setting('school_address')) ?></p>
    <p class="mb-2" style="font-size: 13px;"><i class="fa-solid fa-phone text-danger me-2"></i> <?= e(get_setting('phone_primary')) ?></p>
    <p class="mb-3" style="font-size: 13px;"><i class="fa-solid fa-envelope text-danger me-2"></i> <?= e(get_setting('email_primary')) ?></p>
    <a href="<?= url('/admission-procedure/') ?>" class="tp-btn-primary w-100 text-center py-2">
      Apply For Admission
    </a>
  </div>

</div>
