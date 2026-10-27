with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

# Container cf77d4b
p1 = 21536
p2 = 26851
p3 = 35737

print("--- Container cf77d4b (first 500 chars) ---")
print(text[p1:p1+500])

print("\n--- End of cf77d4b / Before 0c3ddc4 (last 300 chars before 0c3ddc4) ---")
print(text[p2-300:p2])

print("\n--- Container 0c3ddc4 (first 500 chars) ---")
print(text[p2:p2+500])

print("\n--- End of 0c3ddc4 / Before e1419c7 (last 300 chars before e1419c7) ---")
print(text[p3-300:p3])

print("\n--- Container e1419c7 (first 500 chars) ---")
print(text[p3:p3+500])
