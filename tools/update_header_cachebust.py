with open('templates/header.php', 'r', encoding='utf-8') as f:
    c = f.read()

target = "  <!-- Custom Refined Enhancements -->\n  <link rel=\"stylesheet\" href=\"<?= asset_url('css/custom.css') ?>\">"
repl = "  <!-- Custom Refined Enhancements -->\n  <link rel=\"stylesheet\" href=\"<?= asset_url('css/custom.css') ?>?v=20261027_ratio\">"

if target in c:
    c = c.replace(target, repl, 1)
    with open('templates/header.php', 'w', encoding='utf-8') as f:
        f.write(c)
    print("SUCCESS: Updated templates/header.php")
else:
    print("WARNING: Target not found in templates/header.php")
