import sqlite3
from exact_docx_data import DOCX_HIGHLIGHTS

conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()

for slug, data in DOCX_HIGHLIGHTS.items():
    title = data['title']
    lead = data['paragraphs'][0] if data['paragraphs'] else title
    cursor.execute("UPDATE pages SET title = ?, meta_description = ?, is_published = 1 WHERE slug = ?", (title, lead, slug))
    print(f"Updated page in SQLite: {slug} -> {title}")

conn.commit()
conn.close()

# Also update database.sql and database/database.sql if needed
print("SQLite pages table synchronized with exact docx titles and leads!")
