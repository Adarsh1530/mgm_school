with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

p1 = text.find('<div class="elementor-element elementor-element-cf77d4b')
p_0c = text.find('<div class="elementor-element elementor-element-0c3ddc4')
p2 = text.find('<div class="elementor-element elementor-element-e1419c7')

sub1 = text[p1:p_0c]
import re
def count_divs(s):
    opens = s.count('<div')
    closes = s.count('</div>')
    return opens, closes, opens - closes

print("cf77d4b to 0c3ddc4 div count:", count_divs(sub1))
sub2 = text[p_0c:p2]
print("0c3ddc4 to e1419c7 div count:", count_divs(sub2))
