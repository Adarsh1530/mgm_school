import os
import re

html_files = [f for f in os.listdir('.') if f.endswith('.html') and os.path.isfile(f)]
print(f"Scanning {len(html_files)} HTML files for bugs and broken assets...")

broken_images = []
broken_links = []

for hf in sorted(html_files):
    with open(hf, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    # Find images
    imgs = re.findall(r'<img[^>]+src=["\']([^"\']+)["\']', content)
    for img in imgs:
        if img.startswith('data:') or img.startswith('http://') or img.startswith('https://'):
            continue
        clean_path = img.lstrip('/').split('?')[0].split('#')[0]
        if clean_path and not os.path.exists(clean_path):
            broken_images.append((hf, img))

    # Find internal page links
    links = re.findall(r'<a[^>]+href=["\']([^"\']+)["\']', content)
    for link in links:
        if link.startswith('#') or link.startswith('tel:') or link.startswith('mailto:') or link.startswith('javascript:'):
            continue
        if link.startswith('http://') or link.startswith('https://'):
            if 'mgmmodelschool.edu.in' in link:
                path = link.split('mgmmodelschool.edu.in')[-1].strip('/').split('#')[0]
                if path and not os.path.exists(path + '.html') and not os.path.exists(path + '/index.html') and not os.path.exists(path):
                    broken_links.append((hf, link))
        elif not link.startswith('assets/'):
            path = link.strip('/').split('#')[0]
            if path and not os.path.exists(path + '.html') and not os.path.exists(path + '/index.html') and not os.path.exists(path):
                broken_links.append((hf, link))

print(f"\nBroken image references: {len(broken_images)}")
for hf, img in broken_images[:10]:
    print(f"  {hf} -> {img}")

print(f"\nBroken internal links: {len(broken_links)}")
for hf, link in broken_links[:10]:
    print(f"  {hf} -> {link}")
