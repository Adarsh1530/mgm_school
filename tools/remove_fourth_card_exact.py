import os

for path in ['views/homepage_clean_extracted.html', 'audit/homepage_clean_extracted.html']:
    if not os.path.exists(path):
        continue
    with open(path, 'r', encoding='utf-8') as f:
        lines = f.readlines()

    start_idx = None
    end_idx = None
    for i, l in enumerate(lines):
        if 'elementor-element-5a05849' in l:
            start_idx = i
        if start_idx is not None and i > start_idx:
            if 'elementor-element-29faa04' in l:
                end_idx = i - 2
                break

    if start_idx is not None and end_idx is not None:
        new_lines = lines[:start_idx] + lines[end_idx:]
        with open(path, 'w', encoding='utf-8') as f:
            f.writelines(new_lines)
        print(f"Removed 4th card from {path}: {len(lines)} lines -> {len(new_lines)} lines")
    else:
        print(f"Could not find card indices in {path}")
