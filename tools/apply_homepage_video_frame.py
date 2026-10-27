import os
import re
import sqlite3

def make_video_frame(video_url, poster_url, badge_title):
    return f'''    <!-- Featured Video Frame (Exact Homepage Video Frame) -->
    <div class="mb-5">
      <div class="mgm-video-container" data-video-wrapper>
        <video class="mgm-autoplay-video" playsinline webkit-playsinline muted loop preload="none" poster="{poster_url}">
          <source src="{video_url}" type="video/mp4">
          Your browser does not support HTML5 video.
        </video>
        <div class="mgm-video-controls-overlay">
          <div class="mgm-video-btn-group">
            <button type="button" class="mgm-video-ctrl-btn mgm-btn-mute" aria-label="Unmute Video">
              <i class="fa-solid fa-volume-xmark"></i> <span class="mgm-btn-label">Unmute</span>
            </button>
          </div>
          <div class="mgm-video-badge">
            <span class="mgm-video-badge-dot"></span>
            <span>{badge_title}</span>
          </div>
        </div>
      </div>
    </div>'''

views_config = [
    {
        'file': 'views/nova-ai-hub.php',
        'video_url': "<?= rtrim(BASE_URL, '/') ?>/assets/videos/nova-ai-hub.mp4",
        'poster_url': "<?= rtrim(BASE_URL, '/') ?>/assets/images/1756461341.jpg",
        'badge_title': 'NOVA AI HUB TOUR'
    },
    {
        'file': 'views/innovation-centre.php',
        'video_url': "<?= rtrim(BASE_URL, '/') ?>/assets/videos/innovation-centre.mp4",
        'poster_url': "<?= rtrim(BASE_URL, '/') ?>/assets/images/omnis-robot.jpeg",
        'badge_title': 'INNOVATION CENTRE TOUR'
    },
    {
        'file': 'views/swimming-pool.php',
        'video_url': "<?= rtrim(BASE_URL, '/') ?>/assets/videos/swimming-pool.mp4",
        'poster_url': "<?= rtrim(BASE_URL, '/') ?>/assets/images/swimming-pool-facility-1.jpeg",
        'badge_title': 'SWIMMING POOL TOUR'
    },
    {
        'file': 'views/vriksha-chikitsa.php',
        'video_url': "<?= rtrim(BASE_URL, '/') ?>/assets/videos/vriksha-chikitsa.mp4",
        'poster_url': "<?= rtrim(BASE_URL, '/') ?>/assets/images/polyhouse-garden.jpeg",
        'badge_title': 'VRIKSHA CHIKITSA PROJECT'
    }
]

for cfg in views_config:
    path = cfg['file']
    with open(path, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    # Pattern to match the old card video container
    pattern = r'<!-- Featured Video Section -->\s*<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark">[\s\S]*?</div>\s*</div>'
    replacement = make_video_frame(cfg['video_url'], cfg['poster_url'], cfg['badge_title'])

    new_content, count = re.subn(pattern, replacement, content)
    if count == 0:
        # Fallback search if comments slightly differ
        pattern2 = r'<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark">\s*<div class="p-3 bg-dark border-bottom[\s\S]*?</div>\s*</div>'
        new_content, count = re.subn(pattern2, replacement, content)
    
    print(f"{path}: Replaced {count} video block(s)")
    with open(path, 'w', encoding='utf-8') as f:
        f.write(new_content)

# Update database for about-us
conn = sqlite3.connect('database/mgm_school.sqlite')
cursor = conn.cursor()

# Check about-us
cursor.execute('SELECT content_html FROM pages WHERE slug = "about-us"')
row = cursor.fetchone()
if row:
    html = row[0]
    # Replace the video controls overlay in about-us to match exact homepage frame
    old_overlay_pattern = r'<div class="mgm-video-controls-overlay">\s*<div class="mgm-video-btn-group">\s*<button type="button" class="mgm-video-ctrl-btn mgm-btn-play"[\s\S]*?</div>\s*<div class="mgm-video-badge">'
    new_overlay = '''<div class="mgm-video-controls-overlay">
              <div class="mgm-video-btn-group">
                <button type="button" class="mgm-video-ctrl-btn mgm-btn-mute" aria-label="Unmute Video">
                  <i class="fa-solid fa-volume-xmark"></i> <span class="mgm-btn-label">Unmute</span>
                </button>
              </div>
              <div class="mgm-video-badge">'''
    new_html = re.sub(old_overlay_pattern, new_overlay, html)
    new_html = new_html.replace('<span>Vriksha Chikitsa Project</span>', '<span>VRIKSHA CHIKITSA PROJECT</span>')
    if new_html != html:
        cursor.execute('UPDATE pages SET content_html = ? WHERE slug = "about-us"', (new_html,))
        conn.commit()
        print("Updated about-us in database")

# Also update swimming-pool in pages table if it had mgm-btn-play
cursor.execute('SELECT content_html FROM pages WHERE slug = "swimming-pool"')
row2 = cursor.fetchone()
if row2 and row2[0] and 'mgm-btn-play' in row2[0]:
    html2 = row2[0]
    new_html2 = re.sub(r'<button type="button" class="mgm-video-ctrl-btn mgm-btn-play"[\s\S]*?</button>', '', html2)
    cursor.execute('UPDATE pages SET content_html = ? WHERE slug = "swimming-pool"', (new_html2,))
    conn.commit()
    print("Updated swimming-pool in database")

conn.close()
print("Done applying video frames to views and database.")
