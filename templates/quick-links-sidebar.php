<?php
/**
 * Quick Links Sidebar Component
 * MGM Model School Website
 */
?>
<!-- Quick Links Floating Sidebar -->
<aside id="mgmQuickLinksSidebar" class="mgm-quick-sidebar is-open" aria-label="Quick Links Navigation">
  
  <!-- Edge Toggle Handle (Peeking Tab) -->
  <button type="button" id="mgmQuickLinksHandle" class="mgm-quick-handle" aria-label="Toggle Quick Links">
    <span class="mgm-quick-handle-icon">
      <i class="fa-solid fa-bolt"></i>
    </span>
    <span class="mgm-quick-handle-text">QUICK LINKS</span>
    <i class="fa-solid fa-chevron-left mgm-handle-arrow"></i>
  </button>

  <!-- Sidebar Panel -->
  <div class="mgm-quick-panel">
    <!-- Panel Header -->
    <div class="mgm-quick-header">
      <div class="d-flex align-items-center gap-2">
        <div class="mgm-quick-header-icon">
          <i class="fa-solid fa-link"></i>
        </div>
        <div>
          <h6 class="mgm-quick-title mb-0">Quick Links</h6>
          <small class="mgm-quick-sub">Important Information</small>
        </div>
      </div>
      <button type="button" id="mgmQuickLinksClose" class="mgm-quick-close" aria-label="Close Quick Links">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Links List -->
    <ul class="mgm-quick-list">
      <li>
        <a href="<?= url('/notices/') ?>" class="mgm-quick-item">
          <span class="mgm-quick-item-icon bg-notice">
            <i class="fa-solid fa-bullhorn"></i>
          </span>
          <span class="mgm-quick-item-text">Notices</span>
          <i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i>
        </a>
      </li>
      <li>
        <a href="<?= url('/mandatory-disclosure/') ?>" class="mgm-quick-item">
          <span class="mgm-quick-item-icon bg-disclosure">
            <i class="fa-solid fa-file-shield"></i>
          </span>
          <span class="mgm-quick-item-text">Mandatory Disclosure</span>
          <i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i>
        </a>
      </li>
      <li>
        <a href="<?= url('/courses-offered/') ?>" class="mgm-quick-item">
          <span class="mgm-quick-item-icon bg-courses">
            <i class="fa-solid fa-book-open-reader"></i>
          </span>
          <span class="mgm-quick-item-text">Courses Offered</span>
          <i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i>
        </a>
      </li>
      <li>
        <a href="<?= url('/admission-procedure/') ?>" class="mgm-quick-item">
          <span class="mgm-quick-item-icon bg-admission">
            <i class="fa-solid fa-user-graduate"></i>
          </span>
          <span class="mgm-quick-item-text">Admission Procedure</span>
          <i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i>
        </a>
      </li>
      <li>
        <a href="<?= url('/attendance/') ?>" class="mgm-quick-item">
          <span class="mgm-quick-item-icon bg-attendance">
            <i class="fa-solid fa-clipboard-user"></i>
          </span>
          <span class="mgm-quick-item-text">Attendance</span>
          <i class="fa-solid fa-angle-right mgm-quick-item-arrow"></i>
        </a>
      </li>
    </ul>
  </div>
</aside>

<style>
/* Quick Links Sidebar Styles */
.mgm-quick-sidebar {
  position: fixed;
  top: 50%;
  right: 0;
  transform: translateY(-50%) translateX(100%);
  z-index: 99990;
  display: flex;
  align-items: center;
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  font-family: var(--tp-ff-heading, 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif);
}

.mgm-quick-sidebar.is-open {
  transform: translateY(-50%) translateX(0);
}

