import json
from exact_docx_data import DOCX_HIGHLIGHTS

slug_order = [
    'swimming-pool',
    'twenty-twenty-method',
    'libraries-at-mgm',
    'poly-house',
    'krishi-thottam',
    'amma-school',
    'vriksha-chikitsa',
    'counselling-centre',
    'innovation-centre',
    'gdc',
    'life-skills',
    'voice-of-mgm',
    'school-canteen',
    'butterfly-garden',
    '3d-max-zone',
    'ominis',
    'nova-ai-hub',
    'ncc',
    'hindustan-scouts-guides',
    'school-band-troop',
    'happiness-room'
]

highlights_list = []
for i, slug in enumerate(slug_order):
    d = DOCX_HIGHLIGHTS[slug]
    summary = d['paragraphs'][0] if d['paragraphs'] else d['title']
    details = " ".join(d['paragraphs'][1:]) if len(d['paragraphs']) > 1 else summary
    tags = [f['value'] for f in d['factsheet'][:3]]

    highlights_list.append({
        'id': slug,
        'order': i + 1,
        'title': d['title'],
        'category_key': d['category_key'],
        'category_name': d['category_name'],
        'image': d['image'],
        'icon': d['icon'],
        'url': f"/{slug}/",
        'has_dedicated_page': True,
        'summary': summary,
        'details': details,
        'bullets': d['bullets'],
        'tags': [d['badge'], d['factsheet'][0]['value']]
    })

