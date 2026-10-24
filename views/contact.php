<?php
/**
 * Contact Us View
 * MGM Model School Recreation Project - Contact Details & Interactive Google Maps
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "contact";
$pageTitle = "Contact Us";
$breadcrumbTitle = "Contact Us";
$metaDescription = "Get in touch with MGM Model School, Ayiroor, Varkala. Official contact details, helpline numbers, and interactive Google campus location map.";

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<div class="tp-subpage-container py-5" style="background: #FAF8F5;">
  <div class="container custom-container-larg">
    
    <div class="text-center mb-5">
      <span class="badge px-3 py-2 text-uppercase mb-2" style="background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); font-size: 11px; letter-spacing: 1px; font-weight: 700;">Connect With Us</span>
      <h2 class="tp-section-title mb-2" style="font-size: 34px; font-weight: 700; color: #141B2B;">Get in Touch with MGM Model School</h2>
      <p class="text-muted mx-auto" style="max-width: 650px;">We welcome prospective parents, alumni, and visitors to connect directly with our administrative desk, admission helpline, and campus in Ayiroor, Varkala.</p>
    </div>

    <!-- Main 2-Column Row: Left (Contact Details) | Right (Current Location on Google Map) -->
    <div class="row g-4 align-items-stretch">
      
      <!-- Left Column: Campus Contact Information -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
              <h4 class="fw-bold text-dark mb-0" style="font-size: 22px;">
                <i class="fa-solid fa-address-book text-danger me-2"></i>Campus Contact Information
              </h4>
              <span class="badge bg-light text-secondary border px-2 py-1 small">Official Desk</span>
            </div>

            <!-- Contact Item: Address -->
            <div class="d-flex align-items-start gap-3 mb-4">
              <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(171,12,47,0.1); color: var(--tp-theme-primary, #ab0c2f); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <div>
                <span class="text-muted small d-block fw-semibold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Campus Location</span>
                <span class="fw-bold text-dark" style="font-size: 16px;">MGM Model School</span>
                <div class="text-secondary small mt-1" style="line-height: 1.6;">
                  Ayiroor, Varkala – 695310,<br>
                  Thiruvananthapuram District, Kerala, India
                </div>
              </div>
            </div>

            <!-- Contact Item: Telephones -->
            <div class="d-flex align-items-start gap-3 mb-4">
              <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(37,99,235,0.1); color: #2563EB; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-phone-volume"></i>
              </div>
              <div>
                <span class="text-muted small d-block fw-semibold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Phone Helpline & Inquiries</span>
                <div class="d-flex flex-wrap gap-2 mt-2">
                  <a href="tel:04702602193" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1 fw-bold text-dark bg-light border" style="font-size: 14px;">
                    <i class="fa-solid fa-phone text-primary me-1"></i> 0470-2602193
                  </a>
                  <a href="tel:8891509590" class="btn btn-outline-success btn-sm rounded-pill px-3 py-1 fw-bold text-dark bg-light border" style="font-size: 14px;">
                    <i class="fa-brands fa-whatsapp text-success me-1"></i> +91 8891509590
                  </a>
                </div>
              </div>
            </div>

            <!-- Contact Item: Emails -->
            <div class="d-flex align-items-start gap-3 mb-4">
              <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(22,163,74,0.1); color: #16A34A; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-envelope-open-text"></i>
              </div>
              <div>
                <span class="text-muted small d-block fw-semibold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Official Email Desks</span>
                <div class="d-flex flex-column gap-2 mt-2">
                  <a href="mailto:mgmmodelschools@gmail.com" class="fw-semibold text-dark text-decoration-none small d-inline-flex align-items-center">
                    <i class="fa-regular fa-envelope me-2 text-danger"></i> mgmmodelschools@gmail.com
                  </a>
                  <a href="mailto:mgmmodelschool@rediffmail.com" class="fw-semibold text-secondary text-decoration-none small d-inline-flex align-items-center">
                    <i class="fa-regular fa-envelope me-2 text-muted"></i> mgmmodelschool@rediffmail.com
                  </a>
                </div>
              </div>
            </div>

            <!-- Contact Item: Office Timings -->
            <div class="d-flex align-items-start gap-3 mb-4">
              <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(217,119,6,0.1); color: #D97706; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fa-solid fa-clock"></i>
              </div>
              <div>
                <span class="text-muted small d-block fw-semibold text-uppercase" style="letter-spacing: 0.5px; font-size: 11px;">Office & Visiting Hours</span>
                <span class="fw-bold text-dark d-block mt-1" style="font-size: 14px;">Monday &ndash; Friday: 8:30 AM &ndash; 4:00 PM</span>
                <div class="text-muted small mt-1">Saturday: 9:00 AM &ndash; 1:00 PM &bull; Closed on Sundays &amp; Public Holidays</div>
              </div>
            </div>
          </div>

          <!-- Campus Visiting Guidance Note -->
          <div class="p-3 rounded-3 mt-3" style="background: #F8FAFC; border: 1px solid #E2E8F0;">
            <div class="d-flex align-items-center gap-2 text-dark small">
              <i class="fa-solid fa-circle-info text-primary fs-6"></i>
              <span><strong>Visiting Information:</strong> Prior appointment recommended for administrative meetings and campus walkthroughs.</span>
            </div>
          </div>

        </div>
      </div>

      <!-- Right Column: School Current Location on Google Map -->
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100 d-flex flex-column">
          
          <div class="p-4 bg-white border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
              <span class="badge bg-danger px-3 py-1 text-uppercase mb-1" style="font-size: 10px;">Interactive Campus Map</span>
              <h5 class="fw-bold text-dark mb-0">School's Location in Ayiroor, Varkala</h5>
            </div>
            <a href="https://maps.google.com/?q=MGM+Model+School+Ayiroor+Varkala" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-danger rounded-pill fw-semibold">
              <i class="fa-solid fa-diamond-turn-right me-1"></i> Get Directions
            </a>
          </div>

          <!-- Embedded Google Map -->
          <div class="flex-grow-1 position-relative" style="min-height: 480px; width: 100%;">
            <iframe 
              src="https://maps.google.com/maps?q=MGM+Model+School+Ayiroor+Varkala+Kerala&t=&z=15&ie=UTF8&iwloc=&output=embed" 
              width="100%" 
              height="100%" 
              style="border: 0; min-height: 480px; width: 100%; display: block;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade"
              title="MGM Model School Current Campus Location">
            </iframe>
          </div>

          <div class="p-3 bg-light border-top text-center text-muted small">
            <i class="fa-solid fa-map-pin text-danger me-1"></i> Landmark: Near Ayiroor Temple Road, Varkala &bull; Convenient transportation routes available
          </div>

        </div>
      </div>

    </div>

  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
