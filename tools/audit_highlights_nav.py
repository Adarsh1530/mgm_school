import json
import os

with open('views/highlights.php', 'r', encoding='utf-8') as f:
    c = f.read()

pos1 = c.find("json_decode(<<<'JSON'") + len("json_decode(<<<'JSON'")
pos2 = c.find("\nJSON", pos1)
data = json.loads(c[pos1:pos2].strip())

print(f"Total Highlights: {len(data)}\n")

all_ok = True
for item in data:
    hid = item['id']
    title = item['title']
    url = item.get('url', f"/{hid}/")
    
    # Check if view exists
    view_path = f"views/{hid}.php"
    view_exists = os.path.exists(view_path)
    
    # Check if root html exists
    html_path = f"{hid}.html"
    html_exists = os.path.exists(html_path)
    
    # Check if folder index.html exists
    folder_idx = f"{hid}/index.html"
    folder_idx_exists = os.path.exists(folder_idx)
    
    status = "OK" if (view_exists and html_exists and folder_idx_exists) else "FAIL"
    if status == "FAIL":
        all_ok = False
    print(f"[{status}] #{item['order']} {title}: id='{hid}' | view={view_exists} | html={html_exists} | folder={folder_idx_exists}")

print("\nALL 21 PAGES EXIST LOCALLY?", all_ok)
