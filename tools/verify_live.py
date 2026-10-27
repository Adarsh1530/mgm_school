import requests
import re
import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

r = requests.get('https://mgmmodelschool.edu.in/highlights/', verify=False, timeout=15)
print('Live /highlights/ HTTP Status:', r.status_code)
html = r.text
print('Live page length:', len(html))

cards = re.findall(r'<div class="highlight-card" id="([^"]+)">', html)
print(f"Live highlight cards ({len(cards)}):")
for i, c in enumerate(cards, 1):
    print(f"  {i:2d}. {c}")

# Check dropdown-mega in live page
print("\nLive has dropdown-mega:", "dropdown-mega" in html)

# Check Activities on live
act_match = re.search(r'Activities\s*<i[^>]*></i>\s*</a>\s*<ul class="dropdown-menu-custom[^"]*">\s*(.*?)\s*</ul>', html, re.DOTALL)
if act_match:
    act_links = [re.sub(r'\s+', ' ', t).strip() for t in re.findall(r'<a href="[^"]*">\s*([^<]+?)\s*</a>', act_match.group(1))]
    print(f"\nLive Activities items ({len(act_links)}):", act_links)

# Check Highlights on live
hl_match = re.search(r'Highlights\s*<i[^>]*></i>\s*</a>\s*<ul class="dropdown-menu-custom[^"]*">\s*(.*?)\s*</ul>', html, re.DOTALL)
if hl_match:
    hl_links = [re.sub(r'\s+', ' ', t).strip() for t in re.findall(r'<a href="[^"]*">\s*([^<]+?)\s*</a>', hl_match.group(1))]
    print(f"\nLive Highlights dropdown items ({len(hl_links)}):", hl_links)

# Check zero duplicates
intersection = set(act_links).intersection(set(hl_links))
print("\nDuplicates between Highlights and Activities on Live:", intersection if intersection else "NONE (Zero Duplicates!)")
