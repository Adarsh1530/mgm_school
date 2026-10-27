import re

with open('extracted_highlights_doc.txt', 'r', encoding='utf-8') as f:
    text = f.read()

# Split into clean paragraphs
paras = [p.strip() for p in text.split('\n\n') if p.strip()]

print(f"Total paragraphs: {len(paras)}")
for i, p in enumerate(paras):
    if p.isupper() or len(p) < 60 or '' in p or '-' in p:
        print(f"P{i}: {p[:80]}")
