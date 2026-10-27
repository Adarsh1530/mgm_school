import subprocess

with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    orig = f.read()

p1 = orig.find('<div class="elementor-element elementor-element-cf77d4b')
p2 = orig.find('<div class="elementor-element elementor-element-e1419c7')

modified = orig[:p1] + orig[p2:]

with open('views/homepage_clean_extracted.html', 'w', encoding='utf-8') as f:
    f.write(modified)

# Also update audit/homepage_clean_extracted.html
with open('audit/homepage_clean_extracted.html', 'w', encoding='utf-8') as f:
    f.write(modified)

print(f"Removed {p2 - p1} chars from homepage_clean_extracted.html")

# Render home via php
php_code = """<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTPS'] = 'on';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '/';
$_GET['route'] = '';
require_once 'index.php';
"""
with open('tools/tmp_runner.php', 'w', encoding='utf-8') as f:
    f.write(php_code)

res = subprocess.run(['C:\\xampp\\php\\php.exe', 'tools/tmp_runner.php'], capture_output=True, text=True, encoding='utf-8', errors='ignore')
html = res.stdout

if '<!DOCTYPE html>' in html:
    html = '<!DOCTYPE html>' + html.split('<!DOCTYPE html>', 1)[1]
html = html.replace('https://mgmmodelschool.edu.in/assets/', '/assets/')

with open('index.html', 'w', encoding='utf-8') as f:
    f.write(html)

print(f"Successfully generated new index.html ({len(html)} bytes)")

# Check if phrases are gone from index.html
print("Contains 'Our Courses':", 'Our Courses' in html)
print("Contains 'functionality is inside':", 'functionality is inside' in html)
print("Contains 'Transpotation':", 'Transpotation' in html)
print("Contains 'Prayer Hall':", 'Prayer Hall' in html)
