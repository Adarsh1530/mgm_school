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
          '<span class="mgm-quick-handle-text">QUICK LINKS</span>' +
          '<i class="fa-solid fa-chevron-left mgm-handle-arrow"></i>' +
        '</button>' +
        '<div class="mgm-quick-panel">' +
          '<div class="mgm-quick-header">' +
            '<div class="d-flex align-items-center gap-2">' +
              '<img src="/assets/images/new-mgm-logo.png" alt="MGM School Logo" class="mgm-quick-logo">' +
              '<div class="mgm-quick-brand-wrap">' +
                '<div class="mgm-quick-school-name">MGM Model School</div>' +
                '<small class="mgm-quick-school-loc">Ayiroor, Varkala</small>' +
              '</div>' +
            '</div>' +
          '</div>' +
          '<ul class="mgm-quick-list">' +
            '<li><a href="/notices/" class="mgm-quick-item"><span class="mgm-quick-item-text">Notices</span></a></li>' +
            '<li><a href="/mandatory-disclosure/" class="mgm-quick-item"><span class="mgm-quick-item-text">Mandatory Disclosure</span></a></li>' +
            '<li><a href="/courses-offered/" class="mgm-quick-item"><span class="mgm-quick-item-text">Courses Offered</span></a></li>' +
            '<li><a href="/admission-procedure/" class="mgm-quick-item"><span class="mgm-quick-item-text">Admission Procedure</span></a></li>' +
            '<li><a href="/attendance/" class="mgm-quick-item"><span class="mgm-quick-item-text">Attendance</span></a></li>' +
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
