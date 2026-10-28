import urllib.request

urls = [
    'https://mgmmodelschool.edu.in/',
    'https://mgmmodelschool.edu.in/notices/',
    'https://mgmmodelschool.edu.in/gallery/',
    'https://mgmmodelschool.edu.in/about-us/',
    'https://mgmmodelschool.edu.in/mandatory-disclosure/',
    'https://mgmmodelschool.edu.in/admission-procedure/',
    'https://mgmmodelschool.edu.in/swimming-pool/',
    'https://mgmmodelschool.edu.in/twenty-twenty-method/',
    'https://mgmmodelschool.edu.in/nova-ai-hub/',
    'https://mgmmodelschool.edu.in/attendance/',
    'https://mgmmodelschool.edu.in/alumni/',
    'https://mgmmodelschool.edu.in/merit-day/',
    'https://mgmmodelschool.edu.in/courses-offered/',
    'https://mgmmodelschool.edu.in/contact/'
]

headers = {'User-Agent': 'Mozilla/5.0'}

for u in urls:
    try:
        req = urllib.request.Request(u, headers=headers)
        resp = urllib.request.urlopen(req, timeout=10)
        body = resp.read().decode('utf-8', errors='ignore')
        has_head = '<head' in body or '<html' in body
        has_bootstrap = 'bootstrap.css' in body
        has_broken_base = 'base href="https://mgmmodelschool.edu.in/notices/' in body
        print(f"{u:50} | HTTP {resp.status} | len: {len(body):6} | head: {has_head!s:5} | css: {has_bootstrap!s:5} | broken_base: {has_broken_base}")
    except Exception as e:
        print(f"{u:50} | ERROR: {e}")
