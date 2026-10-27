<?php
/**
 * Gallery View - MGM Model School
 * Exact BVB Manvila Layout & Alignment (3-Column Grid, 16:11 Aspect Ratio, Top-Right Zoom Button, Hover Overlay)
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "gallery";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Photo Gallery";
$breadcrumbTitle = "Gallery";
$metaDescription = "Explore authentic photographic memories reflecting academic rigor, vibrant cultural fests, sports milestones, and campus life at MGM Model School.";
$wpId = 15937;

// Fetch all active gallery events from database
$db = getDB();
$stmt = $db->query("SELECT * FROM gallery WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$galleryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<!-- BVB Manvila Exact Gallery Section Layout & Alignment -->
<section class="bvb-gallery-section bg-white py-5">
  <div class="container bvb-gallery-container">

    <!-- Section Header (Clean, Balanced Typography) -->
    <div class="section-header text-center mb-4">
      <span class="section-badge text-uppercase fw-bold" style="color: var(--tp-theme-primary, #ab0c2f); font-size: 12px; letter-spacing: 1.5px; display: inline-block; margin-bottom: 0.5rem;">
        MOMENTS AT MGM
      </span>
      <h2 class="section-title fw-bold text-dark mb-2" style="font-size: clamp(26px, 3.5vw, 36px); letter-spacing: -0.5px;">
        EXPLORE OUR VISUAL STORIES
      </h2>
      <p class="section-subtitle text-muted mx-auto mb-0" style="max-width: 650px; font-size: 15px; line-height: 1.6;">
        Click on any photograph to view high-resolution details in the lightbox viewer.
      </p>
    </div>

    <!-- Keyword Search Box (Sleek Centered Pill Style from BVB Manvila) -->
    <div class="gallery-search-container">
      <div class="gallery-search-box">
        <svg class="gallery-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="gallerySearchInput" class="gallery-search-input" placeholder="Search photos by keywords (e.g. sports, arts, investiture, science...)" autocomplete="off" aria-label="Search gallery images by keyword">
        <button type="button" id="gallerySearchClear" class="gallery-search-clear" aria-label="Clear search" title="Clear search" style="display: none;">
          &times;
        </button>
      </div>
      <div id="gallerySearchMeta" class="gallery-search-meta"></div>
    </div>

    <!-- Category Filter Pills (Exact BVB Manvila Alignment & Styling) -->
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

    <!-- Empty State Container when no images match -->
    <div id="galleryNoResults" class="gallery-no-results" style="display: none;">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        <line x1="8" y1="11" x2="14" y2="11"></line>
      </svg>
      <h4 class="fw-bold mt-3 mb-2">No matching photos found</h4>
      <p class="text-muted mb-3">We couldn't find any photos matching "<span class="no-results-query"></span>". Try another keyword or browse all categories.</p>
      <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-4 btn-clear-search">Show All Photos</button>
    </div>

    <!-- Gallery Grid (Exact BVB Manvila 3-Column Layout, 16:11 Aspect Ratio, Top-Right Zoom Button) -->
    <div class="gallery-grid" id="publicGalleryGrid">
      <?php foreach ($galleryItems as $idx => $item): 
        $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $item['category'] ?? 'general'));
        $catLabel = $item['category'] ?? 'Campus';
        $itemImg = asset_url($item['image_path']);
        $subtitle = $item['subtitle'] ?? $item['caption'] ?? '';
        $eventDate = !empty($item['event_date']) ? $item['event_date'] : date('F d, Y', strtotime($item['created_at']));

        // Parse sub-images
        $rawSub = !empty($item['sub_images']) ? json_decode($item['sub_images'], true) : [];
        $subUrls = [];
        if (is_array($rawSub)) {
            foreach ($rawSub as $subPath) {
                if (!empty($subPath)) {
                    $subUrls[] = asset_url($subPath);
                }
            }
        }
      ?>
        <div class="gallery-item" 
             data-id="<?= $item['id'] ?>"
             data-index="<?= $idx ?>"
             data-category="<?= e($catSlug) ?>"
             data-category-label="<?= e($catLabel) ?>"
             data-title="<?= e($item['title']) ?>"
             data-subtitle="<?= e($subtitle) ?>"
             data-date="<?= e($eventDate) ?>"
             data-main-img="<?= $itemImg ?>"
             data-sub-images='<?= json_encode($subUrls) ?>'>
          
          <img src="<?= $itemImg ?>" alt="<?= e($item['title']) ?>" loading="lazy">
          
          <!-- Hover Overlay (Exact BVB Manvila Gradient with Gold Badge & White Typography) -->
          <div class="gallery-overlay">
            <span class="gallery-overlay-badge"><?= strtoupper(e($catLabel)) ?></span>
            <span class="gallery-overlay-title"><?= e($item['title']) ?></span>
            <?php if (!empty($subtitle)): ?>
              <span class="gallery-overlay-subtitle"><?= e($subtitle) ?></span>
            <?php else: ?>
              <span class="gallery-overlay-subtitle"><?= e($eventDate) ?></span>
            <?php endif; ?>
          </div>

          <!-- BVB Manvila Floating Top-Right Zoom Icon Button -->
          <div class="gallery-zoom-icon" aria-label="Zoom photograph">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
</section>

<!-- Lightbox Modal Component (Clean, Borderless, Frameless) -->
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

    <!-- Event-Specific Sub-Images Strip -->
    <div class="lightbox-thumbs-wrap" id="lightboxThumbsSection" style="display: none;">
      <button type="button" class="lightbox-thumb-scroll-btn thumb-scroll-prev" id="thumbScrollPrev" aria-label="Scroll left">
        <i class="fa-solid fa-angle-left"></i>
      </button>
      <div class="lightbox-thumbs-track" id="lightboxThumbsTrack"></div>
      <button type="button" class="lightbox-thumb-scroll-btn thumb-scroll-next" id="thumbScrollNext" aria-label="Scroll right">
        <i class="fa-solid fa-angle-right"></i>
      </button>
    </div>

  </div>
</div>

<!-- Embedded BVB Manvila Exact CSS Rules -->
<style>
/* BVB Manvila Exact Layout & Alignment System */
.bvb-gallery-section {
  background-color: #FFFFFF;
  padding-top: 3.5rem;
  padding-bottom: 5rem;
}

