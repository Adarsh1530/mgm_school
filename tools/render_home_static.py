import subprocess

php_code = """<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'mgmmodelschool.edu.in';
$_SERVER['HTTPS'] = 'on';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_URI'] = '/';
$_GET['route'] = '';

require_once dirname(__DIR__) . '/index.php';
"""

with open('tools/tmp_home_runner.php', 'w', encoding='utf-8') as f:
    f.write(php_code)

res = subprocess.run(['C:\\xampp\\php\\php.exe', 'tools/tmp_home_runner.php'], capture_output=True, text=True, encoding='utf-8', errors='ignore')
html = res.stdout

if '<!DOCTYPE html>' in html:
    html = '<!DOCTYPE html>' + html.split('<!DOCTYPE html>', 1)[1]

html = html.replace('https://mgmmodelschool.edu.in/assets/', '/assets/')

with open('index.html', 'w', encoding='utf-8') as f:
    f.write(html)

print(f"Rendered index.html ({len(html)} bytes)")

import os
if os.path.exists('tools/tmp_home_runner.php'):
    os.remove('tools/tmp_home_runner.php')
