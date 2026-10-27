import os
from exact_docx_data import DOCX_HIGHLIGHTS
from apply_exact_docx_views import build_view

for slug, data in DOCX_HIGHLIGHTS.items():
    build_view(slug, data)
print("Updated all views.")
