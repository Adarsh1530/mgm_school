extra_css = """
/* ==========================================================================
   3-Card Balanced Hero Showcase (Only 3 cards, 4th fees structure removed)
   ========================================================================== */
@media (min-width: 992px) {
  .elementor-1119 .elementor-element.elementor-element-1b15f19,
  .elementor-1119 .elementor-element.elementor-element-bf75f68,
  .elementor-1119 .elementor-element.elementor-element-d7aa9db {
    --width: 33.333% !important;
    width: 33.333% !important;
    max-width: 33.333% !important;
    flex: 0 0 33.333% !important;
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  .elementor-1119 .elementor-element.elementor-element-1b15f19,
  .elementor-1119 .elementor-element.elementor-element-bf75f68 {
    --width: 50% !important;
    width: 50% !important;
    flex: 0 0 50% !important;
  }
  .elementor-1119 .elementor-element.elementor-element-d7aa9db {
    --width: 100% !important;
    width: 100% !important;
    flex: 0 0 100% !important;
  }
}
@media (max-width: 767px) {
  .elementor-1119 .elementor-element.elementor-element-1b15f19,
  .elementor-1119 .elementor-element.elementor-element-bf75f68,
  .elementor-1119 .elementor-element.elementor-element-d7aa9db {
    --width: 100% !important;
    width: 100% !important;
    flex: 0 0 100% !important;
  }
}

/* ==========================================================================
   Highlight Active Target & Scrolling Enhancements
   ========================================================================== */
.highlight-card,
.highlight-card-col {
  scroll-margin-top: 110px;
}

.highlight-card.highlight-active-target {
  animation: highlightTargetPulse 2.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  border-color: var(--tp-theme-primary, #ab0c2f) !important;
}

@keyframes highlightTargetPulse {
  0% {
    box-shadow: 0 0 0 8px rgba(171, 12, 47, 0.5), 0 20px 35px rgba(171, 12, 47, 0.2);
    transform: translateY(-8px) scale(1.02);
  }
  40% {
    box-shadow: 0 0 0 14px rgba(171, 12, 47, 0.2), 0 20px 35px rgba(171, 12, 47, 0.15);
    transform: translateY(-8px) scale(1.02);
  }
  100% {
    box-shadow: 0 16px 30px rgba(0, 0, 0, 0.08);
    transform: translateY(0) scale(1);
  }
}
"""

with open('assets/css/custom.css', 'a', encoding='utf-8') as f:
    f.write('\n' + extra_css)
print('Successfully appended CSS to custom.css')
