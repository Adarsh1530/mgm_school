import os
import sqlite3
import json

# Ensure assets/videos/nova-ai-hub.mp4 exists
nova_src = r'C:\Users\KEERTHI ADARSH M P\Desktop\nova ai hub.mp4'
nova_dst = r'assets/videos/nova-ai-hub.mp4'
if os.path.exists(nova_src) and not os.path.exists(nova_dst):
    import shutil
    shutil.copyfile(nova_src, nova_dst)
    print("Copied nova ai hub video.")

print(f"Nova video exists at {nova_dst}: {os.path.exists(nova_dst)} ({os.path.getsize(nova_dst)} bytes)")
