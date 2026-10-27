import sqlite3

conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()
cursor.execute("SELECT slug, title, length(content_html) FROM pages WHERE slug IN ('', 'home')")
print(cursor.fetchall())
