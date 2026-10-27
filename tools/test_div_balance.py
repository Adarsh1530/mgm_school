with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    lines = f.readlines()

print(f"Total lines before: {len(lines)}")
# Find start line of 5a05849
start_idx = None
end_idx = None
for i, l in enumerate(lines):
    if 'elementor-element-5a05849' in l:
        start_idx = i
    if start_idx is not None and i > start_idx:
        if 'elementor-element-29faa04' in l:
            # The line before line 180 (which has 2 closing divs)
            end_idx = i - 2
            break

print(f"start_idx={start_idx} (line {start_idx+1})")
print(f"end_idx={end_idx} (line {end_idx+1})")
print("Target snippet to remove:")
print("".join(lines[start_idx:end_idx]))

# Check div balance of snippet
snippet = "".join(lines[start_idx:end_idx])
print(f"Snippet div open={snippet.count('<div')}, close={snippet.count('</div')}")
