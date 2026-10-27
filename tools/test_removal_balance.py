with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

p1 = text.find('<div class="elementor-element elementor-element-cf77d4b')
p2 = text.find('<div class="elementor-element elementor-element-e1419c7')

print(f"p1 (cf77d4b): {p1}")
print(f"p2 (e1419c7): {p2}")
print(f"Slice length to remove: {p2 - p1} characters")

print("\n--- 200 chars BEFORE removal ---")
print(text[p1-200:p1])

print("\n--- 200 chars AFTER removal ---")
print(text[p2:p2+200])

# Test div balance before and after
def check_div_balance(s):
    opens = s.count('<div')
    closes = s.count('</div>')
    return opens, closes, opens - closes

print("\nTotal before removal:", check_div_balance(text))
removed_slice = text[p1:p2]
print("Slice to remove div count:", check_div_balance(removed_slice))
after_text = text[:p1] + text[p2:]
print("Total after removal:", check_div_balance(after_text))
