<?php
/**
 * Mandatory Disclosure View
 * Exact Visual Recreation of Reference WordPress Website with Authentic School Documents
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "mandatory-disclosure";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Mandatory Disclosure";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "Mandatory public disclosures for MGM Model School, Ayiroor, Varkala.";
$wpId = 16051;

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<!-- Original Elementor Disclosure Tables -->
<?= render_content($page['content_html']) ?>

<!-- Mandatory Disclosure Interactive Image Modal Viewer -->
<div id="disclosureViewerModal" class="mgm-disclosure-modal" role="dialog" aria-modal="true" style="display: none;">
  <div class="mgm-disclosure-backdrop" onclick="closeDisclosureModal()"></div>
  <div class="mgm-disclosure-container">
    <div class="mgm-disclosure-header">
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-file-image text-danger fs-5"></i>
        <h5 id="disclosureModalTitle" class="fw-bold mb-0 text-white">Document Viewer</h5>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a id="disclosureModalNewTab" href="#" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3" rel="noopener noreferrer">
          <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Open Full View
        </a>
        <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm" onclick="closeDisclosureModal()" aria-label="Close" style="width: 36px; height: 36px; padding: 0; line-height: 36px; font-weight: bold; font-size: 20px;">
          &times;
        </button>
      </div>
    </div>
    <div class="mgm-disclosure-body text-center p-2 p-md-3">
      <img id="disclosureModalImg" src="" alt="Mandatory Disclosure Document" class="img-fluid rounded-4 shadow-lg" style="max-height: 82vh; max-width: 100%; object-fit: contain; background: #fff;">
    </div>
  </div>
</div>

<style>
.mgm-disclosure-modal {
  position: fixed;
  inset: 0;
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 15px;
}
.mgm-disclosure-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.88);
  backdrop-filter: blur(6px);
}
.mgm-disclosure-container {
  position: relative;
  z-index: 100000;
  max-width: 950px;
  width: 100%;
  max-height: 96vh;
  display: flex;
  flex-direction: column;
}
.mgm-disclosure-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
  padding: 0 4px;
}
.disclosure-doc-link {
  cursor: pointer;
  transition: transform 0.2s ease, opacity 0.2s ease;
}
.disclosure-doc-link:hover {
  opacity: 0.88;
}
.elementor-image-box-wrapper:hover .attachment-full {
  transform: translateY(-4px) scale(1.04);
  transition: transform 0.25s ease;
}
.elementor-image-box-wrapper .attachment-full {
  transition: transform 0.25s ease;
}
</style>

<script>
function openDisclosureModal(imgSrc, title) {
  var modal = document.getElementById('disclosureViewerModal');
  var img = document.getElementById('disclosureModalImg');
  var titleEl = document.getElementById('disclosureModalTitle');
  var newTabBtn = document.getElementById('disclosureModalNewTab');
  if (modal && img) {
    img.src = imgSrc;
    if (titleEl) titleEl.textContent = title;
    if (newTabBtn) newTabBtn.href = imgSrc;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }
}

function closeDisclosureModal() {
  var modal = document.getElementById('disclosureViewerModal');
  if (modal) {
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.disclosure-doc-link').forEach(function(el) {
    el.addEventListener('click', function(e) {
      var img = this.getAttribute('data-doc-img');
      var title = this.getAttribute('data-doc-title') || 'Document Viewer';
      if (img) {
        e.preventDefault();
        openDisclosureModal(img, title);
      }
    });
  });
});

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeDisclosureModal();
  }
});
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
