import urllib.request
import ssl

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

highlights_slugs = [
    'swimming-pool',
    'twenty-twenty-method',
    'libraries-at-mgm',
    'poly-house',
    'krishi-thottam',
    'amma-school',
    'vriksha-chikitsa',
    'counselling-centre',
    'innovation-centre',
    'gdc',
    'life-skills',
    'voice-of-mgm',
    'school-canteen',
    'butterfly-garden',
    '3d-max-zone',
    'ominis',
    'nova-ai-hub',
    'ncc',
    'hindustan-scouts-guides',
    'school-band-troop',
    'happiness-room'
]

print("Testing all 21 highlights on live server:")
for s in highlights_slugs:
    # Test 1: trailing slash
    url_slash = f"https://mgmmodelschool.edu.in/{s}/"
    try:
        req = urllib.request.Request(url_slash, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req, context=ctx) as r:
            st1 = r.status
    except Exception as e:
        st1 = str(e)
        
    # Test 2: no slash
    url_noslash = f"https://mgmmodelschool.edu.in/{s}"
    try:
        req2 = urllib.request.Request(url_noslash, headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req2, context=ctx) as r2:
            st2 = r2.status
    except Exception as e:
        st2 = str(e)

    print(f"{s:25} | with slash: {st1} | without slash: {st2}")
