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
                <h1 class="tp-breadcrumb__title white tpcore-el-page-title"><?= e($bTitle) ?></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
