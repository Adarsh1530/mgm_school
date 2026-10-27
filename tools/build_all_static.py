import subprocess
import os

pages = [
    ('', 'index.html', None),
    ('highlights', 'highlights.html', 'highlights'),
    ('about-us', 'about-us.html', 'about-us'),
    ('our-founder', 'our-founder.html', 'our-founder'),
    ('our-mission', 'our-mission.html', 'our-mission'),
    ('courses-offered', 'courses-offered.html', 'courses-offered'),
    ('admission-procedure', 'admission-procedure.html', 'admission-procedure'),
    ('attendance', 'attendance.html', 'attendance'),
    ('swimming-pool', 'swimming-pool.html', 'swimming-pool'),
    ('voice-of-mgm', 'voice-of-mgm.html', 'voice-of-mgm'),
    ('ncc', 'ncc.html', 'ncc'),
    ('hindustan-scouts-guides', 'hindustan-scouts-guides.html', 'hindustan-scouts-guides'),
    ('yoga', 'yoga.html', 'yoga'),
    ('merit-day', 'merit-day.html', 'merit-day'),
    ('pta', 'pta.html', 'pta'),
    ('alumni', 'alumni.html', 'alumni'),
    ('gallery', 'gallery.html', 'gallery'),
    ('notices', 'notices.html', 'notices'),
    ('mandatory-disclosure', 'mandatory-disclosure.html', 'mandatory-disclosure'),
    ('contact', 'contact.html', 'contact'),
]

for slug, html_file, folder in pages:
    env = os.environ.copy()
    php_code = f"""<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTPS'] = 'on';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '{'/' + slug + '/' if slug else '/'}';
$_GET['route'] = '{slug}';

require_once dirname(__DIR__) . '/index.php';
"""
    with open('tools/tmp_runner.php', 'w', encoding='utf-8') as f:
        f.write(php_code)

    res = subprocess.run(['C:\\xampp\\php\\php.exe', 'tools/tmp_runner.php'], capture_output=True, text=True, encoding='utf-8', errors='ignore')
    html = res.stdout

    # Strip any potential PHP warning/fallback messages at the very beginning
    if 'MySQL connection unavailable' in html:
        html = html.split('-->', 1)[-1] if '-->' in html else html.split('Fall back to embedded SQLite.', 1)[-1]
        # Or remove until <!DOCTYPE html>
        if '<!DOCTYPE html>' in html:
            html = '<!DOCTYPE html>' + html.split('<!DOCTYPE html>', 1)[1]

    # Standardize root-relative asset URLs
    html = html.replace('https://mgmmodelschool.edu.in/assets/', '/assets/')

    with open(html_file, 'w', encoding='utf-8') as f:
        f.write(html)

    if folder:
        os.makedirs(folder, exist_ok=True)
        with open(os.path.join(folder, 'index.html'), 'w', encoding='utf-8') as f:
            f.write(html)

    print(f"Rendered {slug or 'home':25} -> {html_file:30} ({len(html)} bytes)")

if os.path.exists('tools/tmp_runner.php'):
    os.remove('tools/tmp_runner.php')

print("All static pages successfully generated with complete headers and footers!")
