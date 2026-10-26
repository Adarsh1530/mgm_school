/**
 * MGM Model School - Interactive Gallery & Lightbox Engine
 * 3x3 Grid Layout | Hover Event Dates | Circular Search | Event-Specific Sub-Images
 */

document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('gallerySearchInput');
  const searchClearBtn = document.getElementById('gallerySearchClear');
  const searchMeta = document.getElementById('gallerySearchMeta');
  const noResultsBox = document.getElementById('galleryNoResults');
  const filterBtns = document.querySelectorAll('#galleryFilterBtns .filter-btn');
  const galleryGrid = document.getElementById('publicGalleryGrid');
  const paginationContainer = document.getElementById('galleryPagination');

  if (!galleryGrid) return;

  const allItems = Array.from(galleryGrid.querySelectorAll('.gallery-item'));
  if (!allItems.length) return;

  const ITEMS_PER_PAGE = 9; // Strict 3x3 grid layout (3 columns x 3 rows)
  let activeFilter = 'all';
  let searchQuery = '';
  let currentPage = 1;
  let matchingItems = [...allItems];

  // -------------------------------------------------------------
  // 1. FILTERING, SEARCH & 3x3 PAGINATION ENGINE
  // -------------------------------------------------------------

  function filterItems() {
    const tokens = searchQuery.split(/\s+/).filter(t => t.length > 0);

    matchingItems = allItems.filter(item => {
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

      return matchesCategory && matchesSearch;
    });

    currentPage = 1;
    renderPage();
  }

  function renderPage() {
    const totalItems = matchingItems.length;
    const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE) || 1;

    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    const endIndex = startIndex + ITEMS_PER_PAGE;

    // Show/hide gallery items
    allItems.forEach(item => {
      const isMatch = matchingItems.includes(item);
      const matchIndex = matchingItems.indexOf(item);
      const isVisibleOnPage = isMatch && (matchIndex >= startIndex && matchIndex < endIndex);

      if (isVisibleOnPage) {
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
        searchMeta.textContent = `Found ${totalItems} events matching "${searchQuery}"`;
      } else if (activeFilter !== 'all') {
        const activeBtn = document.querySelector('#galleryFilterBtns .filter-btn.active');
        const catName = activeBtn ? activeBtn.textContent.trim() : activeFilter;
        searchMeta.textContent = `Showing ${totalItems} events in ${catName}`;
      } else {
        searchMeta.textContent = '';
      }
    }

    if (noResultsBox) {
      if (totalItems === 0) {
        noResultsBox.style.display = 'block';
        const querySpan = noResultsBox.querySelector('.no-results-query');
        if (querySpan) querySpan.textContent = searchQuery || activeFilter;
      } else {
        noResultsBox.style.display = 'none';
      }
    }

    renderPaginationControls(totalPages);
  }

  function renderPaginationControls(totalPages) {
    if (!paginationContainer) return;
    paginationContainer.innerHTML = '';

    if (totalPages <= 1) {
      paginationContainer.style.display = 'none';
      return;
    }
    paginationContainer.style.display = 'flex';

    // Previous Button
    const prevBtn = document.createElement('button');
    prevBtn.type = 'button';
    prevBtn.className = 'gallery-page-btn' + (currentPage === 1 ? ' disabled' : '');
    prevBtn.innerHTML = '<i class="fa-solid fa-angle-left"></i>';
    prevBtn.setAttribute('aria-label', 'Previous page');
    prevBtn.addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        renderPage();
        scrollToGallery();
      }
    });
    paginationContainer.appendChild(prevBtn);

    // Page Numbers
    for (let p = 1; p <= totalPages; p++) {
      const pageBtn = document.createElement('button');
      pageBtn.type = 'button';
      pageBtn.className = 'gallery-page-btn' + (p === currentPage ? ' active' : '');
      pageBtn.textContent = p;
      pageBtn.setAttribute('aria-label', `Page ${p}`);
      pageBtn.addEventListener('click', () => {
        if (currentPage !== p) {
          currentPage = p;
          renderPage();
          scrollToGallery();
        }
      });
      paginationContainer.appendChild(pageBtn);
    }

    // Next Button
    const nextBtn = document.createElement('button');
    nextBtn.type = 'button';
    nextBtn.className = 'gallery-page-btn' + (currentPage === totalPages ? ' disabled' : '');
    nextBtn.innerHTML = '<i class="fa-solid fa-angle-right"></i>';
    nextBtn.setAttribute('aria-label', 'Next page');
    nextBtn.addEventListener('click', () => {
      if (currentPage < totalPages) {
        currentPage++;
        renderPage();
        scrollToGallery();
      }
    });
    paginationContainer.appendChild(nextBtn);
  }

  function scrollToGallery() {
    const header = document.querySelector('.section-header');
    if (header) {
      header.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  // Filter Button Clicks
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      activeFilter = (this.getAttribute('data-filter') || 'all').toLowerCase();
      filterItems();
    });
  });

  // Search Input Events
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      searchQuery = this.value.trim().toLowerCase();
      if (searchClearBtn) {
        searchClearBtn.style.display = searchQuery ? 'flex' : 'none';
      }
      filterItems();
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
      filterItems();
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

      filterItems();
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

  filterItems();

  // -------------------------------------------------------------
  // 2. EVENT-SPECIFIC LIGHTBOX ENGINE
  // Displays ONLY sub-images belonging to the selected event
  // Never mixes images from other events!
  // -------------------------------------------------------------
  const lightbox = document.getElementById('gallery-lightbox');
  if (!lightbox) return;

  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const lightboxSubCaption = document.getElementById('lightboxSubCaption');
  const lightboxEventDate = document.getElementById('lightboxEventDate');
  const lightboxCounter = document.getElementById('lightboxCounter');
  const lightboxClose = document.getElementById('lightboxClose');
  const lightboxPrev = document.getElementById('lightboxPrev');
  const lightboxNext = document.getElementById('lightboxNext');
  const lightboxThumbsTrack = document.getElementById('lightboxThumbsTrack');
  const lightboxThumbsHeading = document.getElementById('lightboxThumbsHeading');
  const lightboxThumbsCount = document.getElementById('lightboxThumbsCount');
  const thumbScrollPrev = document.getElementById('thumbScrollPrev');
  const thumbScrollNext = document.getElementById('thumbScrollNext');

  let currentEventPhotos = []; // Photos strictly belonging to this event
  let currentEventPhotoIndex = 0;
  let currentEventMeta = {};

  function openLightboxForEvent(itemElement) {
    const title = itemElement.getAttribute('data-title') || 'School Event';
    const subtitle = itemElement.getAttribute('data-subtitle') || '';
    const date = itemElement.getAttribute('data-date') || '';
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

    currentEventMeta = { title, subtitle, date };

    // Build the photo list: Main Image is #1, followed by its sub-images
    currentEventPhotos = [
      { url: mainImg, label: 'Main Highlight' }
    ];

    if (Array.isArray(subImgs)) {
      subImgs.forEach((imgUrl, i) => {
        if (imgUrl && imgUrl !== mainImg) {
          currentEventPhotos.push({
            url: imgUrl,
            label: `Photo ${i + 1}`
          });
        }
      });
    }

    currentEventPhotoIndex = 0;
    populateEventThumbnails();
    renderLightboxSlide(currentEventPhotoIndex);

    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function populateEventThumbnails() {
    if (!lightboxThumbsTrack) return;
    lightboxThumbsTrack.innerHTML = '';

    const total = currentEventPhotos.length;
    if (lightboxThumbsCount) {
      lightboxThumbsCount.textContent = `${total} ${total === 1 ? 'photo' : 'photos'} in event`;
    }

    if (lightboxThumbsHeading) {
      lightboxThumbsHeading.textContent = `${currentEventMeta.title} Package`;
    }

    currentEventPhotos.forEach((photo, idx) => {
      const thumbBtn = document.createElement('div');
      thumbBtn.className = 'lightbox-thumb-item' + (idx === currentEventPhotoIndex ? ' active' : '');
      thumbBtn.setAttribute('data-index', idx);
      thumbBtn.setAttribute('title', `${currentEventMeta.title} - ${photo.label}`);

      const thumbImg = document.createElement('img');
      thumbImg.src = photo.url;
      thumbImg.alt = `${currentEventMeta.title} thumbnail ${idx + 1}`;
      thumbImg.loading = 'lazy';

      thumbBtn.appendChild(thumbImg);

      thumbBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        renderLightboxSlide(idx);
      });

      lightboxThumbsTrack.appendChild(thumbBtn);
    });
  }

  function renderLightboxSlide(index) {
    if (!currentEventPhotos.length) return;

    if (index < 0) {
      index = currentEventPhotos.length - 1;
    } else if (index >= currentEventPhotos.length) {
      index = 0;
    }

    currentEventPhotoIndex = index;
    const currentPhoto = currentEventPhotos[index];

    // Fade transition for main photo
    if (lightboxImg) {
      lightboxImg.style.opacity = '0.3';
      lightboxImg.src = currentPhoto.url;
      lightboxImg.alt = `${currentEventMeta.title} - ${currentPhoto.label}`;
      lightboxImg.onload = function () {
        lightboxImg.style.opacity = '1';
      };
    }

    // Set Captions
    if (lightboxCaption) {
      lightboxCaption.textContent = currentEventMeta.title;
    }

    if (lightboxSubCaption) {
      lightboxSubCaption.textContent = currentEventMeta.subtitle || '';
      lightboxSubCaption.style.display = currentEventMeta.subtitle ? 'block' : 'none';
    }

    if (lightboxEventDate) {
      if (currentEventMeta.date) {
        lightboxEventDate.innerHTML = `<i class="fa-regular fa-calendar-days"></i> ${currentEventMeta.date.toUpperCase()}`;
        lightboxEventDate.style.display = 'inline-flex';
      } else {
        lightboxEventDate.style.display = 'none';
      }
    }

    // Counter within this event
    if (lightboxCounter) {
      lightboxCounter.textContent = `${index + 1} / ${currentEventPhotos.length}`;
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
