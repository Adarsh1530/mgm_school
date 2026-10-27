import re

with open('highlights.html', 'r', encoding='utf-8') as f:
    c = f.read()

# Find each card in highlightsGrid
grid_pos = c.find('id="highlightsGrid"')
grid_end = c.find('<!-- Interactive Detail Modal -->')
grid = c[grid_pos:grid_end]

cards = grid.split('class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white"')
print(f"Total cards found in grid: {len(cards)-1}")

for i, card in enumerate(cards[1:], 1):
    # Extract title
    title_m = re.search(r'<h3[^>]*>[\s\S]*?<span>(.*?)</span>', card)
    title = title_m.group(1) if title_m else f"Card #{i}"
    
    # Extract all hrefs in this card
    hrefs = re.findall(r'href="([^"]+)"', card)
    
    # Extract data-slug
    slug_m = re.search(r'data-slug="([^"]+)"', card)
    slug = slug_m.group(1) if slug_m else "N/A"
    
    print(f"#{i} [{slug}] {title}:")
    for h in hrefs:
        print(f"     -> {h}")
