<?php
/**
 * Global Header Component
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';

$navTree = get_navigation_tree();
$pageTitle = $pageTitle ?? get_setting('site_title', 'MGM Model School');
$currentSlug = $currentSlug ?? '';
$wpId = $wpId ?? null;
$logoPath = get_setting('logo_path', 'assets/images/new-mgm-logo.png');
$phone1 = get_setting('phone_primary', '04702602193');
$email1 = get_setting('email_primary', 'mgmmodelschools@gmail.com');
$address = get_setting('school_address', 'MGM Model School, Ayiroor, Varkala 695310');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if (empty($currentSlug) || $currentSlug === 'home' || $pageTitle === 'Home'): ?>
  <title><?= e(get_setting('school_name', 'MGM School')) ?></title>
  <?php else: ?>
  <title><?= html_entity_decode(e($pageTitle), ENT_QUOTES | ENT_HTML5, 'UTF-8') ?> – <?= e(get_setting('school_name', 'MGM School')) ?></title>
  <?php endif; ?>
  <meta name="description" content="<?= e($metaDescription ?? 'Official website of MGM Model School, Ayiroor, Varkala.') ?>">
  <base href="<?= rtrim(BASE_URL, '/') ?>/">
  <link rel="canonical" href="<?= e(url($currentSlug ? '/' . $currentSlug . '/' : '')) ?>">
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= asset_url('images/new-mgm-logo.png') ?>">

  <!-- Google Fonts: Outfit, Jost, Crimson Pro -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Jost:wght@300;400;500;600;700&family=Crimson+Pro:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome & Icon Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= asset_url('css/font-awesome-pro.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/flaticon.css') ?>">

  <!-- Core Theme & Layout Stylesheets -->
  <link rel="stylesheet" href="<?= asset_url('css/bootstrap.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/animate.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/spacing.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/swiper-bundle.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/acadia-core.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/acadia-custom.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/acadia-core-tp-core.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/acadia-core-flaticon.css') ?>">

  <!-- Acadia Elementor Widget Components -->
  <link rel="stylesheet" href="<?= asset_url('css/hero.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/services.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/text-slider.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/academic-programs.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/event.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/testimonial.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/video.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/course.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/hover-reveal.css') ?>">

  <!-- Elementor Framework & Components -->
  <link rel="stylesheet" href="<?= asset_url('css/elementor-custom-frontend.min.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-base-desktop.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-custom-widget-image-box.min.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-custom-widget-icon-list.min.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-custom-pro-widget-nav-menu.min.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-widget-heading.min.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-widget-image.min.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/ninjatables-public.css') ?>">

  <!-- Header, Footer & Offcanvas Post Styles -->
  <link rel="stylesheet" href="<?= asset_url('css/elementor-post-15695.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-post-4523.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-post-843.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/elementor-post-6225.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/post-762.css') ?>">
  <link rel="stylesheet" href="<?= asset_url('css/post-200.css') ?>">

  <!-- Page-Specific Elementor Stylesheet -->
  <?php if (!empty($wpId) && file_exists(__DIR__ . '/../assets/css/post-' . $wpId . '.css')): ?>
    <link rel="stylesheet" href="<?= asset_url('css/post-' . $wpId . '.css') ?>">
  <?php endif; ?>

  <!-- Custom Refined Enhancements -->
  <link rel="stylesheet" href="<?= asset_url('css/custom.css') ?>?v=20261027_ratio">
</head>
<body class="wp-singular page page-id-<?= $wpId ?? '0' ?> wp-embed-responsive wp-theme-acadia theme-acadia elementor-default elementor-template-full-width elementor-kit-15695 elementor-page elementor-page-<?= $wpId ?? '0' ?>" id="body">

  <!-- Top Bar -->
  <div class="tp-header-top d-none d-md-block">
    <div class="container custom-container-larg">
      <div class="row align-items-center">
        <div class="col-md-7">
          <div class="d-flex align-items-center">
            <span class="me-3"><i class="fa-solid fa-location-dot text-danger me-1"></i> <?= e($address) ?></span>
          </div>
        </div>
        <div class="col-md-5 text-end">
          <a href="tel:<?= e($phone1) ?>"><i class="fa-solid fa-phone me-1"></i> <?= e($phone1) ?></a>
          <a href="mailto:<?= e($email1) ?>"><i class="fa-solid fa-envelope me-1"></i> <?= e($email1) ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Navigation Header (Acadia Header-2) -->
  <header class="header-area p-relative tp-header-area">
    <div id="header-sticky" class="tp_el_header tp-header-2">
      <div class="container custom-container-larg">
        <div class="row align-items-center">
          
          <!-- School Logo & Branding -->
          <div class="col-xxl-3 col-xl-2 col-lg-6 col-8 col-sm-8">
            <div class="tp-header-inner-logo tp-el-logo">
              <a href="<?= url('/') ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="<?= asset_url('images/new-mgm-logo.png') ?>" alt="<?= e(get_setting('school_name', 'MGM Model School')) ?>" class="header-logo-img">
                <div class="brand-text-block d-none d-sm-flex flex-column text-start">
                  <span class="brand-title">MGM MODEL SCHOOL</span>
                  <span class="brand-sub">AYIROOR, VARKALA &bull; ESTD 1983</span>
                </div>
              </a>
            </div>
          </div>

          <!-- Navigation Menus -->
          <div class="col-xxl-7 col-xl-8 d-none d-xl-block">
            <div class="main-menu text-xl-center">
              <nav class="tp-main-menu-content">
                <ul class="tp-nav-menu">
                  <?php foreach ($navTree as $nav): 
                    $hasChildren = !empty($nav['children']);
                    $isActive = ($nav['url'] === '/' && empty($currentSlug)) || 
                                (!empty($currentSlug) && strpos($nav['url'], '/' . $currentSlug . '/') !== false);
                  ?>
                    <li class="<?= $hasChildren ? 'has-dropdown' : '' ?> <?= $isActive ? 'active' : '' ?>">
                      <a href="<?= e(url($nav['url'])) ?>" <?= $hasChildren ? 'onclick="return false;"' : '' ?> class="nav-links">
                        <?= e($nav['label']) ?>
                        <?php if ($hasChildren): ?>
                          <i class="fa-solid fa-chevron-down ms-1" style="font-size: 10px;"></i>
                        <?php endif; ?>
                      </a>

                      <?php if ($hasChildren): ?>
                        <ul class="dropdown-menu-custom <?= count($nav['children']) > 8 ? 'dropdown-mega' : '' ?>">
                          <?php foreach ($nav['children'] as $child): 
                            $childActive = !empty($currentSlug) && strpos($child['url'], '/' . $currentSlug . '/') !== false;
                          ?>
                            <li class="<?= $childActive ? 'active' : '' ?>">
                              <a href="<?= e(url($child['url'])) ?>">
                                <?= e($child['label']) ?>
                              </a>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </nav>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="col-xxl-2 col-xl-2 col-lg-6 col-4 col-sm-4">
            <div class="tp-header-2-contact d-flex align-items-center justify-content-end gap-3">
              
              <div class="tp-header-inner-btn home-2 d-none d-xxl-block">
                <a href="<?= url('/admission-procedure/') ?>" class="tp-btn-inner tp-el-btn2 tp-el-btn">
                  Apply Now
                </a>
              </div>

              <div class="offcanvas-btn d-xl-none">
                <button class="offcanvas-open-btn" aria-label="Toggle Navigation">
                  <i class="fa-solid fa-bars"></i>
                </button>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </header>

  <?php require_once __DIR__ . '/offcanvas.php'; ?>
