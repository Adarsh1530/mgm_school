import re

# 1. Check index.html for 3 cards
with open('index.html', 'r', encoding='utf-8') as f:
    h = f.read()

print("--- CHECKING HOMEPAGE 3 CARDS ---")
cards = re.findall(r'<div class="tp-service-item.*?</p>\s*</div>\s*</div>', h, re.DOTALL)
print(f"Total service cards in index.html: {len(cards)}")
for i, c in enumerate(cards, 1):
    t = re.search(r'<h4 class="tp-service-title.*?>(.*?)</h4>', c, re.DOTALL)
    print(f"  Card {i}: {re.sub(r'<[^>]+>', ' ', t.group(1)).strip() if t else 'N/A'}")

print("Has 'Fees Structure' card:", 'Fees <br> Structure' in h or 'Fees Structure' in h)

# 2. Check highlights nav pointing in index.html and highlights.html
print("\n--- CHECKING HIGHLIGHTS NAVIGATION POINTING ---")
for file in ['index.html', 'highlights.html']:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    hl_match = re.search(r'Highlights\s*<i[^>]*></i>\s*</a>\s*<ul class="dropdown-menu-custom[^"]*">\s*(.*?)\s*</ul>', content, re.DOTALL)
    if hl_match:
        links = re.findall(r'<a href="([^"]*)">\s*([^<]+?)\s*</a>', hl_match.group(1))
        print(f"In {file}, Highlights dropdown items ({len(links)}):")
        for href, text in links[:5]:
            print(f"  {text.strip()} -> {href}")
        print(f"  ... ({len(links)-5} more)")
