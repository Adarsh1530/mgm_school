import requests
import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

r = requests.get('https://mgmmodelschool.edu.in/', verify=False, timeout=15)
print('Live Homepage Status:', r.status_code)
html = r.text

checks = [
    'Recent & Upcoming',
    'Global Educations Fall Meeting',
    'Acadia Global Students Education Art Contest',
    'Higher student success educational workshops',
    '810665c'
]

for chk in checks:
    print(f"'{chk}' in live homepage: {chk in html}")

surviving = [
    'tp-hero-area',
    'elementor-element-e388438',
    'elementor-element-0b8ea50',
    'elementor-element-0c3ddc4',
    'elementor-element-e1419c7'
]
for s in surviving:
    print(f"Surviving section '{s}': {s in html}")