.bvb-gallery-container {
  max-width: 1240px !important;
  width: 100%;
  margin-left: auto !important;
  margin-right: auto !important;
  padding-left: 20px;
  padding-right: 20px;
}

.gallery-search-container {
  max-width: 540px;
  margin: 0 auto 1.75rem auto;
  position: relative;
  width: 100%;
}

.gallery-search-box {
  position: relative;
  display: flex;
  align-items: center;
  background: #FFFFFF;
  border: 1.5px solid #E2E8F0;
  border-radius: 9999px;
  padding: 0.35rem 0.5rem 0.35rem 1.25rem;
  box-shadow: 0 4px 15px rgba(6, 43, 92, 0.05);
  transition: all 0.25s ease;
}

.gallery-search-box:focus-within {
  border-color: #0B4EA2;
  box-shadow: 0 6px 20px rgba(11, 78, 162, 0.15);
}

.gallery-search-icon {
  color: #94A3B8;
  flex-shrink: 0;
  margin-right: 0.75rem;
  transition: color 0.2s ease;
}

.gallery-search-box:focus-within .gallery-search-icon {
  color: #0B4EA2;
}

.gallery-search-input {
  flex: 1;
  border: none;
  background: transparent;
  outline: none;
  font-family: inherit;
  font-size: 0.95rem;
  color: #0B1329;
  padding: 0.5rem 0;
}

.gallery-search-input::placeholder {
  color: #94A3B8;
}

.gallery-search-clear {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  border: none;
  background: #E2E8F0;
  color: #64748B;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-right: 4px;
}

.gallery-search-clear:hover {
  background: #CBD5E1;
  color: #0F172A;
}

.gallery-search-meta {
  text-align: center;
  font-size: 0.85rem;
  color: #64748B;
  margin-top: 0.5rem;
}

/* Category Filter Buttons */
.gallery-filters {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 2.5rem;
}

.filter-btn {
  background-color: #FFFFFF;
  color: #475569;
  font-family: inherit;
  font-size: 0.8125rem;
  font-weight: 600;
  padding: 0.5rem 1.25rem;
  border-radius: 9999px;
  border: 1px solid #E2E8F0;
  cursor: pointer;
  transition: all 0.2s ease;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.filter-btn:hover {
  background-color: #F8FAFC;
  border-color: #CBD5E1;
  color: #0F172A;
}

.filter-btn.active {
  background-color: #0B4EA2 !important;
  color: #FFFFFF !important;
  border-color: #0B4EA2 !important;
  box-shadow: 0 4px 10px rgba(11, 78, 162, 0.25);
}

/* 3-Column Gallery Grid */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  width: 100%;
  margin: 0 auto;
}

