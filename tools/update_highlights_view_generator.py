import re

with open('tools/generate_highlights_view.py', 'r', encoding='utf-8') as f:
    code = f.read()

# Replace url: '#...' with url: '/<id>/'
def fix_url(match):
    h_id = match.group(1)
    return f"'url': '/{h_id}/',\n        'has_dedicated_page': True"

code = re.sub(r"'url':\s*'#([^']+)',\s*'has_dedicated_page':\s*False", fix_url, code)
code = code.replace("'has_dedicated_page': False", "'has_dedicated_page': True")

# Also ensure in card template that clicking title links to dedicated page
old_title_snippet = """              <h3 class="highlight-card-title">
                <i class="<?= e($h['icon']) ?>"></i>
                <span><?= e($h['title']) ?></span>
              </h3>"""

new_title_snippet = """              <h3 class="highlight-card-title">
                <i class="<?= e($h['icon']) ?>"></i>
                <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="text-dark text-decoration-none hover-danger">
                  <span><?= e($h['title']) ?></span>
                </a>
              </h3>"""

if old_title_snippet in code:
    code = code.replace(old_title_snippet, new_title_snippet)
    print("Updated card title to link to dedicated page")

# In thumbnail wrap, wrap img with link to full page
old_thumb_snippet = """              <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                   alt="<?= e($h['title']) ?>" 
                   class="highlight-thumb-img" 
                   loading="lazy">"""

new_thumb_snippet = """              <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="d-block w-100 h-100">
                <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                     alt="<?= e($h['title']) ?>" 
                     class="highlight-thumb-img" 
                     loading="lazy">
              </a>"""

if old_thumb_snippet in code:
    code = code.replace(old_thumb_snippet, new_thumb_snippet)
    print("Updated thumbnail to link to dedicated page")

# Ensure all 21 items have dedicated Full Page button
old_actions = """                <?php if ($h['has_dedicated_page']): ?>
                  <a href="<?= e(url($h['url'])) ?>" class="highlight-btn-action text-danger fw-bold" title="View Dedicated Page">
                    Full Page <i class="fa-solid fa-arrow-right ms-1"></i>
                  </a>
                <?php else: ?>
                  <a href="#<?= e($h['id']) ?>" class="highlight-btn-action" title="Copy Direct Link to Highlight" onclick="navigator.clipboard.writeText(window.location.origin + window.location.pathname + '#<?= e($h['id']) ?>'); alert('Link copied to clipboard!'); return false;">
                    <i class="fa-solid fa-share-nodes"></i>
                  </a>
                <?php endif; ?>"""

new_actions = """                <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="highlight-btn-action text-danger fw-bold" title="View Dedicated Page">
                  Full Page <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>"""

if old_actions in code:
    code = code.replace(old_actions, new_actions)
    print("Updated action buttons to always show Full Page link")

with open('tools/generate_highlights_view.py', 'w', encoding='utf-8') as f:
    f.write(code)

print("Saved updated tools/generate_highlights_view.py")
