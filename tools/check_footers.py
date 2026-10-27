import os
import re

bad_footer_pattern = 'DigitalEdenzIndia'
correct_footer = 'Designed & Developed by SparkIT Techno Solutions Pvt. Ltd.'

bad_files = []
good_files = []

for r, d, fs in os.walk('.'):
    if any(x in r for x in ['.git', 'node_modules']):
        continue
    for f in fs:
        if f.endswith(('.html', '.php')):
            path = os.path.join(r, f)
            with open(path, 'r', encoding='utf-8', errors='ignore') as fp:
                c = fp.read()
                if bad_footer_pattern in c:
                    bad_files.append(path)
                if correct_footer in c:
                    good_files.append(path)

print(f"Files with old 'DigitalEdenzIndia' footer: {len(bad_files)}")
for f in bad_files:
    print("  BAD:", f)

print(f"\nFiles with correct SparkIT footer: {len(good_files)}")