@media (max-width: 991px) {
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
  }
}

@media (max-width: 600px) {
  .gallery-grid {
    grid-template-columns: 1fr;
    gap: 1.25rem;
  }
}

/* Gallery Item with BVB Manvila Medium Sizing & Exact 16:11 Aspect Ratio */
.gallery-item {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  background-color: #FFFFFF;
  border: 1px solid #E2E8F0;
  aspect-ratio: 16 / 11;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
}

.gallery-item.hidden {
  display: none !important;
}

.gallery-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 28px rgba(11, 78, 162, 0.14);
  border-color: #0B4EA2;
}

.gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center center;
  display: block;
  background-color: #F8FAFC;
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.gallery-item:hover img {
  transform: scale(1.025); /* Subtle, elegant zoom - NOT overly cropped or zoomed */
}

/* BVB Manvila Floating Top-Right Zoom Button */
.gallery-zoom-icon {
  position: absolute;
  top: 0.85rem;
  right: 0.85rem;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(11, 78, 162, 0.85);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 2;
  transition: transform 0.25s ease, background 0.25s ease;
}

.gallery-item:hover .gallery-zoom-icon {
  transform: scale(1.08);
  background: #0B4EA2;
}

/* Hover Overlay: Dark Gradient, Gold Badge, Clean Typography */
.gallery-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(6, 43, 92, 0.92) 0%, rgba(6, 43, 92, 0.4) 55%, transparent 100%);
  opacity: 0;
  transition: opacity 0.3s ease;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 1.5rem;
  color: #FFFFFF;
  z-index: 1;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-overlay-badge {
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #F59E0B;
  letter-spacing: 0.08em;
  margin-bottom: 0.25rem;
  display: block;
}

.gallery-overlay-title {
  font-size: 1.05rem;
  font-weight: 700;
  color: #FFFFFF;
  line-height: 1.3;
  display: block;
  text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
}

.gallery-overlay-subtitle {
  font-size: 0.8rem;
  font-weight: 400;
  color: rgba(255, 255, 255, 0.88);
  line-height: 1.35;
  margin-top: 0.25rem;
  display: block;
}

/* Lightbox Styling */
.lightbox-modal {
  position: fixed;
  inset: 0;
  z-index: 99999;
  background-color: rgba(4, 27, 59, 0.94);
  backdrop-filter: blur(12px);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.25s ease, visibility 0.25s ease;
  padding: 1.5rem;
}

.lightbox-modal.active {
  opacity: 1;
  visibility: visible;
}

.lightbox-dialog {
  position: relative;
  max-width: 1100px;
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.lightbox-close {
  position: absolute;
  top: -45px;
  right: 0;
  background: transparent;
  border: none;
  color: #FFFFFF;
  font-size: 36px;
  cursor: pointer;
  line-height: 1;
  transition: transform 0.2s ease, color 0.2s ease;
}

.lightbox-close:hover {
  transform: scale(1.15);
  color: #F59E0B;
}

.lightbox-stage {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.lightbox-img-wrap {
  max-width: 100%;
  max-height: 75vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lightbox-img {
  max-width: 100%;
  max-height: 75vh;
  border-radius: 12px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
  object-fit: contain;
}

.lightbox-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255, 255, 255, 0.25);
  color: #FFFFFF;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.lightbox-nav:hover {
  background: #0B4EA2;
  color: #FFFFFF;
}

.lightbox-prev {
  left: -60px;
}

.lightbox-next {
  right: -60px;
}

@media (max-width: 1200px) {
  .lightbox-prev { left: 10px; }
  .lightbox-next { right: 10px; }
}

.lightbox-thumbs-wrap {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 1.5rem;
  max-width: 90%;
  overflow: hidden;
}

.lightbox-thumbs-track {
  display: flex;
  gap: 10px;
  overflow-x: auto;
  scroll-behavior: smooth;
  padding: 4px;
}

.lightbox-thumb-img {
  width: 68px;
  height: 48px;
  object-fit: cover;
  border-radius: 6px;
  opacity: 0.6;
  cursor: pointer;
  border: 2px solid transparent;
  transition: all 0.2s ease;
}

.lightbox-thumb-img:hover, .lightbox-thumb-img.active {
  opacity: 1;
  border-color: #0B4EA2;
}
</style>

<script src="<?= asset_url('js/gallery.js') ?>"></script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
