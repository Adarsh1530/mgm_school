<?php
/**
 * Gallery View
 * MGM Model School - Interactive Searchable Gallery & Lightbox with Thumbnail Navigation
 * Inspired by BVB Manvila layout & functionality with MGM Model School styling
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "gallery";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Photo Gallery";
$breadcrumbTitle = "Gallery";
$metaDescription = "Explore the vibrant campus life, academic excellence, modern infrastructure, and student achievements at MGM Model School.";
$wpId = 15937;

// Fetch all active gallery images
$db = getDB();
$stmt = $db->query("SELECT * FROM gallery WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$galleryItems = $stmt->fetchAll();

// Extract unique categories preserving order
$categories = [];
foreach ($galleryItems as $item) {
    if (!empty($item['category']) && !in_array($item['category'], $categories)) {
        $categories[] = $item['category'];
    }
}

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="mgm-gallery-page py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Gallery Catalog Header -->
    <div class="mgm-gallery-header text-center mb-4 pb-2">
      <span class="mgm-gallery-sub-badge">CAMPUS ARCHIVES &amp; VISUAL MEMORIES</span>
      <h2 class="mgm-gallery-main-title mt-2 mb-2">Photo Gallery</h2>
      <p class="mgm-gallery-main-desc mx-auto text-muted" style="max-width: 650px; font-size: 15px;">
        Explore our vibrant campus life, modern facilities, cultural festivities, and student achievements at MGM Model School.
      </p>
    </div>

    <!-- Keyword Search Box (BVB Manvila layout & structure) -->
    <div class="gallery-search-container">
      <div class="gallery-search-box">
        <svg class="gallery-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="gallerySearchInput" class="gallery-search-input" placeholder="Search photos by keywords (e.g. sports, robotics, water award, principal, campus...)" autocomplete="off" aria-label="Search gallery images by keyword">
        <button type="button" id="gallerySearchClear" class="gallery-search-clear" aria-label="Clear search" title="Clear search" style="display: none;">
          &times;
        </button>
      </div>
      <div id="gallerySearchMeta" class="gallery-search-meta"></div>
    </div>

    <!-- Category Filter Buttons (BVB Manvila layout & structure) -->
    <div class="gallery-filters" id="galleryFilterBtns">
      <button type="button" class="filter-btn active" data-filter="all">ALL (<?= count($galleryItems) ?>)</button>
      <?php foreach ($categories as $cat): 
        $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $cat));
        $catCount = count(array_filter($galleryItems, fn($i) => ($i['category'] ?? '') === $cat));
      ?>
        <button type="button" class="filter-btn" data-filter="<?= e($catSlug) ?>">
          <?= strtoupper(e($cat)) ?> (<?= $catCount ?>)
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Empty State / No Results Box -->
    <div id="galleryNoResults" class="gallery-no-results" style="display: none;">
      <div class="gallery-no-results-icon">
        <i class="fa-solid fa-images"></i>
      </div>
      <h4 class="fw-bold text-dark mt-2 mb-1">No Matching Photos Found</h4>
      <p class="text-muted small mb-3">No images match "<span class="no-results-query fw-bold text-danger"></span>". Try another keyword or reset the filter.</p>
      <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-4 btn-clear-search">
        <i class="fa-solid fa-rotate-left me-1"></i> Clear Search &amp; View All
      </button>
    </div>

    <!-- Gallery Grid (BVB Manvila layout & structure) -->
    <div class="gallery-grid" id="publicGalleryGrid">
      <?php foreach ($galleryItems as $idx => $item): 
        $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $item['category'] ?? 'general'));
        $catLabel = $item['category'] ?? 'Campus';
        $itemImg = asset_url($item['image_path']);
      ?>
        <div class="gallery-item" 
             data-id="<?= $item['id'] ?>"
             data-index="<?= $idx ?>"
             data-category="<?= e($catSlug) ?>"
             data-category-label="<?= e($catLabel) ?>"
             data-title="<?= e($item['title']) ?>"
             data-caption="<?= e($item['caption'] ?? '') ?>"
             data-img="<?= $itemImg ?>">
          <div class="gallery-item-inner">
            <img src="<?= $itemImg ?>" alt="<?= e($item['title']) ?>" loading="lazy" class="gallery-img">
            <div class="gallery-overlay">
              <span class="gallery-overlay-badge"><?= strtoupper(e($catLabel)) ?></span>
              <h5 class="gallery-overlay-title"><?= e($item['title']) ?></h5>
              <?php if (!empty($item['caption'])): ?>
                <p class="gallery-overlay-subtitle"><?= e($item['caption']) ?></p>
              <?php endif; ?>
            </div>
            <div class="gallery-zoom-icon">
              <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<!-- Lightbox Modal Component with Main Image & Related Thumbnails (BVB Manvila layout & structure) -->
<div class="lightbox-modal" id="gallery-lightbox" role="dialog" aria-modal="true" aria-label="Photo Lightbox Viewer">
  <div class="lightbox-dialog">
    <!-- Close button -->
    <button type="button" class="lightbox-close" aria-label="Close Lightbox" id="lightboxClose">
      &times;
    </button>

    <!-- Main Image Stage with Next & Prev Buttons -->
    <div class="lightbox-stage">
      <button type="button" class="lightbox-nav lightbox-prev" aria-label="Previous image" id="lightboxPrev">
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <div class="lightbox-img-wrap">
        <img src="" alt="" class="lightbox-img" id="lightboxImg">
      </div>

      <button type="button" class="lightbox-nav lightbox-next" aria-label="Next image" id="lightboxNext">
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>

    <!-- Lightbox Caption & Counter -->
    <div class="lightbox-info">
      <div class="lightbox-text-wrap">
        <div class="d-flex align-items-center gap-2 mb-1">
          <span class="lightbox-cat-badge" id="lightboxCatBadge"></span>
          <span class="lightbox-counter" id="lightboxCounter"></span>
        </div>
        <h5 class="lightbox-title mb-1 text-white" id="lightboxTitle"></h5>
        <p class="lightbox-caption mb-0 text-white-50 small" id="lightboxCaption"></p>
      </div>
    </div>

    <!-- Related Thumbnails Below Main Image for Easy Navigation -->
    <div class="lightbox-thumbs-container" id="lightboxThumbsSection">
      <div class="lightbox-thumbs-header">
        <span class="lightbox-thumbs-label"><i class="fa-solid fa-images me-1"></i> <span id="lightboxThumbsHeading">Related Photos</span></span>
        <span class="lightbox-thumbs-counter" id="lightboxThumbsCount"></span>
      </div>
      <div class="lightbox-thumbs-scroll-wrap">
        <button type="button" class="lightbox-thumb-scroll-btn thumb-scroll-prev" id="thumbScrollPrev" aria-label="Scroll thumbnails left">
          <i class="fa-solid fa-angle-left"></i>
        </button>
        <div class="lightbox-thumbs-track" id="lightboxThumbsTrack">
          <!-- Dynamically populated thumbnail elements -->
        </div>
        <button type="button" class="lightbox-thumb-scroll-btn thumb-scroll-next" id="thumbScrollNext" aria-label="Scroll thumbnails right">
          <i class="fa-solid fa-angle-right"></i>
        </button>
      </div>
    </div>

  </div>
</div>

<script src="<?= asset_url('js/gallery.js') ?>"></script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
