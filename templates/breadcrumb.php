<?php
/**
 * Breadcrumb Component
 * MGM Model School Exact Elementor Recreation
 */
$bTitle = $breadcrumbTitle ?? ($pageTitle ?? 'MGM School');
?>
<div data-elementor-type="wp-post" data-elementor-id="6225" class="elementor elementor-6225" data-elementor-post-type="tp-breadcrumb">
  <div class="elementor-element elementor-element-07430dd e-con-full tp-default-breadcrumb e-flex e-con e-parent e-lazyloaded" data-id="07430dd" data-element_type="container" data-e-type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
    <div class="elementor-element elementor-element-7451032 e-flex e-con-boxed e-con e-child" data-id="7451032" data-element_type="container" data-e-type="container">
      <div class="e-con-inner">
        <div class="elementor-element elementor-element-acf44d6 elementor-widget elementor-widget-tp-breadcrumb" data-id="acf44d6" data-element_type="widget" data-e-type="widget" data-settings="{&quot;tp_acadia_breadcrumb_align&quot;:&quot;start&quot;}" data-widget_type="tp-breadcrumb.default">
          <div class="elementor-widget-container">
            <div class="default-breadcrumb">
              <div class="tp-breadcrumb__content tpcore-page-header">
                <div class="tp-breadcrumb__list">
                  <span class="tpcore-el-icon-color">
                    <a href="<?= url('/') ?>" aria-label="Home">
                      <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.07207 0C8.19331 0 8.31107 0.0404348 8.40664 0.114882L16.1539 6.14233L15.4847 6.98713L14.5385 6.25079V12.8994C14.538 13.1843 14.4243 13.4574 14.2225 13.6589C14.0206 13.8604 13.747 13.9738 13.4616 13.9743H2.69231C2.40688 13.9737 2.13329 13.8603 1.93146 13.6588C1.72962 13.4573 1.61597 13.1843 1.61539 12.8994V6.2459L0.669148 6.98235L0 6.1376L7.7375 0.114882C7.83308 0.0404348 7.95083 0 8.07207 0ZM8.07694 1.22084L2.69231 5.40777V12.8994H13.4616V5.41341L8.07694 1.22084Z" fill="currentColor"></path>
                      </svg>
                    </a>
                  </span>
                  <span class="color tpcore-el-breadcrumb-nav">
                    <?= e($bTitle) ?>
                  </span>
                </div>
                <h1 class="tp-breadcrumb__title white tpcore-el-page-title"><?= e($bTitle) ?></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
