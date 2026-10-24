<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');

$heroMarkup = <<<HTML
<section class="tp-hero-area tp-el-section">
  <div class="swiper tp-slider-active">
    <div class="swiper-wrapper">
      
      <!-- Slide 1 -->
      <div class="swiper-slide">
        <div class="tp-hero-item">
          <div class="container">
            <div class="row">
              <div class="col-xxl-9 col-lg-11">
                <div class="tp-hero-wrapper">
                  <span class="tp-hero-subtitle tp-el-subtitle">
                    A campus designed for learning, growth, and creativity in every student.
                  </span>
                  <h2 class="tp-hero-title tp-el-title tp-hero-title-banking p-relative">Excellence in Learning and Innovation</h2>
                  <div class="tp-hero-btn">
                    <a class="tp-btn" href="/admission-procedure/">
                      Learn More About Our Campus
                      <span>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1 7H13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                          <path d="M7 1L13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tp-hero-bg" style="background-image: url('assets/images/Untitled-design-4.png')"></div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="swiper-slide">
        <div class="tp-hero-item">
          <div class="container">
            <div class="row">
              <div class="col-xxl-9 col-lg-11">
                <div class="tp-hero-wrapper">
                  <span class="tp-hero-subtitle tp-el-subtitle">
                    Building a foundation for knowledge, ethics, and global citizenship.
                  </span>
                  <h2 class="tp-hero-title tp-el-title tp-hero-title-banking p-relative">Shaping Future Leaders with Holistic Education</h2>
                  <div class="tp-hero-btn">
                    <a class="tp-btn" href="/courses-offered/">
                      Explore Our Courses
                      <span>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M1 7H13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                          <path d="M7 1L13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tp-hero-bg" style="background-image: url('assets/images/Untitled-design-16.jpg')"></div>
        </div>
      </div>

    </div>
  </div>
</section>
HTML;

$html = preg_replace('#<section class="tp-hero-area tp-el-section">.*?</section>#is', $heroMarkup, $html);

file_put_contents('audit/homepage_clean_extracted.html', $html);
echo "Hero section updated successfully!\n";
