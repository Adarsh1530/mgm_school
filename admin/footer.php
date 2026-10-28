<?php
/**
 * Admin Panel Footer
 * MGM Model School Recreation Project
 */
?>
    </main>

    <footer class="admin-footer bg-white">
      <div class="admin-footer-text">
        <strong>MGM Model School</strong> | Admin Portal - Content Management System | &copy; <?= date('Y') ?> | <em>Technology Partner:</em> <a href="https://sparkitts.com" target="_blank" rel="noopener noreferrer"><strong>SparkIT Techno Solutions Pvt. Ltd.</strong></a>
      </div>
      <div class="admin-footer-brand">
        <a href="https://sparkitts.com" target="_blank" rel="noopener noreferrer" title="SparkIT Techno Solutions Pvt. Ltd." class="sparkit-footer-logo-link">
          <video id="sparkitFooterVideo" autoplay muted loop playsinline preload="auto" class="sparkit-footer-logo-video" poster="<?= asset_url('images/sparkit-logo-poster.png') ?>" aria-label="SparkIT Techno Solutions Animated Logo">
            <source src="<?= asset_url('videos/sparkitts-logo-animation.mp4') ?>" type="video/mp4">
          </video>
        </a>
      </div>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
      document.getElementById('adminSidebar')?.classList.toggle('show');
      document.getElementById('sidebarBackdrop')?.classList.toggle('show');
    });
    document.getElementById('sidebarBackdrop')?.addEventListener('click', function() {
      document.getElementById('adminSidebar')?.classList.remove('show');
      this.classList.remove('show');
    });

    // SparkIT Logo Animation Continuous 5-Second Loop Controller
    (function() {
      var sparkitVideo = document.getElementById('sparkitFooterVideo');
      if (!sparkitVideo) return;

      // Autoplay safeguard for browsers
      var attemptPlay = function() {
        sparkitVideo.muted = true;
        var promise = sparkitVideo.play();
        if (promise !== undefined) {
          promise.catch(function() {});
        }
      };

      // Restart cycle after every 5 seconds
      sparkitVideo.addEventListener('timeupdate', function() {
        if (this.currentTime >= 5.0) {
          this.currentTime = 0;
          this.play().catch(function() {});
        }
      });

      sparkitVideo.addEventListener('ended', function() {
        this.currentTime = 0;
        attemptPlay();
      });

      attemptPlay();
    })();
  </script>
</body>
</html>
