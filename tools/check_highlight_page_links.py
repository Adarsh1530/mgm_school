import glob
import re

print("=== CHECKING ALL LINKS IN 21 HIGHLIGHT VIEWS ===")

view_files = [
    'views/swimming-pool.php',
    'views/twenty-twenty-method.php',
    'views/libraries-at-mgm.php',
    'views/poly-house.php',
    'views/krishi-thottam.php',
    'views/amma-school.php',
    'views/vriksha-chikitsa.php',
    'views/counselling-centre.php',
    'views/innovation-centre.php',
    'views/gdc.php',
    'views/life-skills.php',
    'views/voice-of-mgm.php',
    'views/school-canteen.php',
    'views/butterfly-garden.php',
    'views/3d-max-zone.php',
    'views/ominis.php',
    'views/nova-ai-hub.php',
    'views/ncc.php',
    'views/hindustan-scouts-guides.php',
    'views/school-band-troop.php',
    'views/happiness-room.php'
]

for vf in view_files:
    c = open(vf, encoding='utf-8').read()
    hrefs = re.findall(r'href="([^"]+)"', c)
    print(f"\n{vf}:")
    for h in hrefs:
        print(f"   href: {h}")
