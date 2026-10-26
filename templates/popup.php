<?php
/**
 * Image Popup Notification Component
 * MGM Model School Website
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$popupData = get_popup_notification();
if (!$popupData) {
    return;
}

$popupImage = $popupData['image_url'];
if (!preg_match('#^https?://#i', $popupImage)) {
    $popupImage = asset_url(str_replace('assets/', '', $popupImage));
}
$popupTitle = $popupData['title'] ?? 'School Announcement';
$popupLink = $popupData['link_url'] ?? '';
?>

<!-- MGM Image Popup Notification -->
<div id="mgmPopupModal" class="mgm-popup-overlay" style="display: none;" role="dialog" aria-modal="true" aria-label="<?= e($popupTitle) ?>">
  <div class="mgm-popup-dialog">
    <!-- Close Button -->
    <button type="button" class="mgm-popup-close-btn" id="mgmPopupCloseBtn" aria-label="Close Announcement">
      <i class="fa-solid fa-xmark"></i>
    </button>

    <!-- Modal Content Body -->
    <div class="mgm-popup-body">
      <?php if (!empty($popupLink)): ?>
        <a href="<?= e($popupLink) ?>" class="mgm-popup-link" title="<?= e($popupTitle) ?>">
          <img src="<?= e($popupImage) ?>" alt="<?= e($popupTitle) ?>" class="mgm-popup-img" loading="eager">
        </a>
      <?php else: ?>
        <img src="<?= e($popupImage) ?>" alt="<?= e($popupTitle) ?>" class="mgm-popup-img" loading="eager">
      <?php endif; ?>
    </div>

    <!-- Optional Action Button Bar -->
    <?php if (!empty($popupLink)): ?>
      <div class="mgm-popup-action-bar">
        <a href="<?= e($popupLink) ?>" class="btn btn-sm btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm">
          <span><?= !empty($popupTitle) ? e($popupTitle) : 'View Details' ?></span>
          <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<style>
.mgm-popup-overlay {
  position: fixed;
  inset: 0;
  width: 100%;
  height: 100%;
  background: rgba(10, 15, 29, 0.78);
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  z-index: 9999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.35s ease, visibility 0.35s ease;
}
.mgm-popup-overlay.show {
  opacity: 1;
  visibility: visible;
}
.mgm-popup-dialog {
  position: relative;
  max-width: 540px;
  width: 100%;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  transform: scale(0.85);
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.mgm-popup-overlay.show .mgm-popup-dialog {
  transform: scale(1);
}
.mgm-popup-close-btn {
  position: absolute;
  top: -16px;
  right: -16px;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: #ffffff;
  color: #1f2937;
  border: 2px solid rgba(0,0,0,0.12);
  box-shadow: 0 4px 15px rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 19px;
  cursor: pointer;
  z-index: 10000001;
  transition: all 0.25s ease;
}
.mgm-popup-close-btn:hover {
  background: var(--tp-theme-primary, #ab0c2f);
  color: #ffffff;
  transform: rotate(90deg) scale(1.08);
}
.mgm-popup-body {
  width: 100%;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 25px 60px rgba(0,0,0,0.45);
  background: #ffffff;
}
.mgm-popup-link {
  display: block;
  text-decoration: none;
}
.mgm-popup-img {
  width: 100%;
  height: auto;
  max-height: 80vh;
  object-fit: contain;
  display: block;
}
.mgm-popup-action-bar {
  margin-top: 14px;
}
@media (max-width: 576px) {
  .mgm-popup-overlay {
    padding: 14px;
  }
  .mgm-popup-dialog {
    max-width: 94vw;
  }
  .mgm-popup-close-btn {
    top: -12px;
    right: -10px;
    width: 36px;
    height: 36px;
    font-size: 16px;
  }
  .mgm-popup-img {
    max-height: 72vh;
  }
}
</style>

<script>
(function() {
  function initMgmPopup() {
    var modal = document.getElementById('mgmPopupModal');
    var closeBtn = document.getElementById('mgmPopupCloseBtn');
    if (!modal) return;

    // Check if dismissed in current browser session
    if (sessionStorage.getItem('mgm_popup_dismissed') === '1') {
      return;
    }

    // Smooth entrance after slight delay
    setTimeout(function() {
      modal.style.display = 'flex';
      modal.offsetHeight; // trigger reflow
      modal.classList.add('show');
    }, 600);

    function closePopup() {
      modal.classList.remove('show');
      sessionStorage.setItem('mgm_popup_dismissed', '1');
      setTimeout(function() {
        modal.style.display = 'none';
      }, 350);
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closePopup();
      });
    }

    // Close on clicking backdrop
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        closePopup();
      }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && modal.classList.contains('show')) {
        closePopup();
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMgmPopup);
  } else {
    initMgmPopup();
  }
})();
</script>
