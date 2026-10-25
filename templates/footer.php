<?php
/**
 * Global Footer Component
 * MGM Model School Recreation Project
 */
?>
  <!-- Footer Area -->
  <footer class="tp-footer-area">
    <div class="container custom-container-larg">
      <div class="row g-4">
        
        <!-- Column 1: School Bio -->
        <div class="col-xl-4 col-lg-4 col-md-6">
          <div class="tp-footer-widget pe-xl-4">
            <div class="tp-footer-logo mb-4">
              <a href="<?= url('/') ?>" class="d-inline-flex align-items-center gap-3 text-decoration-none">
                <div class="tp-footer-logo-badge">
                  <img src="<?= asset_url('images/new-mgm-logo.png') ?>" alt="MGM Model School" class="tp-footer-logo-img">
                </div>
                <div class="tp-footer-brand-text">
                  <span class="tp-footer-brand-title">MGM MODEL SCHOOL</span>
                  <span class="tp-footer-brand-sub">AYIROOR, VARKALA &bull; ESTD 1983</span>
                </div>
              </a>
            </div>
            <p class="text-white">
              Since 1983, MGM Model School has been committed to academic excellence, innovation, and character building. With modern facilities and experienced educators, we nurture confident, responsible, and future-ready learners.
            </p>
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="col-xl-3 col-lg-3 col-md-6">
          <div class="tp-footer-widget">
            <h4 class="tp-footer-widget-title">Quick Links</h4>
            <ul class="tp-footer-links">
              <li><a href="<?= url('/about-us/') ?>">About Us</a></li>
              <li><a href="<?= url('/courses-offered/') ?>">Courses</a></li>
              <li><a href="<?= url('/mandatory-disclosure/') ?>">Mandatory Disclosure</a></li>
              <li><a href="<?= url('/admission-procedure/') ?>">Admission</a></li>
              <li><a href="<?= url('/gallery/') ?>">Gallery</a></li>
              <li><a href="<?= url('/alumni/') ?>">Alumni</a></li>
            </ul>
          </div>
        </div>

        <!-- Column 3: Reach Us -->
        <div class="col-xl-5 col-lg-5 col-md-12">
          <div class="tp-footer-widget">
            <h4 class="tp-footer-widget-title">Reach Us</h4>
            
            <div class="tp-footer-contact-item">
              <i class="fa-solid fa-location-dot"></i>
              <div class="text-white"><?= e(get_setting('school_address', 'MGM Model School, Ayiroor, Varkala 695310, Kerala, India')) ?></div>
            </div>

            <div class="tp-footer-contact-item">
              <i class="fa-solid fa-phone"></i>
              <div>
                <a href="tel:<?= e(get_setting('phone_primary')) ?>" class="text-white d-block"><?= e(get_setting('phone_primary')) ?></a>
                <a href="tel:<?= e(get_setting('phone_secondary')) ?>" class="text-white d-block" style="font-size: 13.5px;"><?= e(get_setting('phone_secondary')) ?></a>
              </div>
            </div>

            <div class="tp-footer-contact-item">
              <i class="fa-solid fa-envelope"></i>
              <div>
                <a href="mailto:<?= e(get_setting('email_primary')) ?>" class="text-white d-block"><?= e(get_setting('email_primary')) ?></a>
                <a href="mailto:<?= e(get_setting('email_secondary')) ?>" class="text-white d-block" style="font-size: 13.5px;"><?= e(get_setting('email_secondary')) ?></a>
              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- Copyright Bottom Bar -->
      <div class="tp-footer-bottom">
        <div class="row align-items-center">
          <div class="col-12">
            <p class="mb-0 text-dark fw-semibold" style="color: #000000 !important;">
              <?= get_setting('copyright_text', '© 2026 All rights reserved. MGM Model School Design & Developed By DigitalEdenzIndia.') ?>
            </p>
          </div>
        </div>
      </div>

    </div>
  </footer>

  <!-- Scripts -->
  <script src="<?= asset_url('js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= asset_url('js/swiper-bundle.min.js') ?>"></script>
  <script src="<?= asset_url('js/main.js') ?>"></script>
  <script src="<?= asset_url('js/quick-access-popup.js') ?>"></script>
</body>
</html>
