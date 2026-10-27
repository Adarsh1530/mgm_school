import urllib.request
import ssl
import re

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

urls = [
    ('Home', 'https://mgmmodelschool.edu.in/'),
    ('NOVA AI Hub', 'https://mgmmodelschool.edu.in/nova-ai-hub/'),
    ('Innovation Centre', 'https://mgmmodelschool.edu.in/innovation-centre/'),
    ('Swimming Pool', 'https://mgmmodelschool.edu.in/swimming-pool/'),
    ('Vriksha Chikitsa', 'https://mgmmodelschool.edu.in/vriksha-chikitsa/'),
    ('About Us', 'https://mgmmodelschool.edu.in/about-us/'),
]

print("=== VERIFYING LIVE PRODUCTION VIDEO FRAMES ===")
all_ok = True

for name, url in urls:
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req, context=ctx) as resp:
            html = resp.read().decode('utf-8', errors='ignore')
            status = resp.status
            has_container = 'mgm-video-container' in html
            has_autoplay_class = 'mgm-autoplay-video' in html
            has_overlay = 'mgm-video-controls-overlay' in html
            has_mute = 'mgm-btn-mute' in html
            has_badge = 'mgm-video-badge' in html
            has_dot = 'mgm-video-badge-dot' in html
            has_old_card = 'class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark"' in html

            ok = (status == 200 and has_container and has_autoplay_class and has_overlay and has_mute and has_badge and has_dot and not has_old_card)
            if ok:
                # Find badge text
                m = re.search(r'<div class="mgm-video-badge">\s*<span class="mgm-video-badge-dot"></span>\s*<span>(.*?)</span>', html)
                badge_text = m.group(1) if m else 'N/A'
                print(f"[PASS] {name} ({status}): Badge='{badge_text}', Container=OK, Overlay=OK, MuteBtn=OK")
            else:
                all_ok = False
                print(f"[FAIL] {name} ({status}): container={has_container}, autoplayClass={has_autoplay_class}, overlay={has_overlay}, mute={has_mute}, badge={has_badge}, oldCard={has_old_card}")
    except Exception as e:
        all_ok = False
        print(f"[ERROR] {name}: {e}")

print("---")
print("ALL LIVE PRODUCTION SITES VERIFIED?", all_ok)
