/**
 * MGM Model School - Quick Links Sidebar Component
 */
(function() {
  function initQuickLinks() {
    var sidebar = document.getElementById('mgmQuickLinksSidebar');
    
    // If not present in static HTML, dynamically create and insert it
    if (!sidebar) {
      sidebar = document.createElement('aside');
      sidebar.id = 'mgmQuickLinksSidebar';
      sidebar.className = 'mgm-quick-sidebar is-open';
      sidebar.setAttribute('aria-label', 'Quick Links Navigation');
      sidebar.innerHTML = 
        '<button type="button" id="mgmQuickLinksHandle" class="mgm-quick-handle" aria-label="Toggle Quick Links">' +
          '<span class="mgm-quick-handle-icon"><i class="fa-solid fa-bolt"></i></span>' +
          '<span class="mgm-quick-handle-text">QUICK LINKS</span>' +
          '<i class="fa-solid fa-chevron-left mgm-handle-arrow"></i>' +
        '</button>' +
        '<div class="mgm-quick-panel">' +
          '<div class="mgm-quick-header">' +
            '<div class="d-flex align-items-center gap-2">' +
              '<div class="mgm-quick-header-icon"><i class="fa-solid fa-link"></i></div>' +
              '<div>' +
                '<h6 class="mgm-quick-title mb-0">Quick Links</h6>' +
                '<small class="mgm-quick-sub">Important Information</small>' +
              '</div>' +
            '</div>' +
            '<button type="button" id="mgmQuickLinksClose" class="mgm-quick-close" aria-label="Close Quick Links">' +
              '<i class="fa-solid fa-xmark"></i>' +
            '</button>' +
          '</div>' +
          '<ul class="mgm-quick-list">' +
            '<li><a href="/notices/" class="mgm-quick-item"><span class="mgm-quick-item-icon bg-notice"><i class="fa-solid fa-bullhorn"></i></span><span class="mgm-quick-item-text">Notices</span><i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i></a></li>' +
            '<li><a href="/mandatory-disclosure/" class="mgm-quick-item"><span class="mgm-quick-item-icon bg-disclosure"><i class="fa-solid fa-file-shield"></i></span><span class="mgm-quick-item-text">Mandatory Disclosure</span><i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i></a></li>' +
            '<li><a href="/courses-offered/" class="mgm-quick-item"><span class="mgm-quick-item-icon bg-courses"><i class="fa-solid fa-book-open-reader"></i></span><span class="mgm-quick-item-text">Courses Offered</span><i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i></a></li>' +
            '<li><a href="/admission-procedure/" class="mgm-quick-item"><span class="mgm-quick-item-icon bg-admission"><i class="fa-solid fa-user-graduate"></i></span><span class="mgm-quick-item-text">Admission Procedure</span><i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i></a></li>' +
            '<li><a href="/attendance/" class="mgm-quick-item"><span class="mgm-quick-item-icon bg-attendance"><i class="fa-solid fa-clipboard-user"></i></span><span class="mgm-quick-item-text">Attendance</span><i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i></a></li>' +
          '</ul>' +
        '</div>';
      document.body.appendChild(sidebar);
    }

    var handle = document.getElementById('mgmQuickLinksHandle');
    var closeBtn = document.getElementById('mgmQuickLinksClose');

    var autoHideTimer = null;
    var closeGraceTimer = null;
    var isHovered = false;

    function openSidebar() {
      clearTimeout(closeGraceTimer);
      sidebar.classList.add('is-open');
    }

    function scheduleClose(delay) {
      clearTimeout(closeGraceTimer);
      closeGraceTimer = setTimeout(function() {
        if (!isHovered) {
          sidebar.classList.remove('is-open');
        }
      }, delay || 250);
    }

    // 1. Initial 5-second auto-display:
    openSidebar();
    autoHideTimer = setTimeout(function() {
      if (!isHovered) {
        scheduleClose(100);
      }
    }, 5000);

    // 2. Cursor hover interaction:
    sidebar.addEventListener('mouseenter', function() {
      isHovered = true;
      clearTimeout(autoHideTimer);
      clearTimeout(closeGraceTimer);
      openSidebar();
    });

    sidebar.addEventListener('mouseleave', function() {
      isHovered = false;
      scheduleClose(300);
    });

    // 3. Tab handle click (touch on mobile & click toggle)
    if (handle) {
      handle.addEventListener('click', function(e) {
        e.stopPropagation();
        clearTimeout(autoHideTimer);
        clearTimeout(closeGraceTimer);
        if (sidebar.classList.contains('is-open')) {
          sidebar.classList.remove('is-open');
        } else {
          openSidebar();
        }
      });
    }

    // 4. Close button
    if (closeBtn) {
      closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        isHovered = false;
        clearTimeout(autoHideTimer);
        clearTimeout(closeGraceTimer);
        sidebar.classList.remove('is-open');
      });
    }

    // 5. Tap outside to close on mobile
    document.addEventListener('click', function(e) {
      if (!sidebar.contains(e.target) && sidebar.classList.contains('is-open')) {
        isHovered = false;
        sidebar.classList.remove('is-open');
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initQuickLinks);
  } else {
    initQuickLinks();
  }
})();
