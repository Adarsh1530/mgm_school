with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

p2 = text.find('<div class="elementor-element elementor-element-e1419c7')
print("500 chars before p2:")
print(text[p2-500:p2])

# Let's count tags inside text[p1:p2] with a stack to see which tag is unclosed
import re
p1 = text.find('<div class="elementor-element elementor-element-cf77d4b')
sub = text[p1:p2]
stack = []
tokens = list(re.finditer(r'<(/?)div\b[^>]*>', sub))
print(f"Total div tokens in sub: {len(tokens)}")
for t in tokens:
    tag = t.group(0)
    if tag.startswith('</div'):
        if stack:
            stack.pop()
        else:
            print(f"Extra closing div at pos {t.start()}")
    else:
        stack.append(t.start())

print(f"Unclosed divs remaining on stack: {len(stack)}")
for s in stack:
    print(f"  Unclosed tag at offset {s}: {sub[s:s+100]}")
