import sqlite3

conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()
cursor.execute("PRAGMA table_info(pages)")
for col in cursor.fetchall():
    print(col)
cursor.execute("SELECT slug, title FROM pages")
for r in cursor.fetchall():
    print(r)
