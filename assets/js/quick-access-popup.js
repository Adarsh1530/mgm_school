/**
 * MGM Model School - Public Features Engine
 * 1. Pure Image Entrance Popup Modal (Synced with Admin Panel)
 * 2. Interactive Quick Access Floating Tab
 * 3. Global Keyboard Shortcut Keys Navigation
 */

if (!window.__mgmQuickAccessLoaded) {
  window.__mgmQuickAccessLoaded = true;

  const initMGMFeatures = () => {

  // Detect base URL dynamically
  const getBaseUrl = () => {
    const baseTag = document.querySelector('base');
    if (baseTag && baseTag.href) return baseTag.href.replace(/\/+$/, '') + '/';
    return window.location.origin + '/';
  };
  const baseUrl = getBaseUrl();

  // -------------------------------------------------------------
  // 1. PURE IMAGE ENTRANCE POPUP MODAL ENGINE
  // -------------------------------------------------------------
  function initEntrancePopup() {
    fetch(baseUrl + 'api/get_popup.php?t=' + Date.now())
      .then(res => res.json())
      .then(data => {
        if (!data || !data.is_active || !data.image_url) return;

        // Session frequency check
        if (data.display_mode === 'session' && sessionStorage.getItem('mgm_popup_dismissed') === '1') {
          return;
        }

        const modalOverlay = document.createElement('div');
        modalOverlay.className = 'site-entrance-popup-overlay';
        modalOverlay.id = 'mgmEntrancePopup';

        const imgSrc = data.image_url.startsWith('http') ? data.image_url : (baseUrl + data.image_url.replace(/^\/+/, ''));
        const redirectUrl = (data.redirect_url || '').trim();
        const fullRedirect = redirectUrl ? (redirectUrl.startsWith('http') ? redirectUrl : (baseUrl + redirectUrl.replace(/^\/+/, ''))) : '';

        modalOverlay.innerHTML = `
          <div class="site-entrance-popup-card pure-image">
            <button class="site-entrance-popup-close" aria-label="Close Announcement">&times;</button>
            <div class="site-entrance-popup-img-wrap">
              ${fullRedirect ? `
                <a href="${fullRedirect}" class="site-entrance-popup-link" title="Click to view details" style="display:block; cursor:pointer;">
                  <img src="${imgSrc}" alt="${data.title || 'Announcement'}">
                </a>
              ` : `
                <img src="${imgSrc}" alt="${data.title || 'Announcement'}">
              `}
            </div>
          </div>
        `;

        document.body.appendChild(modalOverlay);

        const delay = parseInt(data.show_delay, 10) || 800;
        setTimeout(() => {
          modalOverlay.classList.add('active');
        }, delay);

        function closePopup(e) {
          if (e) {
            if (e.preventDefault) e.preventDefault();
            if (e.stopPropagation) e.stopPropagation();
          }
          modalOverlay.classList.remove('active');
          sessionStorage.setItem('mgm_popup_dismissed', '1');
          setTimeout(() => {
            if (modalOverlay.parentNode) {
              modalOverlay.parentNode.removeChild(modalOverlay);
            }
          }, 350);
        }

        const closeBtn = modalOverlay.querySelector('.site-entrance-popup-close');
        if (closeBtn) {
          closeBtn.addEventListener('click', closePopup);
          closeBtn.addEventListener('touchend', closePopup, { passive: false });
        }

        modalOverlay.addEventListener('click', (e) => {
          if (e.target === modalOverlay) closePopup(e);
        });

        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
            closePopup(e);
          }
        });
      })
      .catch(err => console.debug('Popup engine info:', err));
  }

  // -------------------------------------------------------------
  // 2. QUICK ACCESS FLOATING PANEL INJECTION & INTERACTION
  // -------------------------------------------------------------
  function initQuickAccessPanel() {
    let panel = document.getElementById('quickAccessPanel');
    if (!panel) {
      panel = document.createElement('aside');
      panel.className = 'quick-access-panel';
      panel.id = 'quickAccessPanel';
      panel.setAttribute('aria-label', 'Quick Navigation Links');

      panel.innerHTML = `
        <button class="quick-access-toggle-btn" id="quickAccessToggleBtn" aria-label="Toggle Quick Links Menu" title="Toggle Quick Links (Shortcut: Q)">
          <span class="toggle-icon-wrap">
            <svg class="toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
          </span>
          <span class="toggle-label">QUICK LINKS</span>
        </button>
        <div class="quick-access-menu-card">
          <div class="quick-access-header">
            <a href="${baseUrl}" class="quick-access-header-brand">
              <img src="${baseUrl}assets/images/new-mgm-logo.png" alt="MGM Crest">
              <span>QUICK ACCESS</span>
            </a>
            <span class="badge bg-warning bg-opacity-25 text-warning fw-bold" style="font-size: 9px; padding: 3px 6px;">KEYS ACTIVE</span>
          </div>
          <nav class="quick-access-nav">
            <a href="${baseUrl}admission-procedure/" class="quick-access-item" title="Admission Procedure (Press 'A')">
              <div class="quick-access-item-left">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>ADMISSIONS</span>
              </div>
              <span class="shortcut-key-badge" title="Shortcut key: A">A</span>
            </a>
            <a href="${baseUrl}notices/" class="quick-access-item" title="School Notices (Press 'N')">
              <div class="quick-access-item-left">
                <i class="fa-solid fa-bullhorn"></i>
                <span>NOTICES</span>
              </div>
              <span class="shortcut-key-badge" title="Shortcut key: N">N</span>
            </a>
            <a href="${baseUrl}mandatory-disclosure/" class="quick-access-item" title="Mandatory CBSE Disclosures (Press 'D')">
              <div class="quick-access-item-left">
                <i class="fa-solid fa-file-pdf"></i>
                <span>DISCLOSURES</span>
              </div>
              <span class="shortcut-key-badge" title="Shortcut key: D">D</span>
            </a>
            <a href="${baseUrl}gallery/" class="quick-access-item" title="Photo Gallery (Press 'G')">
              <div class="quick-access-item-left">
                <i class="fa-solid fa-images"></i>
                <span>GALLERY</span>
              </div>
              <span class="shortcut-key-badge" title="Shortcut key: G">G</span>
            </a>
            <a href="${baseUrl}courses-offered/" class="quick-access-item" title="Courses & Curriculum (Press 'C')">
              <div class="quick-access-item-left">
                <i class="fa-solid fa-book-open"></i>
                <span>COURSES</span>
              </div>
              <span class="shortcut-key-badge" title="Shortcut key: C">C</span>
            </a>
            <a href="${baseUrl}contact/" class="quick-access-item" title="Contact Us (Press 'T')">
              <div class="quick-access-item-left">
                <i class="fa-solid fa-phone"></i>
                <span>CONTACT</span>
              </div>
              <span class="shortcut-key-badge" title="Shortcut key: T">T</span>
            </a>
          </nav>
          <div class="quick-access-footer-hint">
            <span>Press <kbd style="background:rgba(255,255,255,0.2);color:#fff;padding:1px 4px;border-radius:3px;">Q</kbd> to toggle &bull; Shortcuts ready</span>
          </div>
        </div>
      `;
      document.body.appendChild(panel);
    }

    const toggleBtn = panel.querySelector('#quickAccessToggleBtn') || panel.querySelector('.quick-access-toggle-btn');
    if (!toggleBtn) return;

    let isHovered = false;
    let hasAutoCollapsed = false;

    // 1. Auto-peek for 4 seconds on page load
    panel.classList.add('auto-peek');
    const autoHideTimer = setTimeout(() => {
      hasAutoCollapsed = true;
      panel.classList.remove('auto-peek');
      if (!isHovered) {
        panel.classList.add('is-collapsed');
        panel.classList.remove('is-expanded', 'expanded');
      }
    }, 4000);

    // 2. Desktop hover handling
    const isPointerFine = () => window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    panel.addEventListener('mouseenter', () => {
      if (!isPointerFine()) return;
      isHovered = true;
      panel.classList.remove('is-collapsed', 'auto-peek');
      panel.classList.add('is-expanded', 'expanded');
    });

    panel.addEventListener('mouseleave', () => {
      if (!isPointerFine()) return;
      isHovered = false;
      if (hasAutoCollapsed) {
        panel.classList.add('is-collapsed');
        panel.classList.remove('is-expanded', 'expanded', 'auto-peek');
      }
    });

    // 3. Toggle click / touch
    function togglePanel(e) {
      if (e) {
        e.stopPropagation();
        if (e.cancelable && e.type === 'touchend') e.preventDefault();
      }
      if (autoHideTimer) clearTimeout(autoHideTimer);
      hasAutoCollapsed = true;
      panel.classList.remove('auto-peek');

      const isExpanded = panel.classList.contains('is-expanded') || panel.classList.contains('expanded') || !panel.classList.contains('is-collapsed');
      if (isExpanded) {
        panel.classList.add('is-collapsed');
        panel.classList.remove('is-expanded', 'expanded');
      } else {
        panel.classList.remove('is-collapsed');
        panel.classList.add('is-expanded', 'expanded');
      }
    }

    toggleBtn.addEventListener('click', togglePanel);
    toggleBtn.addEventListener('touchend', togglePanel, { passive: false });

    // 4. Click outside to collapse
    document.addEventListener('click', (e) => {
      if (!panel.contains(e.target)) {
        if (autoHideTimer) clearTimeout(autoHideTimer);
        hasAutoCollapsed = true;
        panel.classList.remove('auto-peek', 'is-expanded', 'expanded');
        panel.classList.add('is-collapsed');
      }
    });

    return { togglePanel };
  }

  // -------------------------------------------------------------
  // 3. GLOBAL KEYBOARD SHORTCUT KEYS ENGINE (PUBLIC PANEL)
  // -------------------------------------------------------------
  function initShortcutKeys(panelController) {
    document.addEventListener('keydown', (e) => {
      // Ignore if user is currently typing inside an input, textarea or contenteditable element
      const activeTag = (document.activeElement && document.activeElement.tagName) ? document.activeElement.tagName.toUpperCase() : '';
      if (activeTag === 'INPUT' || activeTag === 'TEXTAREA' || activeTag === 'SELECT' || (document.activeElement && document.activeElement.isContentEditable)) {
        return;
      }

      // Ignore if modifier keys (Ctrl, Alt, Meta/Command) are pressed
      if (e.ctrlKey || e.altKey || e.metaKey) {
        return;
      }

      const key = e.key.toUpperCase();

      switch (key) {
        case 'Q': // Toggle Quick Links Panel
          e.preventDefault();
          if (panelController && panelController.togglePanel) {
            panelController.togglePanel();
          }
          break;

        case 'A': // Admissions
          e.preventDefault();
          window.location.href = baseUrl + 'admission-procedure/';
          break;

        case 'N': // Notices
          e.preventDefault();
          window.location.href = baseUrl + 'notices/';
          break;

        case 'D': // Mandatory Disclosures
          e.preventDefault();
          window.location.href = baseUrl + 'mandatory-disclosure/';
          break;

        case 'G': // Gallery
          e.preventDefault();
          window.location.href = baseUrl + 'gallery/';
          break;

        case 'C': // Courses
          e.preventDefault();
          window.location.href = baseUrl + 'courses-offered/';
          break;

        case 'T': // Contact Us
          e.preventDefault();
          window.location.href = baseUrl + 'contact/';
          break;

        case 'ESCAPE': // Close Panel or Popup
          const panel = document.getElementById('quickAccessPanel');
          if (panel) {
            panel.classList.remove('auto-peek', 'is-expanded', 'expanded');
            panel.classList.add('is-collapsed');
          }
          break;
      }
    });
  }

  // Initialize features
  const start = () => {
    initEntrancePopup();
    const panelController = initQuickAccessPanel();
    initShortcutKeys(panelController);
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start);
  } else {
    start();
  }
}
