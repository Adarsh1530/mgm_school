with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Let's find all top-level containers (data-element_type="container" or e-parent) around this region
import re

matches = list(re.finditer(r'<div class="elementor-element elementor-element-([a-f0-9]+)[^"]*e-parent"', text))
print("Found e-parent containers:")
for m in matches:
    pos = m.start()
    data_id = m.group(1)
    # Check if inside range 20000 to 40000
    if 18000 <= pos <= 40000:
        snippet = text[pos:pos+300].replace('\n', ' ')
        print(f"Pos {pos}: data-id={data_id} -> {snippet[:120]}")