php_content = f"""<?php
/**
 * Campus Highlights Module
 * Exact Content from HIGHLIGHTS -1.docx
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = 'highlights';
$pageTitle = 'Campus Highlights';
$breadcrumbTitle = 'Highlights';
$metaDescription = 'Explore the distinctive campus highlights of MGM Model School, Ayiroor, Varkala — from our National Water Award recognition to our swimming pool, 20-20 teaching method, robotics, and eco-initiatives.';

$highlights = json_decode(<<<'JSON'
{json.dumps(highlights_list, indent=2)}
JSON
, true);

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="highlights-page-wrapper" style="background: #FAF8F5; min-height: 100vh;">
  
  <!-- Hero / Introduction Area -->
  <div class="highlights-header-banner text-center text-white" style="background: linear-gradient(135deg, #141B2B 0%, #2A1724 50%, #800000 100%); padding: 65px 0 50px;">
    <div class="container custom-container-larg position-relative" style="z-index: 2;">
      <span class="highlights-badge-pill mb-3 d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-danger text-white fw-bold small">
        <i class="fa-solid fa-star"></i> Distinctive Excellence &bull; MGM Model School
      </span>
      <h1 class="highlights-title fw-bold text-white mb-3" style="font-size: clamp(32px, 4.5vw, 48px);">Campus Highlights &amp; Distinctive Facilities</h1>
      <p class="highlights-lead text-light mx-auto mb-0" style="max-width: 820px; font-size: 17px; opacity: 0.95; line-height: 1.8;">
        Discover the hallmark initiatives, innovative pedagogies, eco-conservation programs, and student facilities that define holistic 21st-century education at MGM Model School, Ayiroor, Varkala.
      </p>
    </div>
  </div>

  <!-- National Honors Spotlight Cards (From HIGHLIGHTS -1.docx) -->
  <div class="container custom-container-larg mt-n4 mb-5" style="margin-top: -30px; position: relative; z-index: 3;">
    <div class="row g-4 justify-content-center">
      
      <!-- National Water Award 2024 -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white" style="border-top: 4px solid #2563EB !important;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-primary px-3 py-1 text-uppercase fw-bold" style="font-size: 11px;">National Recognition</span>
            <span class="text-muted small"><i class="fa-solid fa-calendar-day me-1"></i> 18th November 2025</span>
          </div>
          <h4 class="fw-bold text-dark mb-2" style="font-size: 20px;">
            <i class="fa-solid fa-award text-primary me-2"></i>National Water Award 2024 &ndash; A Moment of National Pride
          </h4>
          <p class="text-secondary small mb-3" style="line-height: 1.8;">
            MGM Model School, Ayiroor, Varkala has been conferred with a <strong>Special Mention &ndash; Best School/College Category at the 6th National Water Awards 2024</strong> by the Ministry of Jal Shakti, Government of India. Selected from 751 schools across India, the honour was presented at Vigyan Bhawan, New Delhi in the august presence of <strong>Hon'ble President of India Smt. Droupadi Murmu</strong>. Principal Dr. Pooja S received the award from Hon'ble Union Minister Shri C. R. Paatil.
          </p>
          <div class="p-2 rounded-3 bg-light border text-muted small">
            <i class="fa-solid fa-droplet text-primary me-1"></i> Features 36 rainwater conservation pits and rooftop harvesting replenishing campus groundwater.
          </div>
        </div>
      </div>

      <!-- National Principal Award 2025 -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white" style="border-top: 4px solid var(--tp-theme-primary, #ab0c2f) !important;">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-danger px-3 py-1 text-uppercase fw-bold" style="font-size: 11px;">Leadership Honour</span>
            <span class="text-muted small"><i class="fa-solid fa-calendar-day me-1"></i> 22nd August 2025</span>
          </div>
          <h4 class="fw-bold text-dark mb-2" style="font-size: 20px;">
            <i class="fa-solid fa-medal text-danger me-2"></i>Dr. Sarvepalli Radhakrishnan National Principal Award 2025
          </h4>
          <p class="text-secondary small mb-3" style="line-height: 1.8;">
            Our beloved <strong>Principal Dr. Pooja S</strong> was honoured with the prestigious Dr. Sarvepalli Radhakrishnan National Principal Award 2025. The award was presented by Dr. Subramanyam Sharma, grandson of Bharat Ratna Dr. S. Radhakrishnan, former President of India, at the Grand Conclave held in Hyderabad, in recognition of her visionary leadership and unwavering commitment to delivering quality education.
          </p>
          <div class="p-2 rounded-3 bg-light border text-muted small">
            <i class="fa-solid fa-star text-danger me-1"></i> Elevating MGM Model School, Ayiroor to nationwide heights of academic and holistic excellence.
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Interactive Search & Filter Controls -->
  <div class="container custom-container-larg mb-4">
    <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
      <div class="row align-items-center g-3">
        
        <!-- Live Search Box -->
        <div class="col-lg-5 col-md-12">
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill text-muted px-3">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" id="highlightSearchInput" class="form-control bg-light border-start-0 rounded-end-pill py-2" placeholder="Search swimming pool, 20-20 method, robotics, polyhouse..." autocomplete="off">
          </div>
        </div>

        <!-- Category Filter Buttons -->
        <div class="col-lg-7 col-md-12">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end" id="highlightFilterGroup">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill active highlights-filter-btn" data-category="all">
              All Highlights <span class="badge bg-danger text-white ms-1">21</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="academic">
              Academic &amp; Innovation <span class="badge bg-secondary text-white ms-1">6</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="green">
              Campus &amp; Green <span class="badge bg-secondary text-white ms-1">4</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="facilities">
              Student Facilities <span class="badge bg-secondary text-white ms-1">6</span>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill highlights-filter-btn" data-category="skills">
              Skills &amp; Cadets <span class="badge bg-secondary text-white ms-1">5</span>
            </button>
          </div>
        </div>

      </div>

      <!-- Live Count Indicator -->
      <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: #F1F5F9 !important;">
        <span class="small text-muted" id="highlightResultsCounter">
          Showing <strong class="text-dark">21</strong> of <strong>21</strong> campus highlights
        </span>
        <span class="small text-muted d-none d-md-inline">
          <i class="fa-solid fa-circle-info text-danger me-1"></i> Click any card to explore its dedicated separate page
        </span>
      </div>
    </div>
  </div>

  <!-- Highlights 21 Cards Grid -->
  <div class="container custom-container-larg pb-5">
    
    <!-- No Results Placeholder -->
    <div id="noHighlightsFound" class="text-center py-5 d-none">
      <div class="mb-3 text-muted">
        <i class="fa-solid fa-magnifying-glass fa-3x" style="opacity: 0.3;"></i>
      </div>
      <h4 class="fw-bold text-dark">No Campus Highlights Found</h4>
      <p class="text-muted mb-3">No highlights match your search query. Try typing another keyword or reset filters.</p>
      <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-4" id="resetHighlightFiltersBtn">
        Reset All Filters
      </button>
    </div>

    <div class="row g-4" id="highlightsGrid">
      <?php foreach ($highlights as $h): 
        $keywords = strtolower($h['title'] . ' ' . $h['summary'] . ' ' . $h['category_name'] . ' ' . implode(' ', $h['tags']));
      ?>
        <div class="col-lg-4 col-md-6 highlight-card-col" 
             id="<?= e($h['id']) ?>-col"
             data-category="<?= e($h['category_key']) ?>" 
             data-keywords="<?= e($keywords) ?>">
          
          <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white" id="<?= e($h['id']) ?>">
            
            <!-- Thumbnail & Badges -->
            <div class="position-relative" style="height: 220px; overflow: hidden;">
              <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="d-block w-100 h-100">
                <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                     alt="<?= e($h['title']) ?>" 
                     class="w-100 h-100" 
                     style="object-fit: cover; transition: transform 0.4s ease;"
                     loading="lazy">
              </a>
              
              <span class="position-absolute top-0 start-0 m-3 badge bg-white text-dark shadow-sm px-3 py-1 rounded-pill small fw-bold">
                <?= e($h['category_name']) ?>
              </span>
              
              <span class="position-absolute top-0 end-0 m-3 badge bg-danger text-white shadow-sm px-2 py-1 rounded-pill small fw-bold">
                #<?= sprintf('%02d', $h['order']) ?>
              </span>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4 d-flex flex-column">
              <h3 class="fw-bold text-dark mb-2" style="font-size: 20px;">
                <i class="<?= e($h['icon']) ?> text-danger me-2"></i>
                <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="text-dark text-decoration-none">
                  <span><?= e($h['title']) ?></span>
                </a>
              </h3>

              <p class="text-secondary small mb-3 flex-grow-1 leading-relaxed" style="line-height: 1.7;">
                <?= e($h['summary']) ?>
              </p>

              <!-- Tags / Features -->
              <div class="d-flex flex-wrap gap-1 mb-3">
                <?php foreach ($h['tags'] as $tag): ?>
                  <span class="badge bg-light text-muted border small px-2 py-1">
                    <i class="fa-solid fa-check text-success me-1"></i> <?= e($tag) ?>
                  </span>
                <?php endforeach; ?>
              </div>

              <!-- Action Footer -->
              <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                <button type="button" 
                        class="btn btn-outline-secondary btn-sm rounded-pill px-3 btn-open-detail" 
                        data-title="<?= e($h['title']) ?>"
                        data-category="<?= e($h['category_name']) ?>"
                        data-image="<?= asset_url(ltrim($h['image'], 'assets/')) ?>"
                        data-details="<?= e($h['details']) ?>"
                        data-bullets="<?= e(json_encode($h['bullets'])) ?>"
                        data-slug="<?= e($h['id']) ?>">
                  Quick Overview <i class="fa-solid fa-circle-info ms-1"></i>
                </button>

                <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold" title="View Dedicated Page">
                  Full Page <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
              </div>

            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>

</div>

<!-- Interactive Detail Modal -->
<div class="modal fade" id="highlightDetailModal" tabindex="-1" aria-labelledby="highlightModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
      
      <div class="modal-header bg-light border-0 px-4 py-3 align-items-center">
        <div>
          <span class="badge bg-danger px-3 py-1 text-uppercase mb-1" id="highlightModalCategory" style="font-size: 11px; font-weight: 700;">
            Category
          </span>
          <h4 class="modal-title fw-bold text-dark mb-0" id="highlightModalTitle">Highlight Title</h4>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-md-5">
            <div class="rounded-3 overflow-hidden shadow-sm" style="height: 240px;">
              <img id="highlightModalImage" src="" alt="Highlight" class="w-100 h-100" style="object-fit: cover;">
            </div>
          </div>
          <div class="col-md-7">
            <p id="highlightModalDetails" class="text-secondary leading-relaxed mb-3" style="font-size: 15px; line-height: 1.8;"></p>
            <h6 class="fw-bold text-dark mb-2">Key Highlights:</h6>
            <div id="highlightModalBullets" class="d-flex flex-column gap-2 mb-3"></div>
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light border-0 px-4 py-3 justify-content-between">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Close</button>
        <a id="highlightModalFullPageBtn" href="#" class="btn btn-danger rounded-pill px-4 btn-sm fw-bold">
          Explore Dedicated Page <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {{
  const searchInput = document.getElementById('highlightSearchInput');
  const filterBtns = document.querySelectorAll('.highlights-filter-btn');
  const cardCols = document.querySelectorAll('.highlight-card-col');
  const counter = document.getElementById('highlightResultsCounter');
  const noFound = document.getElementById('noHighlightsFound');
  const resetBtn = document.getElementById('resetHighlightFiltersBtn');

  let activeCategory = 'all';

  function filterHighlights() {{
    const query = searchInput.value.toLowerCase().trim();
    let visibleCount = 0;

    cardCols.forEach(function(col) {{
      const cat = col.getAttribute('data-category');
      const keywords = col.getAttribute('data-keywords') || '';

      const matchCat = (activeCategory === 'all' || cat === activeCategory);
      const matchQuery = (query === '' || keywords.includes(query));

      if (matchCat && matchQuery) {{
        col.classList.remove('d-none');
        visibleCount++;
      }} else {{
        col.classList.add('d-none');
      }}
    }});

    if (counter) {{
      counter.innerHTML = 'Showing <strong class="text-dark">' + visibleCount + '</strong> of <strong>21</strong> campus highlights';
    }}

    if (noFound) {{
      if (visibleCount === 0) {{
        noFound.classList.remove('d-none');
      }} else {{
        noFound.classList.add('d-none');
      }}
    }}
  }}

  if (searchInput) {{
    searchInput.addEventListener('input', filterHighlights);
  }}

  filterBtns.forEach(function(btn) {{
    btn.addEventListener('click', function() {{
      filterBtns.forEach(b => {{
        b.classList.remove('active', 'btn-outline-danger');
        b.classList.add('btn-outline-secondary');
      }});
      this.classList.add('active', 'btn-outline-danger');
      this.classList.remove('btn-outline-secondary');
      activeCategory = this.getAttribute('data-category');
      filterHighlights();
    }});
  }});

  if (resetBtn) {{
    resetBtn.addEventListener('click', function() {{
      searchInput.value = '';
      activeCategory = 'all';
      filterBtns.forEach(b => {{
        if (b.getAttribute('data-category') === 'all') {{
          b.classList.add('active', 'btn-outline-danger');
          b.classList.remove('btn-outline-secondary');
        }} else {{
          b.classList.remove('active', 'btn-outline-danger');
          b.classList.add('btn-outline-secondary');
        }}
      }});
      filterHighlights();
    }});
  }}

  // Quick Overview Modal
  const modalEl = document.getElementById('highlightDetailModal');
  if (modalEl && typeof bootstrap !== 'undefined') {{
    const modal = new bootstrap.Modal(modalEl);
    document.querySelectorAll('.btn-open-detail').forEach(function(btn) {{
      btn.addEventListener('click', function() {{
        const title = this.getAttribute('data-title');
        const cat = this.getAttribute('data-category');
        const img = this.getAttribute('data-image');
        const details = this.getAttribute('data-details');
        const slug = this.getAttribute('data-slug');
        let bullets = [];
        try {{
          bullets = JSON.parse(this.getAttribute('data-bullets') || '[]');
        }} catch(e) {{}}

        document.getElementById('highlightModalTitle').innerText = title;
        document.getElementById('highlightModalCategory').innerText = cat;
        document.getElementById('highlightModalImage').src = img;
        document.getElementById('highlightModalDetails').innerText = details;

        const bulletsWrap = document.getElementById('highlightModalBullets');
        bulletsWrap.innerHTML = '';
        bullets.forEach(function(b) {{
          const div = document.createElement('div');
          div.className = 'd-flex align-items-start gap-2 small';
          div.innerHTML = '<i class="fa-solid fa-circle-check text-success mt-1"></i><span>' + b + '</span>';
          bulletsWrap.appendChild(div);
        }});

        const fullPageBtn = document.getElementById('highlightModalFullPageBtn');
        if (fullPageBtn && slug) {{
          fullPageBtn.href = '<?= rtrim(BASE_URL, '/') ?>/' + slug + '/';
        }}

        modal.show();
      }});
    }});
  }}

}});
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
"""

with open('views/highlights.php', 'w', encoding='utf-8') as f:
    f.write(php_content)

print("Saved updated views/highlights.php with exact docx content & National Awards spotlight!")