/* Tab Handle docked on the left of the panel */
.mgm-quick-handle {
  position: absolute;
  right: 100%;
  top: 50%;
  transform: translateY(-50%);
  background: var(--tp-theme-primary, #ab0c2f);
  color: #ffffff;
  border: none;
  padding: 14px 10px;
  border-radius: 12px 0 0 12px;
  cursor: pointer;
  box-shadow: -4px 0 15px rgba(0, 0, 0, 0.15);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  transition: background 0.25s, transform 0.25s;
  user-select: none;
}

.mgm-quick-handle:hover {
  background: #8b0724;
}

.mgm-quick-handle-icon {
  font-size: 15px;
  color: #ffeb3b;
}

.mgm-quick-handle-text {
  writing-mode: vertical-rl;
  text-orientation: mixed;
  transform: rotate(180deg);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: #ffffff;
}

.mgm-handle-arrow {
  font-size: 11px;
  transition: transform 0.35s ease;
}

.mgm-quick-sidebar.is-open .mgm-handle-arrow {
  transform: rotate(180deg);
}

/* Main Panel */
.mgm-quick-panel {
  width: 275px;
  background: #ffffff;
  border-radius: 16px 0 0 16px;
  box-shadow: -6px 0 30px rgba(0, 0, 0, 0.16);
  overflow: hidden;
  border: 1px solid rgba(0, 0, 0, 0.08);
  border-right: none;
}

/* Header */
.mgm-quick-header {
  background: linear-gradient(135deg, #ab0c2f 0%, #870823 100%);
  color: #ffffff;
  padding: 16px 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.mgm-quick-header-icon {
  width: 34px;
  height: 34px;
  background: rgba(255, 255, 255, 0.18);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  color: #ffffff;
}

.mgm-quick-title {
  font-size: 15px;
  font-weight: 700;
  color: #ffffff;
  letter-spacing: 0.2px;
}

.mgm-quick-sub {
  font-size: 11px;
  color: rgba(255, 255, 255, 0.8);
}

.mgm-quick-close {
  background: transparent;
  border: none;
  color: rgba(255, 255, 255, 0.7);
  font-size: 18px;
  cursor: pointer;
  padding: 4px 6px;
  border-radius: 6px;
  transition: color 0.2s, background 0.2s;
}

.mgm-quick-close:hover {
  color: #ffffff;
  background: rgba(255, 255, 255, 0.2);
}

/* Links List */
.mgm-quick-list {
  list-style: none;
  padding: 8px 0;
  margin: 0;
}

.mgm-quick-list li {
  margin: 0;
}

.mgm-quick-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 18px;
  text-decoration: none;
  color: #1e293b;
  font-size: 13.5px;
  font-weight: 600;
  transition: all 0.22s ease;
  border-left: 3px solid transparent;
}

.mgm-quick-item:hover {
  background: #FFF5F7;
  color: var(--tp-theme-primary, #ab0c2f);
  border-left-color: var(--tp-theme-primary, #ab0c2f);
  padding-left: 22px;
}

.mgm-quick-item-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  flex-shrink: 0;
  transition: transform 0.2s ease;
}

.mgm-quick-item:hover .mgm-quick-item-icon {
  transform: scale(1.1);
}

.bg-notice { background: rgba(239, 68, 68, 0.12); color: #EF4444; }
.bg-disclosure { background: rgba(59, 130, 246, 0.12); color: #2563EB; }
.bg-courses { background: rgba(16, 185, 129, 0.12); color: #059669; }
.bg-admission { background: rgba(245, 158, 11, 0.12); color: #D97706; }
.bg-attendance { background: rgba(139, 92, 246, 0.12); color: #7C3AED; }

.mgm-quick-item-text {
  flex-grow: 1;
  white-space: nowrap;
}

.mgm-quick-item-arrow {
  font-size: 11px;
  color: #cbd5e1;
  transition: transform 0.2s, color 0.2s;
}

.mgm-quick-item:hover .mgm-quick-item-arrow {
  color: var(--tp-theme-primary, #ab0c2f);
  transform: translateX(3px);
}

/* Mobile Styling */
@media (max-width: 576px) {
  .mgm-quick-panel {
    width: 245px;
  }
  .mgm-quick-item {
    padding: 10px 14px;
    font-size: 13px;
  }
  .mgm-quick-handle {
    padding: 10px 8px;
  }
}
</style>

<script>
(function() {
  function initQuickLinks() {
    var sidebar = document.getElementById('mgmQuickLinksSidebar');
    var handle = document.getElementById('mgmQuickLinksHandle');
    var closeBtn = document.getElementById('mgmQuickLinksClose');
    if (!sidebar) return;

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
    // Sidebar starts open; after 5 seconds of inactivity, auto-hide
    openSidebar();
    autoHideTimer = setTimeout(function() {
      if (!isHovered) {
        scheduleClose(100);
      }
    }, 5000);

    // 2. Cursor hover interaction:
    // When visitor moves cursor over the sidebar or handle, show it
    sidebar.addEventListener('mouseenter', function() {
      isHovered = true;
      clearTimeout(autoHideTimer);
      clearTimeout(closeGraceTimer);
      openSidebar();
    });

    // When cursor moves away, hide it
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
</script>
