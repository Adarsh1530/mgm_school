import os

phrases = ['Focusing on high education', 'Explore the most appropriate courses', 'most appropriate courses', 'high education with the best quality']
for root, dirs, files in os.walk('.'):
    if any(k in root for k in ['.git', 'node_modules']):
        continue
    for f in files:
        if f.endswith(('.php', '.html')):
            p = os.path.join(root, f)
            with open(p, 'r', encoding='utf-8', errors='ignore') as fp:
                c = fp.read()
            for ph in phrases:
                if ph in c:
                    print(f'Found "{ph}" in {p}')
