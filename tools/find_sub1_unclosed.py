with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

p1 = text.find('<div class="elementor-element elementor-element-cf77d4b')
p_0c = text.find('<div class="elementor-element elementor-element-0c3ddc4')
sub1 = text[p1:p_0c]

import re
stack = []
tokens = list(re.finditer(r'<(/?)div\b[^>]*>', sub1))
for t in tokens:
    tag = t.group(0)
    if tag.startswith('</div'):
        if stack:
            stack.pop()
    else:
        stack.append((t.start(), tag[:60]))

for pos, tag in stack:
    print(f"Unclosed in sub1 at {pos}: {tag}")

print("\nLast 400 chars of sub1:")
print(sub1[-400:])
