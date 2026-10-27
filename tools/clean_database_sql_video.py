import re

for path in ['database.sql', 'database/database.sql']:
    with open(path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Pattern to match the mgm-btn-play button in the overlay
    pattern = r'<button type=[\'"]button[\'"] class=[\'"]mgm-video-ctrl-btn mgm-btn-play[\'"][^>]*>[\s\S]*?</button>\s*'
    new_content, count = re.subn(pattern, '', content)
    print(f"{path}: Replaced {count} instances of mgm-btn-play")

    new_content = new_content.replace('<span>Vriksha Chikitsa Project</span>', '<span>VRIKSHA CHIKITSA PROJECT</span>')

    with open(path, 'w', encoding='utf-8') as f:
        f.write(new_content)

print("Done cleaning SQL dump files.")
