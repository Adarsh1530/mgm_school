import re

with open('index.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Find sub-menu under Highlights
start = text.find('Highlights')
sub = text[start:start+4000]

items = re.findall(r'<a\s+href="([^"]+)">\s*(?:<span>)?(Swimming Pool|20-20 Method of Teaching|NOVA AI Hub|Happiness Room|Poly House|Akshara Muttathe Krishi Thottam)', sub)
print("Found navigation items:")
for url, label in items:
    print(f"  {label:32} -> {url}")

# Also check on highlights.html
with open('highlights.html', 'r', encoding='utf-8') as f:
    h_text = f.read()

card_links = re.findall(r'<a\s+href="([^"]+)"\s+class="highlight-btn-action text-danger fw-bold"', h_text)
print(f"Total Full Page links on highlights.html: {len(card_links)}")
print(f"Sample card links: {card_links[:5]}")
