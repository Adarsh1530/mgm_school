<?php
$html = file_get_contents('audit/homepage_clean_extracted.html');

// 1. Remove swiper-slide-duplicate divs entirely
$html = preg_replace('#<div[^>]*class="[^"]*swiper-slide-duplicate[^"]*"[^>]*>.*?</div>\s*</div>\s*</div>#is', '', $html);
// Cleaner regex for duplicate slides: match any div with swiper-slide-duplicate until its closing matching tag
// Let's use DOMDocument or regex with careful boundary
function cleanSwipers($html) {
    // Remove duplicate slides
    $html = preg_replace('#<div class="[^"]*swiper-slide-duplicate[^"]*"[^>]*>[\s\S]*?</div>\s*(?=<div class="swiper-slide|</div>\s*<span|</div>\s*<div class="tp-)#i', '', $html);
    
    // Remove swiper runtime classes from .swiper
    $html = preg_replace_callback('#class="([^"]*swiper[^"]*)"#i', function($m) {
        $cls = $m[1];
        $remove = ['swiper-initialized', 'swiper-horizontal', 'swiper-pointer-events', 'swiper-backface-hidden', 'swiper-watch-progress', 'swiper-fade'];
        foreach ($remove as $r) {
            $cls = str_replace($r, '', $cls);
        }
        $cls = preg_replace('/\s+/', ' ', trim($cls));
        return 'class="' . $cls . '"';
    }, $html);

    // Remove swiper runtime classes and inline styles from swiper-wrapper
    $html = preg_replace('#(<div class="swiper-wrapper"[^>]*)style="[^"]*"#i', '$1', $html);

    // Remove inline style from swiper-slide in hero
    $html = preg_replace('#(<div class="swiper-slide[^"]*"[^>]*)style="[^"]*"#i', '$1', $html);

    return $html;
}

$cleaned = cleanSwipers($html);
file_put_contents('audit/homepage_clean_extracted.html', $cleaned);
echo "Cleaned homepage_clean_extracted.html successfully!\n";
