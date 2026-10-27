import glob
import os
import re

print("=== RUNNING COMPREHENSIVE SITE AUDIT ===")

all_html_files = [f for f in glob.glob('*.html') if not any(x in f for x in ['node_modules', '.git', 'brain', 'audit'])]

missing_assets = []
broken_internal_links = []
encoding_glitches = []

for hf in sorted(all_html_files):
    with open(hf, 'r', encoding='utf-8', errors='ignore') as f:
        html = f.read()

    # 1. Check for encoding glitches (e.g. \ufffd)
    if '\ufffd' in html:
        count = html.count('\ufffd')
        encoding_glitches.append((hf, count))

    # 2. Check all image src
    img_srcs = re.findall(r'<img[^>]+src=[\'"]([^\'"]+)[\'"]', html)
    for src in img_srcs:
        if src.startswith('http') or src.startswith('data:'):
            continue
        clean_src = src.split('?')[0].lstrip('/')
        if not os.path.exists(clean_src):
            missing_assets.append((hf, 'img', src))

    # 3. Check video src and poster
    vid_srcs = re.findall(r'<source[^>]+src=[\'"]([^\'"]+)[\'"]', html)
    for src in vid_srcs:
        if src.startswith('http'): continue
        clean_src = src.split('?')[0].lstrip('/')
        if not os.path.exists(clean_src):
            missing_assets.append((hf, 'video', src))

    posters = re.findall(r'<video[^>]+poster=[\'"]([^\'"]+)[\'"]', html)
    for p in posters:
        if p.startswith('http'): continue
        clean_p = p.split('?')[0].lstrip('/')
        if not os.path.exists(clean_p):
            missing_assets.append((hf, 'poster', p))

    # 4. Check CSS and JS links
    css_links = re.findall(r'<link[^>]+href=[\'"]([^\'"]+\.css[^\'"]*)[\'"]', html)
    for css in css_links:
        if css.startswith('http') or css.startswith('//'): continue
        clean_css = css.split('?')[0].lstrip('/')
        if not os.path.exists(clean_css):
            missing_assets.append((hf, 'css', css))

    js_links = re.findall(r'<script[^>]+src=[\'"]([^\'"]+\.js[^\'"]*)[\'"]', html)
    for js in js_links:
        if js.startswith('http') or js.startswith('//'): continue
        clean_js = js.split('?')[0].lstrip('/')
        if not os.path.exists(clean_js):
            missing_assets.append((hf, 'js', js))

print(f"Checked {len(all_html_files)} HTML pages.")
print(f"Missing assets: {len(missing_assets)}")
for m in missing_assets:
    print(f"  {m[0]}: missing {m[1]} -> {m[2]}")

print(f"Encoding glitches (\\ufffd): {len(encoding_glitches)}")
for g in encoding_glitches:
    print(f"  {g[0]}: {g[1]} glitch(es)")

if not missing_assets and not encoding_glitches:
    print("\n>>> AUDIT PASSED 100%: 0 missing assets, 0 encoding glitches! <<<")
