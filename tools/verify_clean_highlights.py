import requests
import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

BASE_LIVE = "https://mgmmodelschool.edu.in"

checks = [
    ("/gdc/", "assets/images/gdc-clean.jpeg"),
    ("/krishi-thottam/", "assets/images/poly-house-akshara-muttathe-krishithottam-3.jpeg"),
    ("/counselling-centre/", "assets/images/counselling-centre-clean.jpeg"),
    ("/life-skills/", "assets/images/life-skills-clean.jpeg"),
    ("/amma-school/", "assets/images/amma-school-clean.jpeg"),
    ("/voice-of-mgm/", "assets/images/voice-of-mgm-clean.jpeg"),
    ("/happiness-room/", "assets/images/happiness-room-clean.jpeg"),
    ("/school-band-troop/", "assets/images/school-band-troop.jpeg"),
    ("/libraries-at-mgm/", "assets/images/libraries-1.jpeg"),
    ("/libraries-at-mgm/", "assets/images/libraries-2.jpeg"),
    ("/libraries-at-mgm/", "assets/images/libraries-3.jpeg"),
    ("/mandatory-disclosure/", "assets/images/fee-structure-2026-27.png"),
    ("/mandatory-disclosure/", "assets/images/student-strength-2026-27.png"),
    ("/mandatory-disclosure/", "assets/images/smc-list-2026-27.jpg"),
    ("/mandatory-disclosure/", "assets/images/download-image.png"),
    ("/mandatory-disclosure/", "assets/images/download-pdf.png"),
    ("/highlights/", "assets/images/school-band-troop.jpeg"),
    ("/highlights/", "assets/images/gdc-clean.jpeg"),
    ("/highlights/", "assets/images/voice-of-mgm-clean.jpeg"),
    ("/highlights/", "assets/images/happiness-room-clean.jpeg"),
]

print("=== VERIFYING LIVE PRODUCTION PAGES & IMAGES ===")
all_passed = True
checked_images = set()

for path, expected_img in checks:
    url = f"{BASE_LIVE}{path}"
    try:
        r = requests.get(url, verify=False, timeout=15)
        if r.status_code == 200:
            if expected_img in r.text:
                print(f" PASS: {url} (HTTP 200, contains {expected_img})")
            else:
                print(f" WARN: {url} (HTTP 200, but {expected_img} not found in HTML)")
                all_passed = False
        else:
            print(f" FAIL: {url} returned HTTP {r.status_code}")
            all_passed = False
    except Exception as e:
        print(f" ERROR: {url} -> {e}")
        all_passed = False

    # Check image URL directly
    if expected_img not in checked_images:
        checked_images.add(expected_img)
        img_url = f"{BASE_LIVE}/{expected_img}"
        try:
            ir = requests.get(img_url, verify=False, timeout=15)
            if ir.status_code == 200 and len(ir.content) > 1000:
                print(f"   PASS Image: {img_url} (HTTP 200, {len(ir.content)} bytes)")
            else:
                print(f"   FAIL Image: {img_url} returned HTTP {ir.status_code}")
                all_passed = False
        except Exception as e:
            print(f"   ERROR Image: {img_url} -> {e}")
            all_passed = False

if all_passed:
    print("\n>>> ALL LIVE VERIFICATIONS PASSED 100%! <<<")
else:
    print("\n>>> SOME CHECKS FAILED! <<<")
