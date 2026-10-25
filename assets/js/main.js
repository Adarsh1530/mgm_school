/**
 * MGM Model School Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  // Smooth Non-Blocking Scrolled Header Indicator
  const headerArea = document.querySelector('.header-area');
  if (headerArea) {
    let ticking = false;
    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          if (window.scrollY > 30) {
            headerArea.classList.add('header-scrolled');
          } else {
            headerArea.classList.remove('header-scrolled');
          }
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  // Offcanvas Mobile Navigation
  const offcanvasOpenBtn = document.querySelector('.offcanvas-open-btn');
  const offcanvasCloseBtn = document.querySelector('.offcanvas-close-btn');
  const offcanvasWrapper = document.querySelector('.offcanvas-wrapper');
  const offcanvasOverlay = document.querySelector('.offcanvas-overlay');

  function openOffcanvas() {
    if (offcanvasWrapper) offcanvasWrapper.classList.add('active');
    if (offcanvasOverlay) offcanvasOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeOffcanvas() {
    if (offcanvasWrapper) offcanvasWrapper.classList.remove('active');
    if (offcanvasOverlay) offcanvasOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (offcanvasOpenBtn) offcanvasOpenBtn.addEventListener('click', openOffcanvas);
  if (offcanvasCloseBtn) offcanvasCloseBtn.addEventListener('click', closeOffcanvas);
  if (offcanvasOverlay) offcanvasOverlay.addEventListener('click', closeOffcanvas);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeOffcanvas();
      closeLightbox();
    }
  });

  // Mobile submenu accordion toggle
  const mobileDropdowns = document.querySelectorAll('.offcanvas-menu .has-dropdown > a');
  mobileDropdowns.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const parent = this.parentElement;
      parent.classList.toggle('open');
      const submenu = parent.querySelector('.offcanvas-submenu');
      if (submenu) {
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
      }
    });
  });

  // Gallery Lightbox Modal
  const galleryImgs = document.querySelectorAll('.e-gallery-image, .gallery-card img, .elementor-widget-image img, .e-con-inner img');
  let lightboxModal = document.querySelector('.lightbox-modal');

  if (galleryImgs.length > 0 && !lightboxModal) {
    lightboxModal = document.createElement('div');
    lightboxModal.className = 'lightbox-modal';
    lightboxModal.innerHTML = `
      <button class="lightbox-close" aria-label="Close Lightbox">&times;</button>
      <img class="lightbox-content" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="Gallery Image">
    `;
    document.body.appendChild(lightboxModal);

    lightboxModal.addEventListener('click', function (e) {
      if (e.target === lightboxModal || e.target.classList.contains('lightbox-close')) {
        closeLightbox();
      }
    });
  }

  function openLightbox(src, alt) {
    if (!lightboxModal) return;
    const img = lightboxModal.querySelector('.lightbox-content');
    img.src = src;
    img.alt = alt || '';
    lightboxModal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    if (!lightboxModal) return;
    lightboxModal.classList.remove('active');
    document.body.style.overflow = '';
  }

  galleryImgs.forEach(function (img) {
    // Only bind if inside page body and not header/footer logo
    if (img.closest('.header-area') || img.closest('.tp-footer-area') || img.closest('.offcanvas-wrapper')) return;
    img.style.cursor = 'pointer';
    img.addEventListener('click', function () {
      openLightbox(this.src, this.alt);
    });
  });

  // Table search for Courses Offered
  const courseSearchInput = document.getElementById('courseTableSearch');
  if (courseSearchInput) {
    courseSearchInput.addEventListener('input', function () {
      const filter = this.value.toLowerCase();
      const rows = document.querySelectorAll('#coursesTable tbody tr');
      rows.forEach(function (row) {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
      });
    });
  }

  // Swiper Slider Initializations
  if (typeof Swiper !== 'undefined') {
    if (document.querySelector('.tp-slider-active')) {
      new Swiper('.tp-slider-active', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 6000, disableOnInteraction: false },
        speed: 1000,
        touchReleaseOnEdges: true,
        passiveListeners: true
      });
    }

    if (document.querySelector('.tp-program-active')) {
      new Swiper('.tp-program-active', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        touchReleaseOnEdges: true,
        passiveListeners: true,
        pagination: { el: '.tp-program-dot', clickable: true },
        breakpoints: {
          '768': { slidesPerView: 2 },
          '992': { slidesPerView: 3 },
          '1200': { slidesPerView: 4 }
        }
      });
    }

    if (document.querySelector('.tp-testimonial-active')) {
      new Swiper('.tp-testimonial-active', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        touchReleaseOnEdges: true,
        passiveListeners: true,
        breakpoints: {
          '768': { slidesPerView: 2 }
        }
      });
    }
  }

  // =========================================================================
  // MGM Intelligent Autoplay Video Observer & Interactive Controls
  // =========================================================================
  initAutoplayVideos();
});

function initAutoplayVideos() {
  const videoContainers = document.querySelectorAll('.mgm-video-container');
  if (!videoContainers.length) return;

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.35 // 35% visible threshold
  };

  const videoObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const container = entry.target;
      const video = container.querySelector('video');
      if (!video) return;

      if (entry.isIntersecting) {
        // Video has become visible on screen
        if (!video.dataset.userPaused) {
          // Modern browsers allow autoplay if muted
          video.muted = (video.dataset.userMuted !== 'false');
          const playPromise = video.play();
          if (playPromise !== undefined) {
            playPromise.catch(err => {
              // Browser policy deferred autoplay until first interaction
              console.log('Video autoplay waiting for interaction:', err.message);
            });
          }
        }
      } else {
        // Video scrolled out of view -> pause to prevent background playback & save CPU
        if (!video.paused) {
          video.pause();
        }
      }
    });
  }, observerOptions);

  videoContainers.forEach(container => {
    const video = container.querySelector('video');
    if (!video) return;

    // Ensure playsinline and muted for maximum mobile/desktop compatibility
    video.setAttribute('playsinline', '');
    video.setAttribute('webkit-playsinline', '');
    video.muted = true;

    // Observe this video container
    videoObserver.observe(container);

    const playBtn = container.querySelector('.mgm-btn-play');
    const muteBtn = container.querySelector('.mgm-btn-mute');
    const playIcon = playBtn ? playBtn.querySelector('i') : null;
    const playLabel = playBtn ? playBtn.querySelector('.mgm-btn-label') : null;
    const muteIcon = muteBtn ? muteBtn.querySelector('i') : null;
    const muteLabel = muteBtn ? muteBtn.querySelector('.mgm-btn-label') : null;

    const updatePlayUI = () => {
      if (video.paused) {
        if (playIcon) playIcon.className = 'fa-solid fa-play';
        if (playLabel) playLabel.textContent = 'Play';
        if (playBtn) playBtn.setAttribute('aria-label', 'Play Video');
      } else {
        if (playIcon) playIcon.className = 'fa-solid fa-pause';
        if (playLabel) playLabel.textContent = 'Pause';
        if (playBtn) playBtn.setAttribute('aria-label', 'Pause Video');
      }
    };

    const updateMuteUI = () => {
      if (video.muted) {
        if (muteIcon) muteIcon.className = 'fa-solid fa-volume-xmark';
        if (muteLabel) muteLabel.textContent = 'Unmute';
        if (muteBtn) muteBtn.setAttribute('aria-label', 'Unmute Video');
      } else {
        if (muteIcon) muteIcon.className = 'fa-solid fa-volume-high';
        if (muteLabel) muteLabel.textContent = 'Mute';
        if (muteBtn) muteBtn.setAttribute('aria-label', 'Mute Video');
      }
    };

    video.addEventListener('play', updatePlayUI);
    video.addEventListener('pause', updatePlayUI);
    video.addEventListener('volumechange', updateMuteUI);

    updatePlayUI();
    updateMuteUI();

    // Play/Pause button toggle
    if (playBtn) {
      playBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (video.paused) {
          delete video.dataset.userPaused;
          video.play().catch(console.error);
        } else {
          video.dataset.userPaused = 'true';
          video.pause();
        }
      });
    }

    // Mute/Unmute button toggle
    if (muteBtn) {
      muteBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        video.muted = !video.muted;
        video.dataset.userMuted = video.muted ? 'true' : 'false';
        if (!video.muted && video.paused) {
          delete video.dataset.userPaused;
          video.play().catch(console.error);
        }
      });
    }

    // Direct click on video to toggle play/pause
    video.addEventListener('click', () => {
      if (video.paused) {
        delete video.dataset.userPaused;
        video.play().catch(console.error);
      } else {
        video.dataset.userPaused = 'true';
        video.pause();
      }
    });
  });

  // Pause when browser tab is inactive, resume when active if visible
  document.addEventListener('visibilitychange', () => {
    videoContainers.forEach(container => {
      const video = container.querySelector('video');
      if (!video) return;
      if (document.hidden) {
        if (!video.paused) video.pause();
      } else {
        const rect = container.getBoundingClientRect();
        const inView = rect.top < window.innerHeight && rect.bottom > 0;
        if (inView && !video.dataset.userPaused) {
          video.play().catch(() => {});
        }
      }
    });
  });
}


// Auto-load Quick Access Panel & Entrance Popup Engine if not already present
(function() {
  if (!document.getElementById('mgmQuickAccessScript')) {
    const qaScript = document.createElement('script');
    qaScript.id = 'mgmQuickAccessScript';
    const baseTag = document.querySelector('base');
    const originUrl = (baseTag && baseTag.href) ? baseTag.href.replace(/\/+$/, '') + '/' : (window.location.origin + '/');
    qaScript.src = originUrl + 'assets/js/quick-access-popup.js';
    document.head.appendChild(qaScript);
  }
})();
