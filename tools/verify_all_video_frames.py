import glob
import re

files_to_check = [
    'index.html',
    'views/home.php',
    'nova-ai-hub.html',
    'nova-ai-hub/index.html',
    'views/nova-ai-hub.php',
    'innovation-centre.html',
    'innovation-centre/index.html',
    'views/innovation-centre.php',
    'swimming-pool.html',
    'swimming-pool/index.html',
    'views/swimming-pool.php',
    'vriksha-chikitsa.html',
    'vriksha-chikitsa/index.html',
    'views/vriksha-chikitsa.php',
    'about-us.html',
    'about-us/index.html',
]

print("=== VERIFYING VIDEO FRAMES ACROSS ALL FILES ===")
all_pass = True

for path in files_to_check:
    with open(path, 'r', encoding='utf-8', errors='ignore') as f:
        c = f.read()

    has_container = 'mgm-video-container' in c
    has_wrapper = 'data-video-wrapper' in c
    has_video_class = 'mgm-autoplay-video' in c
    has_overlay = 'mgm-video-controls-overlay' in c
    has_mute_btn = 'mgm-btn-mute' in c
    has_badge = 'mgm-video-badge' in c
    has_dot = 'mgm-video-badge-dot' in c
    has_old_card = 'class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-dark"' in c
    has_old_controls = 'controls' in c and '<video' in c and 'controls' in re.search(r'<video[^>]*>', c).group(0)

    # Check that it has all standard components and none of the old card/controls
    passed = has_container and has_wrapper and has_video_class and has_overlay and has_mute_btn and has_badge and has_dot and not has_old_card and not has_old_controls

    if passed:
        print(f"PASS: {path}")
    else:
        all_pass = False
        print(f"FAIL: {path} - container:{has_container}, wrapper:{has_wrapper}, videoClass:{has_video_class}, overlay:{has_overlay}, muteBtn:{has_mute_btn}, badge:{has_badge}, dot:{has_dot}, oldCard:{has_old_card}, oldControls:{has_old_controls}")

print("---")
print("ALL VIDEO CHECKS PASSED?", all_pass)
