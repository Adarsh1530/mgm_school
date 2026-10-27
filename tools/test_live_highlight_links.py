import urllib.request
import ssl
import re

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

url = 'https://mgmmodelschool.edu.in/highlights/'
req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})

with urllib.request.urlopen(req, context=ctx) as resp:
    html = resp.read().decode('utf-8', errors='ignore')

print(f"Fetched {url} - Status: {resp.status}")

# Find all hrefs inside highlightsGrid
grid_pos = html.find('id="highlightsGrid"')
if grid_pos != -1:
    grid_html = html[grid_pos:html.find('</div>\n\n  </div>', grid_pos)]
else:
    grid_html = html

links = set(re.findall(r'href="([^"]+)"', grid_html))
print(f"Found {len(links)} unique links in highlightsGrid:\n")

for l in sorted(links):
    full_url = l
    if not full_url.startswith('http'):
        if full_url.startswith('/'):
            full_url = 'https://mgmmodelschool.edu.in' + full_url
        else:
            full_url = 'https://mgmmodelschool.edu.in/' + full_url
    
    try:
        r = urllib.request.Request(full_url, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(r, context=ctx) as sub_resp:
            print(f"[{sub_resp.status}] {l} -> {sub_resp.url}")
    except Exception as e:
        print(f"[FAIL] {l} -> {e}")
