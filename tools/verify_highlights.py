import re

with open('highlights.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Check highlight cards
cards = re.findall(r'<div class="highlight-card" id="([^"]+)">', html)
print(f"Total highlight cards in highlights.html: {len(cards)}")
for i, card_id in enumerate(cards, 1):
    print(f"  {i:2d}. {card_id}")

# Check dropdown-mega
print("\nHas dropdown-mega class in header nav:", "dropdown-mega" in html)

# Check Activities dropdown
act_match = re.search(r'Activities\s*<i[^>]*></i>\s*</a>\s*<ul class="dropdown-menu-custom[^"]*">\s*(.*?)\s*</ul>', html, re.DOTALL)
if act_match:
    act_links = [re.sub(r'\s+', ' ', t).strip() for t in re.findall(r'<a href="[^"]*">\s*([^<]+?)\s*</a>', act_match.group(1))]
    print(f"\nActivities items ({len(act_links)}):", act_links)

# Check Highlights dropdown
hl_match = re.search(r'Highlights\s*<i[^>]*></i>\s*</a>\s*<ul class="dropdown-menu-custom[^"]*">\s*(.*?)\s*</ul>', html, re.DOTALL)
if hl_match:
    hl_links = [re.sub(r'\s+', ' ', t).strip() for t in re.findall(r'<a href="[^"]*">\s*([^<]+?)\s*</a>', hl_match.group(1))]
    print(f"\nHighlights dropdown items ({len(hl_links)}):", hl_links)

# Check for duplicates between Highlights and Activities
intersection = set(act_links).intersection(set(hl_links))
print("\nDuplicates between Highlights and Activities:", intersection if intersection else "NONE (Zero Duplicates!)")
