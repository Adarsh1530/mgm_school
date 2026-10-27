with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

idx = text.find('Focusing on high education')
start = max(0, idx - 500)
end = min(len(text), idx + 2500)
print(text[start:end])
