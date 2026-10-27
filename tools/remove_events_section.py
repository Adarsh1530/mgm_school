import os

for path in ['views/homepage_clean_extracted.html', 'audit/homepage_clean_extracted.html']:
    if not os.path.exists(path):
        continue
    with open(path, 'r', encoding='utf-8') as f:
        text = f.read()

    start_marker = '<div class="elementor-element elementor-element-810665c e-con-full e-flex e-con e-parent" data-id="810665c"'
    end_marker = '<div class="elementor-element elementor-element-0c3ddc4 e-con-full e-flex e-con e-parent" data-id="0c3ddc4"'

    idx_start = text.find(start_marker)
    idx_end = text.find(end_marker)

    if idx_start != -1 and idx_end != -1:
        new_text = text[:idx_start] + text[idx_end:]
        with open(path, 'w', encoding='utf-8') as f:
            f.write(new_text)
        print(f"Successfully removed Recent & Upcoming Events from {path} ({len(text)} -> {len(new_text)} bytes)")
    else:
        print(f"Markers not found in {path}")
