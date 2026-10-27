for sql_file in ['database.sql', 'database/database.sql']:
    with open(sql_file, 'r', encoding='utf-8') as f:
        c = f.read()

    replacements = {
        "'Swimming Pool', '/swimming-pool/'": "'Swimming Pool', '/highlights/#swimming-pool'",
        "'Voice of MGM', '/voice-of-mgm/'": "'Voice of MGM', '/highlights/#voice-of-mgm'",
        "'NCC', '/ncc/'": "'NCC', '/highlights/#ncc'",
        "'Hindustan Scouts and Guides', '/hindustan-scouts-guides/'": "'Hindustan Scouts and Guides', '/highlights/#hindustan-scouts-guides'"
    }

    for old, new in replacements.items():
        if old in c:
            c = c.replace(old, new)
            print(f"Replaced {old} in {sql_file}")
        else:
            print(f"Warning: {old} not found in {sql_file}")

    with open(sql_file, 'w', encoding='utf-8') as f:
        f.write(c)
    print(f"Wrote {sql_file}")
