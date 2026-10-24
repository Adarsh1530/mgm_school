<?php
/**
 * Gallery View
 * MGM Model School Recreation Project - 3x3 Framed Image Grid
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "gallery";
$page = get_page_by_slug($currentSlug);

$pageTitle = "Gallery";
$breadcrumbTitle = "Gallery";
$metaDescription = "Explore the vibrant campus life, modern facilities, events, and sports at MGM Model School.";
$wpId = 15937;

// Fetch all active gallery images
$db = getDB();
$stmt = $db->query("SELECT * FROM gallery WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$galleryItems = $stmt->fetchAll();

// Extract categories
$categories = [];
foreach ($galleryItems as $item) {
    if (!empty($item['category']) && !in_array($item['category'], $categories)) {
        $categories[] = $item['category'];
    }
}

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="tp-subpage-container py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <!-- Filter Navigation (No duplicate "Gallery" text) -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
      <div>
        <span class="text-uppercase fw-bold text-muted" style="font-size: 12px; letter-spacing: 1px;">Photo Catalog</span>
        <h4 class="fw-bold text-dark mb-0" style="font-size: 22px;">Campus Life &amp; Institutional Milestones</h4>
      </div>
      
      <!-- Category Filter Pills -->
      <div class="d-flex flex-wrap gap-2" id="gallery-filter-btns">
        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 active" data-filter="all" style="font-weight: 600;">
          All (<?= count($galleryItems) ?>)
        </button>
        <?php foreach ($categories as $cat): ?>
          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-filter="<?= e(strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $cat))) ?>" style="font-weight: 600;">
            <?= e($cat) ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 3x3 Framed Image Grid -->
    <div class="row g-4" id="gallery-grid">
      <?php foreach ($galleryItems as $item): 
        $catSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $item['category'] ?? 'general'));
      ?>
        <div class="col-lg-4 col-md-6 col-12 gallery-item" data-category="<?= e($catSlug) ?>">
          <div class="mgm-gallery-frame h-100">
            <div class="mgm-gallery-img-wrap">
              <a href="<?= asset_url($item['image_path']) ?>" target="_blank" title="<?= e($item['title']) ?>">
                <img src="<?= asset_url($item['image_path']) ?>" alt="<?= e($item['title']) ?>" class="mgm-framed-img">
                <div class="mgm-gallery-overlay">
                  <span class="mgm-zoom-icon"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></span>
                </div>
              </a>
            </div>
            <div class="mgm-gallery-info">
              <span class="badge bg-light text-muted border small mb-1"><?= e($item['category'] ?? 'Campus') ?></span>
              <h6 class="fw-bold text-dark mb-0 text-truncate" title="<?= e($item['title']) ?>"><?= e($item['title']) ?></h6>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<style>
/* 3x3 Framed Gallery Styling */
.mgm-gallery-frame {
  background: #ffffff;
  padding: 12px;
  border-radius: 14px;
  box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
  border: 1px solid #E2E8F0;
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
  display: flex;
  flex-direction: column;
}

.mgm-gallery-frame:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
  border-color: var(--tp-theme-primary, #ab0c2f);
}

.mgm-gallery-img-wrap {
  position: relative;
  width: 100%;
  height: 250px;
  border-radius: 10px;
  overflow: hidden;
  background: #F1F5F9;
}

.mgm-framed-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
}

.mgm-gallery-frame:hover .mgm-framed-img {
  transform: scale(1.05);
}

.mgm-gallery-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.25s ease;
}

.mgm-gallery-frame:hover .mgm-gallery-overlay {
  opacity: 1;
}

.mgm-zoom-icon {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #ffffff;
  color: var(--tp-theme-primary, #ab0c2f);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.mgm-gallery-info {
  padding: 12px 6px 4px 6px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const filterBtns = document.querySelectorAll('#gallery-filter-btns button');
  const items = document.querySelectorAll('.gallery-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      filterBtns.forEach(b => {
        b.classList.remove('btn-danger', 'active');
        b.classList.add('btn-outline-secondary');
      });
      this.classList.remove('btn-outline-secondary');
      this.classList.add('btn-danger', 'active');

      const filter = this.getAttribute('data-filter');
      items.forEach(item => {
        if (filter === 'all' || item.getAttribute('data-category') === filter) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });
});
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
