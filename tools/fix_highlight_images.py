import os
import re

files_updated = []

# 1. Update the 17 dedicated highlight view files
view_files = [
    'views/twenty-twenty-method.php',
    'views/libraries-at-mgm.php',
    'views/poly-house.php',
    'views/krishi-thottam.php',
    'views/amma-school.php',
    'views/counselling-centre.php',
    'views/gdc.php',
    'views/life-skills.php',
    'views/voice-of-mgm.php',
    'views/school-canteen.php',
    'views/butterfly-garden.php',
    'views/3d-max-zone.php',
    'views/ominis.php',
    'views/ncc.php',
    'views/hindustan-scouts-guides.php',
    'views/school-band-troop.php',
    'views/happiness-room.php'
]

pattern = re.compile(
    r'<!-- Featured High-Resolution Showcase Image -->\s*'
    r'<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">\s*'
    r'<div class="position-relative"[^>]*>\s*'
    r'<img src="([^"]+)" alt="([^"]*)"[^>]*>\s*'
    r'<div class="position-absolute[^"]*"[^>]*>[\s\S]*?</div>\s*'
    r'</div>\s*'
    r'</div>'
)

for vf in view_files:
    if not os.path.exists(vf):
        print(f"File not found: {vf}")
        continue
    with open(vf, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    m = pattern.search(content)
    if m:
        img_src = m.group(1)
        img_alt = m.group(2)
        new_block = f'''    <!-- Showcase Image (Exact Natural Ratio, No Cropping Frame) -->
    <div class="mb-5 text-center">
      <img src="{img_src}" 
           alt="{img_alt}" 
           class="img-fluid rounded-4 shadow-sm" 
           style="max-width: 100%; height: auto; max-height: 640px; object-fit: contain; display: inline-block;">
    </div>'''
        new_content = pattern.sub(new_block, content, count=1)
        with open(vf, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"PASS: Updated {vf}")
        files_updated.append(vf)
    else:
        print(f"WARNING: Pattern did not match in {vf}")

# 2. Update views/highlights.php (Card grid thumbnails & modal)
hl_file = 'views/highlights.php'
with open(hl_file, 'r', encoding='utf-8', errors='ignore') as f:
    hl_content = f.read()

# Update card thumbnail container and img
old_card_thumb = '''            <!-- Thumbnail & Badges -->
            <div class="position-relative" style="height: 220px; overflow: hidden;">
              <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="d-block w-100 h-100">
                <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                     alt="<?= e($h['title']) ?>" 
                     class="w-100 h-100" 
                     style="object-fit: cover; transition: transform 0.4s ease;"
                     loading="lazy">
              </a>'''

new_card_thumb = '''            <!-- Thumbnail & Badges (Exact Natural Ratio, No Forced Crop) -->
            <div class="position-relative" style="height: 240px; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden;">
              <a href="<?= rtrim(BASE_URL, '/') ?>/<?= e($h['id']) ?>/" class="d-flex align-items-center justify-content-center w-100 h-100 p-2">
                <img src="<?= asset_url(ltrim($h['image'], 'assets/')) ?>" 
                     alt="<?= e($h['title']) ?>" 
                     style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain; transition: transform 0.4s ease;"
                     loading="lazy">
              </a>'''

if old_card_thumb in hl_content:
    hl_content = hl_content.replace(old_card_thumb, new_card_thumb, 1)
    print("PASS: Updated card thumbnails in views/highlights.php")
else:
    print("WARNING: old_card_thumb not found in views/highlights.php")

# Update modal image container and img
old_modal_img = '''          <div class="col-md-5">
            <div class="rounded-3 overflow-hidden shadow-sm" style="height: 240px;">
              <img id="highlightModalImage" src="" alt="Highlight" class="w-100 h-100" style="object-fit: cover;">
            </div>
          </div>'''

new_modal_img = '''          <div class="col-md-5">
            <div class="rounded-3 overflow-hidden shadow-sm p-2" style="height: 240px; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
              <img id="highlightModalImage" src="" alt="Highlight" style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain;">
            </div>
          </div>'''

if old_modal_img in hl_content:
    hl_content = hl_content.replace(old_modal_img, new_modal_img, 1)
    print("PASS: Updated modal image in views/highlights.php")
else:
    print("WARNING: old_modal_img not found in views/highlights.php")

with open(hl_file, 'w', encoding='utf-8') as f:
    f.write(hl_content)

print(f"\nDone! Updated {len(files_updated)} view files + views/highlights.php")
