<?php
/**
 * Gallery View
 * MGM Model School - Exact BVB Manvila Layout & Functional Structure
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "gallery";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Photo Gallery";
$breadcrumbTitle = "Gallery";
$metaDescription = "Explore authentic photographic memories reflecting academic rigor, vibrant cultural fests, sports milestones, and campus life at MGM Model School.";
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

<div class="gallery-section-wrapper">
  <div class="container custom-container-larg">
    
    <!-- Section Header (Exact BVB Manvila Layout) -->
    <div class="section-header text-center">
      <span class="section-badge">MOMENTS AT MGM</span>
      <h2 class="section-title">EXPLORE OUR VISUAL STORIES</h2>
      <p class="section-subtitle">Click on any photograph to view high-resolution details in the lightbox viewer.</p>
    </div>

    <!-- Keyword Search Option (Exact BVB Manvila Layout) -->
    <div class="gallery-search-container">
      <div class="gallery-search-box">
        <svg class="gallery-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="gallerySearchInput" class="gallery-search-input" placeholder="Search photos by keywords (e.g. sports, robotics, water award, principal, science...)" autocomplete="off" aria-label="Search gallery images by keyword">
        <button type="button" id="gallerySearchClear" class="gallery-search-clear" aria-label="Clear search" title="Clear search" style="display: none;">
          &times;
        </button>
      </div>
      <div id="gallerySearchMeta" class="gallery-search-meta"></div>
    </div>

    <!-- Category Filter Buttons (Exact BVB Manvila Layout) -->
    <div class="gallery-filters" id="galleryFilterBtns">
      <button type="button" class="filter-btn active" data-filter="all">ALL</button>
      <?php foreach ($categories as $cat): 
        $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $cat));
      ?>
        <button type="button" class="filter-btn" data-filter="<?= e($catSlug) ?>">
          <?= strtoupper(e($cat)) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Empty State Container when no images match (Exact BVB Manvila Layout) -->
    <div id="galleryNoResults" class="gallery-no-results" style="display: none;">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        <line x1="8" y1="11" x2="14" y2="11"></line>
      </svg>
      <h4>No matching photos found</h4>
      <p>We couldn't find any photos matching "<span class="no-results-query"></span>". Try another keyword or browse all categories.</p>
      <button type="button" class="btn btn-primary btn-pill btn-sm btn-clear-search">Show All Photos</button>
    </div>

    <!-- Gallery Grid (Exact BVB Manvila Layout) -->
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
          <img src="<?= $itemImg ?>" alt="<?= e($item['title']) ?>" loading="lazy">
          <div class="gallery-overlay">
            <span class="gallery-overlay-badge"><?= strtoupper(e($catLabel)) ?></span>
            <span class="gallery-overlay-title"><?= e($item['title']) ?></span>
            <?php if (!empty($item['caption'])): ?>
              <span class="gallery-overlay-subtitle"><?= e($item['caption']) ?></span>
            <?php endif; ?>
          </div>
          <div class="gallery-zoom-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              <line x1="11" y1="8" x2="11" y2="14"></line>
              <line x1="8" y1="11" x2="14" y2="11"></line>
            </svg>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<!-- Lightbox Modal Component (Exact BVB Manvila Layout with Related Thumbnails Strip) -->
<div class="lightbox-modal" id="gallery-lightbox" role="dialog" aria-modal="true" aria-label="Photo Lightbox Viewer">
  <div class="lightbox-dialog">
    <button type="button" class="lightbox-close" aria-label="Close Lightbox" id="lightboxClose">&times;</button>
    
    <div class="lightbox-stage">
      <button type="button" class="lightbox-nav lightbox-prev" aria-label="Previous image" id="lightboxPrev">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </button>

      <div class="lightbox-img-wrap">
        <img src="" alt="" class="lightbox-img" id="lightboxImg">
      </div>

      <button type="button" class="lightbox-nav lightbox-next" aria-label="Next image" id="lightboxNext">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </button>
    </div>

    <div class="lightbox-info">
      <div class="lightbox-caption" id="lightboxCaption"></div>
      <div class="lightbox-counter" id="lightboxCounter"></div>
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
        <div class="lightbox-thumbs-track" id="lightboxThumbsTrack"></div>
        <button type="button" class="lightbox-thumb-scroll-btn thumb-scroll-next" id="thumbScrollNext" aria-label="Scroll thumbnails right">
          <i class="fa-solid fa-angle-right"></i>
        </button>
      </div>
    </div>

  </div>
</div>

<script src="<?= asset_url('js/gallery.js') ?>"></script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
