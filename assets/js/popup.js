/**
 * MGM Model School - Universal Image Popup Notification Handler
 */
(function() {
  function initStaticPopup() {
    // If modal already exists from PHP template, let the template script handle it
    if (document.getElementById('mgmPopupModal')) {
      return;
    }

    // Check if dismissed in this session
    if (sessionStorage.getItem('mgm_popup_dismissed') === '1') {
      return;
    }

    // Fetch popup status from API
    fetch('/api/popup.php')
      .then(function(res) {
        if (!res.ok) throw new Error('Network error');
        return res.json();
      })
      .then(function(data) {
        if (!data || !data.active || !data.popup) return;

        var p = data.popup;
        var imageUrl = p.display_image_url || p.image_url;
        var title = p.title || 'Announcement';
        var linkUrl = p.link_url || '';

        // Build overlay
        var overlay = document.createElement('div');
        overlay.id = 'mgmPopupModal';
        overlay.className = 'mgm-popup-overlay';
        overlay.style.display = 'none';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('aria-label', title);

        var innerHtml = '<div class="mgm-popup-dialog">' +
          '<button type="button" class="mgm-popup-close-btn" id="mgmPopupCloseBtn" aria-label="Close Announcement">' +
          '<i class="fa-solid fa-xmark"></i>' +
          '</button>' +
          '<div class="mgm-popup-body">';

        if (linkUrl) {
          innerHtml += '<a href="' + linkUrl + '" class="mgm-popup-link" title="' + title + '">' +
            '<img src="' + imageUrl + '" alt="' + title + '" class="mgm-popup-img" loading="eager">' +
            '</a>';
        } else {
          innerHtml += '<img src="' + imageUrl + '" alt="' + title + '" class="mgm-popup-img" loading="eager">';
        }

        innerHtml += '</div>';

        innerHtml += '</div>';
        overlay.innerHTML = innerHtml;
        document.body.appendChild(overlay);

        var closeBtn = document.getElementById('mgmPopupCloseBtn');

        setTimeout(function() {
          overlay.style.display = 'flex';
          overlay.offsetHeight;
          overlay.classList.add('show');
        }, 600);

        function close() {
          overlay.classList.remove('show');
          sessionStorage.setItem('mgm_popup_dismissed', '1');
          setTimeout(function() {
            overlay.style.display = 'none';
          }, 350);
        }

        if (closeBtn) {
          closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            close();
          });
        }

        overlay.addEventListener('click', function(e) {
          if (e.target === overlay) {
            close();
          }
        });

        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape' && overlay.classList.contains('show')) {
            close();
          }
        });
      })
      .catch(function(err) {
        // Silently ignore network failures for popup
      });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initStaticPopup);
  } else {
    initStaticPopup();
  }
})();
