import os
from highlights_data import HIGHLIGHTS_DATA

found_explore = 0
found_witness = 0

for h in HIGHLIGHTS_DATA:
    html_file = h['slug'] + '.html'
    if os.path.exists(html_file):
        with open(html_file, 'r', encoding='utf-8') as f:
            c = f.read()
        if 'Explore Other Highlights' in c:
            print(f"FOUND explore in {html_file}")
            found_explore += 1
        if 'Witness ' in c and 'in Person' in c:
            print(f"FOUND witness in {html_file}")
            found_witness += 1

print(f"Verification: found_explore={found_explore}, found_witness={found_witness}")
assert found_explore == 0, "Explore Other Highlights still exists"
assert found_witness == 0, "Witness CTA still exists"
print("SUCCESS: Both sections completely removed from all 21 highlights!")
