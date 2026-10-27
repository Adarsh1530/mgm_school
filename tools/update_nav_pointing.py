import sqlite3

conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()

# Get Highlights ID
cursor.execute("SELECT id FROM navigation WHERE label = 'Highlights' AND (parent_id IS NULL OR parent_id = 0)")
hl_row = cursor.fetchone()
if hl_row:
    hl_id = hl_row[0]
    print(f"Highlights parent_id = {hl_id}")

    mappings = {
        'Swimming Pool': '/highlights/#swimming-pool',
        'Voice of MGM': '/highlights/#voice-of-mgm',
        'NCC': '/highlights/#ncc',
        'Hindustan Scouts and Guides': '/highlights/#hindustan-scouts-guides'
    }

    for label, new_url in mappings.items():
        cursor.execute("UPDATE navigation SET url = ? WHERE parent_id = ? AND label = ?", (new_url, hl_id, label))
        print(f"Updated {label} to {new_url} (rows: {cursor.rowcount})")

    conn.commit()

# Verify all 21 items
cursor.execute("SELECT sort_order, label, url FROM navigation WHERE parent_id = ? ORDER BY sort_order", (hl_id,))
for r in cursor.fetchall():
    print(f"  #{r[0]:2d}: {r[1]:35} -> {r[2]}")

conn.close()
