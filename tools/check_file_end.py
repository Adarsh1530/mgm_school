with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

print("Last 400 chars of entire file:")
print(text[-400:])
