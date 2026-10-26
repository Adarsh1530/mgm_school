/**
 * MGM Model School - Interactive Gallery & Lightbox Engine
 * Exact Layout & Functionality of BVB Manvila Gallery
 */

document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('gallerySearchInput');
  const searchClearBtn = document.getElementById('gallerySearchClear');
  const searchMeta = document.getElementById('gallerySearchMeta');
  const noResultsBox = document.getElementById('galleryNoResults');
  const filterBtns = document.querySelectorAll('#galleryFilterBtns .filter-btn');
  const galleryGrid = document.getElementById('publicGalleryGrid');

  if (!galleryGrid) return;

  const allItems = Array.from(galleryGrid.querySelectorAll('.gallery-item'));
  if (!allItems.length) return;

  let activeFilter = 'all';
  let searchQuery = '';

  // -------------------------------------------------------------
  // 1. FILTERING & SEARCH ENGINE
  // -------------------------------------------------------------

  function getVisibleItems() {
    return allItems.filter(item => !item.classList.contains('hidden') && item.style.display !== 'none');
  }

  function applyFilter() {
    let visibleCount = 0;
    const tokens = searchQuery.split(/\s+/).filter(t => t.length > 0);

    allItems.forEach(item => {
      const category = (item.getAttribute('data-category') || 'all').toLowerCase();
      const title = (item.getAttribute('data-title') || '').toLowerCase();
      const catLabel = (item.getAttribute('data-category-label') || '').toLowerCase();
      const caption = (item.getAttribute('data-caption') || '').toLowerCase();
      const img = item.querySelector('img');
      const altText = (img ? img.getAttribute('alt') || '' : '').toLowerCase();

      const fullSearchableText = `${title} ${catLabel} ${category} ${caption} ${altText}`;

      // Check category match
      const matchesCategory = (activeFilter === 'all' || category === activeFilter);

      // Check keyword search match (all tokens must match)
      const matchesSearch = tokens.length === 0 || tokens.every(token => fullSearchableText.includes(token));

      if (matchesCategory && matchesSearch) {
        visibleCount++;
        item.classList.remove('hidden');
        item.style.display = '';
        setTimeout(() => {
          item.style.opacity = '1';
          item.style.transform = 'scale(1)';
        }, 10);
      } else {
        item.style.opacity = '0';
        item.style.transform = 'scale(0.96)';
        item.classList.add('hidden');
        item.style.display = 'none';
      }
    });

    // Update search metadata & no-results state
    if (searchMeta) {
      if (searchQuery) {
        searchMeta.textContent = `Showing ${visibleCount} of ${allItems.length} photos matching "${searchQuery}"`;
      } else if (activeFilter !== 'all') {
        const activeBtn = document.querySelector(`#galleryFilterBtns .filter-btn[data-filter="${activeFilter}"]`);
        const label = activeBtn ? activeBtn.textContent.trim() : activeFilter.toUpperCase();
        searchMeta.textContent = `Showing ${visibleCount} photos in ${label}`;
      } else {
        searchMeta.textContent = '';
      }
    }

    if (noResultsBox) {
      if (visibleCount === 0) {
        noResultsBox.style.display = 'block';
        const querySpan = noResultsBox.querySelector('.no-results-query');
        if (querySpan) querySpan.textContent = searchQuery || activeFilter;
      } else {
        noResultsBox.style.display = 'none';
      }
    }
  }

  // Category Filter Button Clicks
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      activeFilter = this.getAttribute('data-filter') || 'all';
      applyFilter();
    });
  });

  // Search Input Events
  if (searchInput) {
    searchInput.addEventListener('input', function (e) {
      searchQuery = e.target.value.trim().toLowerCase();
      if (searchClearBtn) {
        searchClearBtn.style.display = searchQuery ? 'flex' : 'none';
      }
      applyFilter();
    });
  }

  if (searchClearBtn) {
    searchClearBtn.addEventListener('click', function () {
      if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
      }
      searchQuery = '';
      searchClearBtn.style.display = 'none';
      applyFilter();
    });
  }

  // Clear button inside No-Results Box
  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-clear-search')) {
      if (searchInput) searchInput.value = '';
      searchQuery = '';
      if (searchClearBtn) searchClearBtn.style.display = 'none';

      filterBtns.forEach(b => b.classList.remove('active'));
      const allBtn = document.querySelector('#galleryFilterBtns .filter-btn[data-filter="all"]');
      if (allBtn) allBtn.classList.add('active');
      activeFilter = 'all';

      applyFilter();
    }
  });

  // Check URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const initialSearch = urlParams.get('search') || urlParams.get('q');
  const initialCat = urlParams.get('category') || urlParams.get('cat');

  if (initialCat) {
    const targetBtn = document.querySelector(`#galleryFilterBtns .filter-btn[data-filter="${initialCat.toLowerCase()}"]`);
    if (targetBtn) {
      filterBtns.forEach(b => b.classList.remove('active'));
      targetBtn.classList.add('active');
      activeFilter = initialCat.toLowerCase();
    }
  }

  if (initialSearch && searchInput) {
    searchInput.value = initialSearch;
    searchQuery = initialSearch.trim().toLowerCase();
    if (searchClearBtn) searchClearBtn.style.display = 'flex';
  }

  applyFilter();

  // -------------------------------------------------------------
  // 2. BVB LIGHTBOX ENGINE WITH RELATED THUMBNAILS NAVIGATION
  // -------------------------------------------------------------
  const lightbox = document.getElementById('gallery-lightbox');
  if (!lightbox) return;

  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const lightboxCounter = document.getElementById('lightboxCounter');
  const lightboxClose = document.getElementById('lightboxClose');
  const lightboxPrev = document.getElementById('lightboxPrev');
  const lightboxNext = document.getElementById('lightboxNext');
  const lightboxThumbsTrack = document.getElementById('lightboxThumbsTrack');
  const lightboxThumbsHeading = document.getElementById('lightboxThumbsHeading');
  const lightboxThumbsCount = document.getElementById('lightboxThumbsCount');
  const thumbScrollPrev = document.getElementById('thumbScrollPrev');
  const thumbScrollNext = document.getElementById('thumbScrollNext');

  let currentItemsList = [];
  let currentIndex = 0;

  function renderLightboxSlide(index) {
    if (!currentItemsList.length) return;
    if (index < 0) index = currentItemsList.length - 1;
    if (index >= currentItemsList.length) index = 0;
    currentIndex = index;

    const currentItem = currentItemsList[currentIndex];
    const imgSrc = currentItem.getAttribute('data-img') || (currentItem.querySelector('img') ? currentItem.querySelector('img').src : '');
    const title = currentItem.getAttribute('data-title') || 'Gallery Photo';
    const caption = currentItem.getAttribute('data-caption') || '';

    // Main Image with smooth fade
    lightboxImg.style.opacity = '0.3';
    lightboxImg.src = imgSrc;
    lightboxImg.alt = title;
    lightboxImg.onload = function () {
      lightboxImg.style.opacity = '1';
    };

    // BVB Style Caption: Title + Caption
    if (lightboxCaption) {
      lightboxCaption.textContent = title + (caption ? ' — ' + caption : '');
    }
    // BVB Style Counter: 1 / 26
    if (lightboxCounter) {
      lightboxCounter.textContent = `${currentIndex + 1} / ${currentItemsList.length}`;
    }

    // Highlight active thumbnail and scroll into view
    if (lightboxThumbsTrack) {
      const allThumbs = lightboxThumbsTrack.querySelectorAll('.lightbox-thumb-item');
      allThumbs.forEach((thumb, idx) => {
        if (idx === currentIndex) {
          thumb.classList.add('active');
          thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        } else {
          thumb.classList.remove('active');
        }
      });
    }
  }

  function populateThumbnails() {
    if (!lightboxThumbsTrack) return;
    lightboxThumbsTrack.innerHTML = '';

    if (lightboxThumbsCount) {
      lightboxThumbsCount.textContent = `${currentItemsList.length} photos`;
    }

    if (lightboxThumbsHeading) {
      const currentCat = currentItemsList[currentIndex]?.getAttribute('data-category-label');
      lightboxThumbsHeading.textContent = currentCat ? `${currentCat} Collection` : 'Related Photos';
    }

    currentItemsList.forEach((item, idx) => {
      const thumbBtn = document.createElement('div');
      thumbBtn.className = 'lightbox-thumb-item' + (idx === currentIndex ? ' active' : '');
      thumbBtn.setAttribute('data-index', idx);
      thumbBtn.setAttribute('title', item.getAttribute('data-title') || `Photo ${idx + 1}`);

      const thumbImg = document.createElement('img');
      thumbImg.src = item.getAttribute('data-img') || (item.querySelector('img') ? item.querySelector('img').src : '');
      thumbImg.alt = item.getAttribute('data-title') || 'Thumbnail';
      thumbImg.loading = 'lazy';

      thumbBtn.appendChild(thumbImg);

      thumbBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        renderLightboxSlide(idx);
      });

      lightboxThumbsTrack.appendChild(thumbBtn);
    });
  }

  function openLightbox(itemElement) {
    const visible = getVisibleItems();
    currentItemsList = visible.length ? visible : allItems;

    const clickedIdx = currentItemsList.indexOf(itemElement);
    currentIndex = clickedIdx !== -1 ? clickedIdx : 0;

    populateThumbnails();
    renderLightboxSlide(currentIndex);

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
  }

  function nextSlide() {
    renderLightboxSlide(currentIndex + 1);
  }

  function prevSlide() {
    renderLightboxSlide(currentIndex - 1);
  }

  // Click on gallery item to open lightbox
  allItems.forEach(item => {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      openLightbox(this);
    });
  });

  // Lightbox Controls
  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
  if (lightboxNext) lightboxNext.addEventListener('click', (e) => { e.stopPropagation(); nextSlide(); });
  if (lightboxPrev) lightboxPrev.addEventListener('click', (e) => { e.stopPropagation(); prevSlide(); });

  // Thumbnail Track Scroll Buttons
  if (thumbScrollPrev && lightboxThumbsTrack) {
    thumbScrollPrev.addEventListener('click', (e) => {
      e.stopPropagation();
      lightboxThumbsTrack.scrollBy({ left: -200, behavior: 'smooth' });
    });
  }
  if (thumbScrollNext && lightboxThumbsTrack) {
    thumbScrollNext.addEventListener('click', (e) => {
      e.stopPropagation();
      lightboxThumbsTrack.scrollBy({ left: 200, behavior: 'smooth' });
    });
  }

  // Backdrop click to close
  lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });

  // Keyboard navigation
  document.addEventListener('keydown', function (e) {
    if (!lightbox.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextSlide();
    if (e.key === 'ArrowLeft') prevSlide();
  });

  // Touch Swipe on mobile
  let touchStartX = 0;
  let touchEndX = 0;
  const stage = lightbox.querySelector('.lightbox-stage');

  if (stage) {
    stage.addEventListener('touchstart', function (e) {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    stage.addEventListener('touchend', function (e) {
      touchEndX = e.changedTouches[0].screenX;
      if (touchEndX < touchStartX - 50) nextSlide();
      if (touchEndX > touchStartX + 50) prevSlide();
    }, { passive: true });
  }
});
