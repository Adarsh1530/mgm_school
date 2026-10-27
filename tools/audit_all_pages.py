import subprocess
import glob
import os

print("=== 1. PHP SYNTAX LINTING ===")
php_files = glob.glob('**/*.php', recursive=True)
lint_errors = []
for pf in php_files:
    if 'node_modules' in pf or '.git' in pf or 'brain' in pf: continue
    res = subprocess.run(['C:\\xampp\\php\\php.exe', '-l', pf], capture_output=True, text=True)
    if 'No syntax errors detected' not in res.stdout:
        print(f"LINT ERROR in {pf}: {res.stdout.strip()} {res.stderr.strip()}")
        lint_errors.append(pf)

if not lint_errors:
    print(f"All {len(php_files)} PHP files have ZERO syntax errors!\n")

print("=== 2. LOCAL STATIC HTML AUDIT ===")
html_files = [f for f in glob.glob('*.html') if not any(x in f for x in ['node_modules', '.git', 'brain', 'audit'])]
for hf in sorted(html_files):
    size = os.path.getsize(hf)
    with open(hf, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()
    has_doctype = '<!DOCTYPE html>' in content
    has_footer = '</footer>' in content
    has_title = '<title>' in content
    if size < 1000 or not has_doctype or not has_footer:
        print(f"SUSPICIOUS HTML: {hf} (size: {size}, doctype:{has_doctype}, footer:{has_footer})")
    else:
        print(f"OK: {hf:30} ({size:6} bytes)")

print("\nHTML check complete.")
