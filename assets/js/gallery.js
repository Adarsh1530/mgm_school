/**
 * MGM Model School - Interactive Gallery & Lightbox Engine
 * Single Page 3x3 Grid Layout | Hover-Only Details | Clean Borderless Lightbox
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
  // 1. FILTERING & SEARCH ENGINE (ALL IMAGES ON A SINGLE PAGE)
  // -------------------------------------------------------------

  function applyFilter() {
    let visibleCount = 0;
    const tokens = searchQuery.split(/\s+/).filter(t => t.length > 0);

    allItems.forEach(item => {
      const category = (item.getAttribute('data-category') || 'all').toLowerCase();
      const title = (item.getAttribute('data-title') || '').toLowerCase();
      const subtitle = (item.getAttribute('data-subtitle') || '').toLowerCase();
      const catLabel = (item.getAttribute('data-category-label') || '').toLowerCase();
      const date = (item.getAttribute('data-date') || '').toLowerCase();
      const img = item.querySelector('img');
      const altText = (img ? img.getAttribute('alt') || '' : '').toLowerCase();

      const fullSearchableText = `${title} ${subtitle} ${catLabel} ${category} ${date} ${altText}`;

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
        const activeBtn = document.querySelector('#galleryFilterBtns .filter-btn.active');
        const catName = activeBtn ? activeBtn.textContent.trim() : activeFilter.toUpperCase();
        searchMeta.textContent = `Showing ${visibleCount} photos in ${catName}`;
      } else {
        searchMeta.textContent = '';
      }
    }

    if (noResultsBox) {
      if (visibleCount === 0 && allItems.length > 0) {
        noResultsBox.style.display = 'block';
        const querySpan = noResultsBox.querySelector('.no-results-query');
        if (querySpan) querySpan.textContent = searchQuery || activeFilter;
      } else {
        noResultsBox.style.display = 'none';
      }
    }
  }

  // Filter Button Clicks
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      activeFilter = (this.getAttribute('data-filter') || 'all').toLowerCase();
      applyFilter();
    });
  });

  // Search Input Events
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      searchQuery = this.value.trim().toLowerCase();
      if (searchClearBtn) {
        searchClearBtn.style.display = searchQuery ? 'flex' : 'none';
      }
      applyFilter();
    });
  }

  // Search Clear Button
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

  // Check URL parameters on initial load
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
  // 2. CLEAN BORDERLESS LIGHTBOX (ONLY SUB-IMAGES OF THIS EVENT)
  // No Package Box, No Frames, No Borders, Floating Images Only
  // -------------------------------------------------------------
  const lightbox = document.getElementById('gallery-lightbox');
  if (!lightbox) return;

  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxClose = document.getElementById('lightboxClose');
  const lightboxPrev = document.getElementById('lightboxPrev');
  const lightboxNext = document.getElementById('lightboxNext');
  const lightboxThumbsSection = document.getElementById('lightboxThumbsSection');
  const lightboxThumbsTrack = document.getElementById('lightboxThumbsTrack');
  const thumbScrollPrev = document.getElementById('thumbScrollPrev');
  const thumbScrollNext = document.getElementById('thumbScrollNext');

  let currentEventPhotos = [];
  let currentEventPhotoIndex = 0;

  function openLightboxForEvent(itemElement) {
    const title = itemElement.getAttribute('data-title') || 'Gallery Photo';
    const mainImg = itemElement.getAttribute('data-main-img') || (itemElement.querySelector('img') ? itemElement.querySelector('img').src : '');
    
    // Parse sub-images
    let subImgs = [];
    const rawSub = itemElement.getAttribute('data-sub-images');
    if (rawSub) {
      try {
        subImgs = JSON.parse(rawSub);
      } catch (err) {
        subImgs = [];
      }
    }

    // Build the photo list: Main Image is first, followed by sub-images
    currentEventPhotos = [mainImg];

    if (Array.isArray(subImgs)) {
      subImgs.forEach(imgUrl => {
        if (imgUrl && imgUrl !== mainImg && !currentEventPhotos.includes(imgUrl)) {
          currentEventPhotos.push(imgUrl);
        }
      });
    }

    currentEventPhotoIndex = 0;
    populateEventThumbnails(title);
    renderLightboxSlide(currentEventPhotoIndex, title);

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function populateEventThumbnails(title) {
    if (!lightboxThumbsSection || !lightboxThumbsTrack) return;

    if (currentEventPhotos.length <= 1) {
      lightboxThumbsSection.style.display = 'none';
      lightboxThumbsTrack.innerHTML = '';
      return;
    }

    lightboxThumbsSection.style.display = 'flex';
    lightboxThumbsTrack.innerHTML = '';

    currentEventPhotos.forEach((photoUrl, idx) => {
      const thumbBtn = document.createElement('div');
      thumbBtn.className = 'lightbox-thumb-item' + (idx === currentEventPhotoIndex ? ' active' : '');
      thumbBtn.setAttribute('data-index', idx);
      thumbBtn.setAttribute('title', `${title} - Image ${idx + 1}`);

      const thumbImg = document.createElement('img');
      thumbImg.src = photoUrl;
      thumbImg.alt = `${title} thumb ${idx + 1}`;
      thumbImg.loading = 'lazy';

      thumbBtn.appendChild(thumbImg);

      thumbBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        renderLightboxSlide(idx, title);
      });

      lightboxThumbsTrack.appendChild(thumbBtn);
    });
  }

  function renderLightboxSlide(index, title) {
    if (!currentEventPhotos.length) return;

    if (index < 0) {
      index = currentEventPhotos.length - 1;
    } else if (index >= currentEventPhotos.length) {
      index = 0;
    }

    currentEventPhotoIndex = index;
    const currentPhotoUrl = currentEventPhotos[index];

    // Fade transition for main photo
    if (lightboxImg) {
      lightboxImg.style.opacity = '0.3';
      lightboxImg.src = currentPhotoUrl;
      lightboxImg.alt = title || 'Gallery Image';
      lightboxImg.onload = function () {
        lightboxImg.style.opacity = '1';
      };
    }

    // Highlight active thumbnail and scroll into view
    if (lightboxThumbsTrack) {
      const allThumbs = lightboxThumbsTrack.querySelectorAll('.lightbox-thumb-item');
      allThumbs.forEach((thumb, idx) => {
        if (idx === currentEventPhotoIndex) {
          thumb.classList.add('active');
          thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        } else {
          thumb.classList.remove('active');
        }
      });
    }

    // Hide navigation arrows if only 1 photo in event
    const hasMultiple = currentEventPhotos.length > 1;
    if (lightboxPrev) lightboxPrev.style.display = hasMultiple ? 'flex' : 'none';
    if (lightboxNext) lightboxNext.style.display = hasMultiple ? 'flex' : 'none';
  }

  function closeLightbox() {
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
  }

  function nextSlide() {
    renderLightboxSlide(currentEventPhotoIndex + 1);
  }

  function prevSlide() {
    renderLightboxSlide(currentEventPhotoIndex - 1);
  }

  // Click on gallery item opens event's sub-images
  allItems.forEach(item => {
    item.addEventListener('click', function (e) {
      e.preventDefault();
      openLightboxForEvent(this);
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
