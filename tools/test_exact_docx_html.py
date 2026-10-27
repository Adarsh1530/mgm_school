assertions = [
    ('twenty-twenty-method.html', 'Each day, 5 students present their understanding in 4 minutes each'),
    ('gdc.html', 'The General Development Cell (GDC) is an innovative initiative'),
    ('3d-max-zone.html', 'Euler\'s formula (F+V-E)'),
    ('ncc.html', 'Retd. Subedar Major Mr. Rajesh S'),
    ('hindustan-scouts-guides.html', '45 cadets have been awarded the prestigious Rajyapuraskar'),
    ('school-canteen.html', 'Vegetarian food is served on Tuesdays and Thursdays'),
    ('vriksha-chikitsa.html', 'jackfruit tree, aged over 40 years'),
    ('counselling-centre.html', 'MANODARPAN'),
    ('nova-ai-hub.html', 'Cubelets for building small robots'),
    ('nova-ai-hub.html', '/assets/videos/nova-ai-hub.mp4'),
    ('swimming-pool.html', 'pool exclusively for children below 8 years'),
    ('libraries-at-mgm.html', 'houses three well-stocked libraries catering to Primary, Secondary and Higher Secondary'),
    ('poly-house.html', 'Adv. K. M. Laji, Chairman, Varkala Municipality'),
    ('amma-school.html', 'Sri. Udit Chaithanya'),
    ('innovation-centre.html', 'Shri Arif Mohammed Khan'),
    ('ominis.html', 'interactive AI-powered learning companion'),
    ('school-band-troop.html', 'band troop of 25 boys & girls'),
    ('happiness-room.html', 'Pause. Create. Express. Shine.')
]

all_passed = True
for html_file, phrase in assertions:
    with open(html_file, 'r', encoding='utf-8') as f:
        c = f.read()
    if phrase in c:
        print(f"PASSED: {html_file} contains '{phrase[:40]}...'")
    else:
        print(f"FAILED: {html_file} MISSING '{phrase}'")
        all_passed = False

if all_passed:
    print("\nALL 18 EXACT CONTENT ASSERTIONS PASSED WITH 100% SUCCESS!")
else:
    print("\nSOME ASSERTIONS FAILED!")
