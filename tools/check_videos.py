import os
import re

html_files = [f for f in os.listdir('.') if f.endswith('.html')]
for hf in sorted(html_files):
    with open(hf, 'r', encoding='utf-8') as f:
        c = f.read()
    videos = re.findall(r'<source[^>]+src="([^"]+)"', c)
    if videos:
        print(f"{hf}:")
        for v in videos:
            clean = v.replace('https://mgmmodelschool.edu.in/', '').lstrip('/')
            print(f"   video: {v} -> exists: {os.path.exists(clean)} ({os.path.getsize(clean) if os.path.exists(clean) else 'N/A'} bytes)")
