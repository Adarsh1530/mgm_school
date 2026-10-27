with open('index.html', 'r', encoding='utf-8') as f:
    content = f.read()

checks = [
    'Recent & Upcoming',
    'Global Educations Fall Meeting',
    'Acadia Global Students Education Art Contest',
    'Higher student success educational workshops',
    '810665c'
]

for chk in checks:
    print(f"'{chk}' in index.html: {chk in content}")

surviving = [
    'tp-hero-area',
    'elementor-element-e388438',
    'elementor-element-0b8ea50',
    'elementor-element-0c3ddc4',
    'elementor-element-e1419c7'
]
for s in surviving:
    print(f"Surviving section '{s}': {s in content}")
