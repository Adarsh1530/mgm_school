import sqlite3
from highlights_data import HIGHLIGHTS_DATA

# 1. Update SQLite
conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()

# Ensure all 21 are in pages table
for h in HIGHLIGHTS_DATA:
    slug = h['slug']
    title = h['title']
    lead = h['lead']
    cursor.execute("SELECT id FROM pages WHERE slug = ?", (slug,))
    row = cursor.fetchone()
    if row:
        cursor.execute("UPDATE pages SET title = ?, meta_description = ?, is_published = 1 WHERE slug = ?", (title, lead, slug))
    else:
        cursor.execute("""
            INSERT INTO pages (slug, title, hero_title, breadcrumb_title, content_html, meta_description, is_published, created_at, updated_at)
            VALUES (?, ?, ?, ?, '', ?, 1, datetime('now'), datetime('now'))
        """, (slug, title, title, title, lead))
    print(f"Ensured page in SQLite: {slug}")

# Update navigation URLs for Highlights children (parent_id = 23)
slug_map = {
    'Swimming Pool': '/swimming-pool/',
    '20-20 Method of Teaching': '/twenty-twenty-method/',
    'Libraries at MGM': '/libraries-at-mgm/',
    'Poly House': '/poly-house/',
    'Akshara Muttathe Krishi Thottam': '/krishi-thottam/',
    'Amma School': '/amma-school/',
    'Vriksha Chikitsa': '/vriksha-chikitsa/',
    'Counselling Centre': '/counselling-centre/',
    'Innovation Centre': '/innovation-centre/',
    'GDC': '/gdc/',
    'Life Skills': '/life-skills/',
    'Voice of MGM': '/voice-of-mgm/',
    'School Canteen': '/school-canteen/',
    'Butterfly Garden and Kids Zone': '/butterfly-garden/',
    '3D Max Zone': '/3d-max-zone/',
    'Ominis': '/ominis/',
    'NOVA AI Hub': '/nova-ai-hub/',
    'NCC': '/ncc/',
    'Hindustan Scouts and Guides': '/hindustan-scouts-guides/',
    'School Band Troop': '/school-band-troop/',
    'Happiness Room': '/happiness-room/'
}

for label, url in slug_map.items():
    cursor.execute("UPDATE navigation SET url = ? WHERE parent_id = 23 AND label = ?", (url, label))
    print(f"Updated navigation in SQLite: {label} -> {url}")

conn.commit()
conn.close()

# 2. Update SQL dumps (database.sql and database/database.sql)
for path in ['database.sql', 'database/database.sql']:
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    for label, url in slug_map.items():
        # Replace '/highlights/#<anchor>' with '<url>'
        anchor = url.strip('/')
        old_pattern = f"/highlights/#{anchor}"
        if old_pattern in content:
            content = content.replace(old_pattern, url)
            print(f"Replaced {old_pattern} with {url} in {path}")
        else:
            print(f"Note: {old_pattern} not in {path}")

    with open(path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Wrote updated {path}")

print("All database sync completed!")
