import os
from highlights_data import HIGHLIGHTS_DATA

def generate_view_file(item):
    slug = item['slug']
    title = item['title']
    full_title = item['full_title']
    category_key = item['category_key']
    category_name = item['category_name']
    badge = item['badge']
    icon = item['icon']
    image = item['image']
    gallery = item.get('gallery', [image])
    video = item.get('video')
    video_poster = item.get('video_poster', image)
    lead = item['lead']
    overview = item['overview']
    pillars = item['pillars']
    factsheet = item['factsheet']

    view_content = f"""<?php
/**
 * {full_title} View
 * MGM Model School Campus Highlights
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "{slug}";
$pageTitle = "{title}";
$breadcrumbTitle = "{title}";
$metaDescription = "{lead.replace('"', '&quot;')}";

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="highlight-detail-page py-5" style="background: #FAF8F5; min-height: 100vh;">
  <div class="container custom-container-larg">

    <!-- Top Navigation Return & Category Pill -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
      <a href="<?= rtrim(BASE_URL, '/') ?>/highlights/" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
        <i class="fa-solid fa-arrow-left"></i> Back to All Highlights
      </a>
      <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white shadow-sm border">
        <i class="{icon} text-danger"></i>
        <span class="text-uppercase fw-bold small text-muted" style="letter-spacing: 1px;">{category_name}</span>
      </div>
    </div>

    <!-- Main Header Banner -->
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-5 bg-white">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(171, 12, 47, 0.08); color: var(--tp-theme-primary, #ab0c2f);">
            <i class="fa-solid fa-star"></i>
            <span class="fw-bold small">{badge}</span>
          </div>
          <h1 class="fw-bold text-dark mb-3" style="font-size: clamp(28px, 4vw, 42px); line-height: 1.25;">
            {full_title}
          </h1>
          <p class="text-secondary mb-0 leading-relaxed" style="font-size: 17px; line-height: 1.8;">
            {lead}
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="<?= rtrim(BASE_URL, '/') ?>/contact/" class="btn btn-danger rounded-pill px-4 py-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
            <i class="fa-solid fa-calendar-check"></i> Book Campus Tour
          </a>
        </div>
      </div>
    </div>
"""

    if video:
        view_content += f"""
    <!-- Featured Video Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark">
      <div class="p-3 bg-dark border-bottom border-secondary d-flex align-items-center justify-content-between text-white flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-danger px-2 py-1"><i class="fa-solid fa-circle-play me-1"></i> VIDEO SHOWCASE</span>
          <strong class="text-white small text-uppercase" style="letter-spacing: 0.5px;">{title} in Action &bull; MGM Model School</strong>
        </div>
        <span class="badge bg-light text-dark small"><i class="fa-solid fa-video me-1"></i> High Definition MP4</span>
      </div>
      <div class="p-2 p-md-4 text-center bg-black">
        <video id="highlightVideo_{slug.replace('-', '_')}" 
               class="w-100 rounded-3 shadow" 
               controls 
               playsinline 
               preload="metadata" 
               poster="<?= rtrim(BASE_URL, '/') ?>/{video_poster}"
               style="max-height: 560px; object-fit: contain; background: #000;">
          <source src="<?= rtrim(BASE_URL, '/') ?>/{video}" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
      </div>
      <div class="p-3 bg-white text-muted small border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span><i class="fa-solid fa-circle-info text-danger me-1"></i> Official demonstration &bull; MGM Model School, Ayiroor, Varkala</span>
        <span class="badge bg-light text-secondary border">Academic Year 2025-2026</span>
      </div>
    </div>
"""
    else:
        view_content += f"""
    <!-- Featured High-Resolution Showcase Image -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
      <div class="position-relative" style="max-height: 520px; overflow: hidden;">
        <img src="<?= rtrim(BASE_URL, '/') ?>/{image}" alt="{title}" class="w-100 h-100" style="object-fit: cover; min-height: 380px; max-height: 520px;">
        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
          <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold"><i class="{icon} me-1"></i> {title}</span>
        </div>
      </div>
    </div>
"""

    view_content += f"""
    <!-- In-Depth Overview & Key Pillars -->
    <div class="row g-4 mb-5">
      <!-- Left Column: Detailed Overview -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100">
          <h3 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
            <span style="width: 8px; height: 28px; background: var(--tp-theme-primary, #ab0c2f); border-radius: 4px; display: inline-block;"></span>
            Educational Vision &amp; Facility Overview
          </h3>
          <p class="text-secondary leading-relaxed mb-4" style="font-size: 16px; line-height: 1.85;">
            {overview}
          </p>

          <!-- Core Pillars Grid -->
          <h4 class="fw-bold text-dark mb-3 mt-4" style="font-size: 20px;">Key Features &amp; Student Advantages</h4>
          <div class="row g-3">
"""

    for p in pillars:
        view_content += f"""            <div class="col-md-6">
              <div class="p-3 rounded-4 h-100 border bg-light">
                <div class="d-flex align-items-center gap-2 mb-2 text-danger">
                  <i class="{p['icon']} fs-5"></i>
                  <h6 class="fw-bold text-dark mb-0">{p['title']}</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.6;">{p['desc']}</p>
              </div>
            </div>
"""

    view_content += f"""          </div>
        </div>
      </div>

      <!-- Right Column: Factsheet -->
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 bg-white h-100">
          <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
            <i class="fa-solid fa-list-check text-danger"></i> Facility Highlights at a Glance
          </h5>
          <div class="d-flex flex-column gap-3">
"""

    for f in factsheet:
        view_content += f"""            <div class="p-3 rounded-3" style="background: #FDFBF8; border-left: 3px solid var(--tp-theme-primary, #ab0c2f);">
              <span class="text-uppercase text-muted fw-bold d-block" style="font-size: 11px; letter-spacing: 0.5px;">{f['label']}</span>
              <strong class="text-dark d-block mt-1" style="font-size: 14.5px;">{f['value']}</strong>
            </div>
"""

    view_content += f"""          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
"""

    out_path = os.path.join('views', f"{slug}.php")
    with open(out_path, 'w', encoding='utf-8') as f:
        f.write(view_content)
    print(f"Generated {out_path} ({len(view_content)} bytes)")

for item in HIGHLIGHTS_DATA:
    generate_view_file(item)

print("All 21 highlight views successfully regenerated without Explore Other Highlights and CTA banner!")
