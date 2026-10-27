import sqlite3

conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()

print("--- TOP-LEVEL NAVIGATION ---")
cursor.execute("SELECT id, label, url, sort_order FROM navigation WHERE parent_id IS NULL OR parent_id = 0 ORDER BY sort_order")
for row in cursor.fetchall():
    print(row)
    # Check children
    cursor.execute("SELECT id, label, url, sort_order FROM navigation WHERE parent_id = ? ORDER BY sort_order", (row[0],))
    children = cursor.fetchall()
    for child in children:
        print("   ->", child)
