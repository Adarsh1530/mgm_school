import os

files = [
    'views/homepage_clean_extracted.html',
    'audit/homepage_clean_extracted.html'
]

for path in files:
    if not os.path.exists(path):
        continue
    with open(path, 'r', encoding='utf-8') as f:
        c = f.read()

    # 1. Update Title: Scholarships & Fees -> Fees Structure
    # Check variations of whitespace in title
    old_title = 'Scholarships &amp;  <br> Fees'
    new_title = 'Fees <br> Structure'
    if old_title in c:
        c = c.replace(old_title, new_title)
        print(f"Replaced old_title in {path}")
    else:
        # Regex replacement if whitespace varies
        import re
        c = re.sub(r'Scholarships\s*&amp;\s*<br>\s*Fees', 'Fees <br> Structure', c)
        print(f"Regex replaced old_title in {path}")

    # 2. Update Link to mandatory-disclosure/ where Fee Structure is located
    # In Card 4 only:
    card4_old = '<h4 class="tp-service-title tp-el-title"><a href="courses-offered/">Fees <br> Structure</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="courses-offered/">'
    card4_new = '<h4 class="tp-service-title tp-el-title"><a href="mandatory-disclosure/">Fees <br> Structure</a></h4>\n                    <div class="tp-service-btn">\n                        <a class="tp-el-service-btn tp-el-service-btn" href="mandatory-disclosure/">'
    if card4_old in c:
        c = c.replace(card4_old, card4_new)
        print(f"Updated link to mandatory-disclosure/ in {path}")
    else:
        print(f"Note: card4_old exact block not matched, checking regex")
        # Try without newline sensitivity
        c = c.replace('<a href="courses-offered/">Fees <br> Structure</a>', '<a href="mandatory-disclosure/">Fees <br> Structure</a>')

    # 3. Update Description: remove 'and merit-based scholarships'
    old_desc = 'MGM Model School offers structured fee programs and merit-based scholarships, supporting students from diverse backgrounds, cultures, and nationalities.'
    new_desc = 'MGM Model School offers structured fee programs, supporting students from diverse backgrounds, cultures, and nationalities.'
    if old_desc in c:
        c = c.replace(old_desc, new_desc)
        print(f"Replaced old_desc in {path}")
    else:
        print(f"old_desc not found in {path}")

    with open(path, 'w', encoding='utf-8') as f:
        f.write(c)
    print(f"Saved {path}")
