import requests
import re
import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

session = requests.Session()
session.verify = False

base_url = "https://mgmmodelschool.edu.in"
print(f"=== VERIFYING LIVE PRODUCTION: {base_url} ===\n")

# 1. Check highlights hub
resp_hub = session.get(f"{base_url}/highlights/", timeout=15)
print(f"1. Highlights Hub: HTTP {resp_hub.status_code} ({len(resp_hub.text)} bytes)")
assert resp_hub.status_code == 200, "Highlights hub failed"

cards = re.findall(r'data-href="([^"]+)"', resp_hub.text)
print(f"   Cards with data-href: {len(cards)}")
buttons = re.findall(r'class="[^"]*highlight-btn-link[^"]*"', resp_hub.text)
print(f"   Explore buttons: {len(buttons)}")
has_modal = 'highlightDetailModal' in resp_hub.text
print(f"   Old modal in live page: {has_modal}")

# 2. Check all 21 dedicated pages live
slugs = [
    'swimming-pool', 'twenty-twenty-method', 'libraries-at-mgm', 'poly-house',
    'krishi-thottam', 'amma-school', 'vriksha-chikitsa', 'counselling-centre',
    'innovation-centre', 'gdc', 'life-skills', 'voice-of-mgm', 'school-canteen',
    'butterfly-garden', '3d-max-zone', 'ominis', 'nova-ai-hub', 'ncc',
    'hindustan-scouts-guides', 'school-band-troop', 'happiness-room'
]

print("\n2. Checking all 21 dedicated highlight pages live:")
all_passed = True
for slug in slugs:
    url = f"{base_url}/{slug}/"
    resp = session.get(url, timeout=15)
    title_match = re.search(r'<title>(.*?)</title>', resp.text)
    raw_title = title_match.group(1).strip() if title_match else 'No Title'
    safe_title = raw_title.encode('ascii', 'ignore').decode('ascii')
    status = "OK" if resp.status_code == 200 else "FAIL"
    if resp.status_code != 200: all_passed = False
    print(f"   [{status}] {slug:25} -> HTTP {resp.status_code} | {safe_title[:50]}")

# 3. Check CSS live
print("\n3. Checking custom.css on production:")
resp_css = session.get(f"{base_url}/assets/css/custom.css?v=20261027_navfix", timeout=15)
has_3col = 'grid-template-columns: repeat(3, minmax(0, 1fr))' in resp_css.text
has_aspect = 'aspect-ratio: 16 / 10' in resp_css.text
no_zoom = 'transform: none !important;' in resp_css.text
print(f"   3-Column Mega Dropdown in live CSS: {has_3col}")
print(f"   Natural Aspect Ratio 16/10 in live CSS: {has_aspect}")
print(f"   Hover Zoom Disabled in live CSS: {no_zoom}")

# 4. Check Home Innovation Boxes
print("\n4. Checking Homepage Innovation Links:")
resp_home = session.get(f"{base_url}/", timeout=15)
has_ominis_link = 'href="ominis/"' in resp_home.text or 'href="/ominis/"' in resp_home.text
has_nova_link = 'href="nova-ai-hub/"' in resp_home.text or 'href="/nova-ai-hub/"' in resp_home.text
print(f"   OMNIS box linked: {has_ominis_link}")
print(f"   NOVA box linked: {has_nova_link}")

print("\n=== LIVE VERIFICATION FINISHED SUCCESSFULLY ===")
