with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    c = f.read()
import re
cards = re.findall(r'<div class="tp-service-item.*?</p>\s*</div>\s*</div>', c, re.DOTALL)
for i, card in enumerate(cards, 1):
    title = re.search(r'<h4 class="tp-service-title.*?>(.*?)</h4>', card, re.DOTALL)
    desc = re.search(r'<p class="tp-el-desc">\s*(.*?)\s*</p>', card, re.DOTALL)
    t = re.sub(r'<[^>]+>', ' ', title.group(1)).strip() if title else ''
    d = desc.group(1).strip() if desc else ''
    print(f"Card {i}: Title = '{t}'\n  Desc = '{d}'\n")
