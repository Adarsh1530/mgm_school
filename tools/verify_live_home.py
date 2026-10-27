import requests
import urllib3
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

r = requests.get('https://mgmmodelschool.edu.in/', verify=False, timeout=15)
print('Live Homepage Status:', r.status_code)
html = r.text

print("'Fees <br> Structure' in live homepage:", 'Fees <br> Structure' in html)
print("'scholar' in live homepage:", 'scholar' in html.lower())
print("'structured fee programs' in live homepage:", 'structured fee programs' in html)
