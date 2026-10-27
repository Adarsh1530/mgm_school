import urllib.request

urls = [
    'https://mgmmodelschool.edu.in/nova-ai-hub/',
    'https://mgmmodelschool.edu.in/twenty-twenty-method/',
    'https://mgmmodelschool.edu.in/poly-house/',
    'https://mgmmodelschool.edu.in/swimming-pool/',
    'https://mgmmodelschool.edu.in/happiness-room/',
    'https://mgmmodelschool.edu.in/highlights/'
]

headers = {'User-Agent': 'Mozilla/5.0'}

print("Testing web pages:")
for u in urls:
    req = urllib.request.Request(u, headers=headers)
    resp = urllib.request.urlopen(req, timeout=15)
    body = resp.read().decode('utf-8', errors='ignore')
    print(f"  {u} -> HTTP {resp.status}, length: {len(body)}")
    if 'nova-ai-hub' in u:
        print("    Contains <video tag:", '<video' in body)
        print("    Contains nova-ai-hub.mp4:", '/assets/videos/nova-ai-hub.mp4' in body)

print("\nTesting video asset stream:")
video_url = 'https://mgmmodelschool.edu.in/assets/videos/nova-ai-hub.mp4'
req = urllib.request.Request(video_url, headers={'User-Agent': 'Mozilla/5.0', 'Range': 'bytes=0-1024'})
resp = urllib.request.urlopen(req, timeout=15)
print(f"  {video_url} -> HTTP {resp.status}")
print("  Content-Type:", resp.headers.get('Content-Type'))
print("  Content-Range:", resp.headers.get('Content-Range'))
print("  Accept-Ranges:", resp.headers.get('Accept-Ranges'))
print("  Total file length verified:", resp.headers.get('Content-Range', '').split('/')[-1])
