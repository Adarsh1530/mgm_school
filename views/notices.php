<?php
/**
 * Notices, Announcements & Events View
 * MGM Model School Recreation Project
 * Inspired by Rani Jai HSS News & Events Architecture
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "notices";
$pageTitle = "Notices & Announcements";
$breadcrumbTitle = "Notices";
$metaDescription = "Latest notices, circulars, admission announcements, academic honors, and campus events of MGM Model School, Ayiroor, Varkala.";

$allNotices = get_active_notices();

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="tp-subpage-container py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Top Header -->
    <div class="text-center mb-5">
      <span class="badge px-3 py-2 text-uppercase mb-2" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700;">
        <i class="fa-solid fa-bullhorn me-1"></i> Campus Updates
      </span>
      <h2 class="tp-section-title mb-2" style="font-size: 34px; font-weight: 700; color: #141B2B;">News, Announcements &amp; Events</h2>
      <p class="text-muted mx-auto" style="max-width: 720px;">
        Stay connected with official circulars, admission registrations, board examination distinctions, state honors, and campus celebrations of MGM Model School Ayiroor, Varkala.
      </p>

      <!-- Category Filter Tabs -->
      <div class="d-flex flex-wrap justify-content-center gap-2 mt-4" id="noticeFilterTabs">
        <button type="button" class="btn btn-sm rounded-pill px-3 py-1 fw-bold active notice-filter-btn" data-category="all" style="background: var(--tp-theme-primary, #ab0c2f); color: #fff; border: 1px solid var(--tp-theme-primary, #ab0c2f);">
          All Updates
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold bg-white notice-filter-btn" data-category="Admission">
          <i class="fa-solid fa-user-graduate me-1 text-danger"></i> Admissions
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold bg-white notice-filter-btn" data-category="Academic">
          <i class="fa-solid fa-book-open me-1 text-success"></i> Academic
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold bg-white notice-filter-btn" data-category="Achievement">
          <i class="fa-solid fa-award me-1 text-primary"></i> Achievements
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold bg-white notice-filter-btn" data-category="Event">
          <i class="fa-solid fa-calendar-check me-1 text-info"></i> Events
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold bg-white notice-filter-btn" data-category="Sports">
          <i class="fa-solid fa-medal me-1 text-warning"></i> Sports
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold bg-white notice-filter-btn" data-category="Circular">
          <i class="fa-solid fa-scroll me-1 text-secondary"></i> Circulars
        </button>
      </div>
    </div>

    <!-- Main Notices Grid -->
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-9">
        
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
          <h4 class="fw-bold text-dark mb-0" style="font-size: 22px;">
            <i class="fa-solid fa-bullhorn text-danger me-2"></i>Official Notices &amp; Circulars
          </h4>
          <span class="badge bg-white text-dark border px-3 py-2 small fw-semibold shadow-sm" id="noticeCountBadge"><?= count($allNotices) ?> Notices Active</span>
        </div>

        <div class="d-flex flex-column gap-4" id="noticesListContainer">
          <?php foreach ($allNotices as $notice): 
            $cat = htmlspecialchars($notice['category']);
            $badgeColor = htmlspecialchars($notice['badge_color'] ?? 'primary');
            $img = !empty($notice['image_url']) ? asset_url(str_replace('assets/', '', $notice['image_url'])) : asset_url('images/Untitled-design-4.png');
          ?>
            <article class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white notice-item-card transition-all" 
                     id="notice-<?= htmlspecialchars($notice['slug']) ?>" 
                     data-category="<?= $cat ?>"
                     style="transition: transform 0.25s ease, box-shadow 0.25s ease;">
              <div class="row g-0">
                
                <!-- Notice Thumbnail -->
                <div class="col-md-5 position-relative">
                  <div style="height: 100%; min-height: 220px; max-height: 280px; overflow: hidden; background: #f1f5f9;">
                    <img src="<?= $img ?>" 
                         alt="<?= htmlspecialchars($notice['title']) ?>" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                         class="notice-thumb-img">
                  </div>
                  <!-- Category Badge -->
                  <span class="badge position-absolute top-0 start-0 m-3 px-3 py-2 text-uppercase fw-bold rounded-pill shadow-sm"
                        style="background: var(--tp-theme-primary, #ab0c2f); color: #fff; font-size: 11px; letter-spacing: 0.5px;">
                    <?= $cat ?>
                  </span>
                </div>

                <!-- Notice Body -->
                <div class="col-md-7 d-flex flex-column justify-content-between p-4">
                  <div>
                    <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                      <i class="fa-regular fa-calendar-days text-danger"></i>
                      <span><?= htmlspecialchars($notice['display_date']) ?></span>
                      <span>&bull;</span>
                      <span class="text-secondary"><i class="fa-solid fa-building-columns me-1"></i> MGM Model School</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-2" style="font-size: 18px; line-height: 1.4;">
                      <?= htmlspecialchars($notice['title']) ?>
                    </h5>

                    <p class="text-secondary small mb-3" style="line-height: 1.6;">
                      <?= htmlspecialchars($notice['summary']) ?>
                    </p>
                  </div>

                  <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1 fw-bold notice-detail-btn"
                            data-bs-toggle="modal" 
                            data-bs-target="#noticeModal"
                            data-title="<?= htmlspecialchars($notice['title']) ?>"
                            data-category="<?= $cat ?>"
                            data-date="<?= htmlspecialchars($notice['display_date']) ?>"
                            data-img="<?= $img ?>"
                            data-pdf="<?= !empty($notice['pdf_url']) ? asset_url($notice['pdf_url']) : '' ?>"
                            data-summary="<?= htmlspecialchars($notice['summary']) ?>"
                            data-content="<?= htmlspecialchars($notice['content']) ?>">
                      Read Full Details <i class="fa-solid fa-arrow-right ms-1"></i>
                    </button>
                    <?php if (!empty($notice['pdf_url'])): ?>
                      <a href="<?= asset_url($notice['pdf_url']) ?>" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 py-1 fw-bold" style="background: var(--tp-theme-primary, #ab0c2f);">
                        <i class="fa-solid fa-file-pdf me-1"></i> View PDF
                      </a>
                    <?php endif; ?>
                  </div>
                </div>

              </div>
            </article>
          <?php endforeach; ?>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Notice Detailed View Modal -->
<div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
      
      <div class="modal-header border-0 pb-0" style="background: #ffffff;">
        <div>
          <span class="badge px-3 py-1 rounded-pill text-uppercase mb-2" id="modalCategoryBadge" style="background: var(--tp-theme-primary, #ab0c2f); color: #fff; font-size: 11px;"></span>
          <div class="text-muted small" id="modalDateText"></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4 pt-2">
        <h4 class="fw-bold text-dark mb-3" id="modalTitleText" style="line-height: 1.4;"></h4>
        
        <div class="rounded-3 overflow-hidden mb-3" id="modalImgWrapper" style="max-height: 360px; background: #f8fafc; display: none;">
          <img src="data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E" id="modalImg" alt="Notice Image" class="w-100" style="object-fit: cover; max-height: 360px;">
        </div>

        <div class="p-3 rounded-3 bg-light mb-3 border">
          <strong class="text-dark d-block mb-1 small text-uppercase" style="letter-spacing: 0.5px;">Summary:</strong>
          <p class="text-secondary small mb-0" id="modalSummaryText" style="line-height: 1.6;"></p>
        </div>

        <div class="text-dark" id="modalContentText" style="font-size: 14.5px; line-height: 1.7;"></div>
      </div>

      <div class="modal-footer border-0 pt-0 bg-light d-flex justify-content-between align-items-center">
        <div>
          <a href="#" id="modalPdfBtn" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 py-1 fw-bold" style="background: var(--tp-theme-primary, #ab0c2f); display: none;">
            <i class="fa-solid fa-file-pdf me-1"></i> View / Download Circular (PDF)
          </a>
        </div>
        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
// Filter Notices by Category
document.addEventListener('DOMContentLoaded', function() {
  const filterButtons = document.querySelectorAll('.notice-filter-btn');
  const noticeCards = document.querySelectorAll('.notice-item-card');
  const countBadge = document.getElementById('noticeCountBadge');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const selectedCat = this.getAttribute('data-category');
      
      // Update button active state
      filterButtons.forEach(b => {
        b.classList.remove('active');
        b.style.background = '#ffffff';
        b.style.color = '#334155';
        b.style.borderColor = '#cbd5e1';
      });
      this.classList.add('active');
      this.style.background = 'var(--tp-theme-primary, #ab0c2f)';
      this.style.color = '#ffffff';
      this.style.borderColor = 'var(--tp-theme-primary, #ab0c2f)';

      let visibleCount = 0;
      noticeCards.forEach(card => {
        const itemCat = card.getAttribute('data-category');
        if (selectedCat === 'all' || itemCat === selectedCat) {
          card.style.display = 'block';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      if (countBadge) {
        countBadge.innerText = visibleCount + ' Notices Active';
      }
    });
  });

  // Modal Populate
  const noticeModal = document.getElementById('noticeModal');
  if (noticeModal) {
    noticeModal.addEventListener('show.bs.modal', function(event) {
      const btn = event.relatedTarget;
      if (!btn) return;
      document.getElementById('modalTitleText').innerText = btn.getAttribute('data-title') || '';
      document.getElementById('modalCategoryBadge').innerText = btn.getAttribute('data-category') || '';
      document.getElementById('modalDateText').innerHTML = '<i class="fa-regular fa-calendar-days text-danger me-1"></i> ' + (btn.getAttribute('data-date') || '');
      const imgUrl = btn.getAttribute('data-img') || '';
      const imgWrapper = document.getElementById('modalImgWrapper');
      const modalImg = document.getElementById('modalImg');
      if (imgUrl) {
        modalImg.src = imgUrl;
        imgWrapper.style.display = 'block';
      } else {
        imgWrapper.style.display = 'none';
      }
      document.getElementById('modalSummaryText').innerText = btn.getAttribute('data-summary') || '';
      document.getElementById('modalContentText').innerText = btn.getAttribute('data-content') || '';
      
      const pdfUrl = btn.getAttribute('data-pdf') || '';
      const modalPdfBtn = document.getElementById('modalPdfBtn');
      if (modalPdfBtn) {
        if (pdfUrl) {
          modalPdfBtn.href = pdfUrl;
          modalPdfBtn.style.display = 'inline-flex';
        } else {
          modalPdfBtn.style.display = 'none';
        }
      }
    });
  }

  // Handle URL hash anchor jump (e.g. /notices/#notice-slug from homepage ticker)
  if (window.location.hash) {
    const targetId = window.location.hash.substring(1);
    setTimeout(() => {
      scrollToNotice(targetId);
    }, 400);
  }
});

function scrollToNotice(id) {
  const el = document.getElementById(id);
  if (el) {
    // Show all in case it was filtered out
    document.querySelectorAll('.notice-item-card').forEach(c => c.style.display = 'block');
    document.querySelectorAll('.notice-filter-btn').forEach(b => {
      if (b.getAttribute('data-category') === 'all') {
        b.click();
      }
    });

    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    el.style.boxShadow = '0 0 0 3px rgba(171, 12, 47, 0.4), 0 10px 25px -5px rgba(0, 0, 0, 0.1)';
    el.style.transform = 'translateY(-4px)';
    setTimeout(() => {
      el.style.boxShadow = '';
      el.style.transform = '';
    }, 2500);
  }
}
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
