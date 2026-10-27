import os
import re

files = [
    'views/homepage_clean_extracted.html',
    'audit/homepage_clean_extracted.html'
]

start_marker = '<div class="elementor-element elementor-element-5a05849 e-con-full e-flex e-con e-child" data-id="5a05849"'
end_marker = '<div class="elementor-element elementor-element-29faa04 e-flex e-con-boxed e-con e-child" data-id="29faa04"'

for path in files:
    if not os.path.exists(path):
        continue
    with open(path, 'r', encoding='utf-8') as f:
        text = f.read()

    idx_start = text.find(start_marker)
    idx_end = text.find(end_marker)

    if idx_start != -1 and idx_end != -1:
        # Check intermediate closing divs
        # The block between 5a05849 and 29faa04 has:
        # the 5a05849 container itself, followed by:
        # 					</div>
        # 				</div>
        # which closes 67b227f / e-con-inner
        # Let's inspect exact text between idx_start and idx_end!
        block = text[idx_start:idx_end]
        print(f"In {path}, block length={len(block)}")
        
        # We only want to remove 5a05849 and its closing divs (8 divs total)
        # Let's find where 5a05849 ends
        open_count = 0
        close_idx = -1
        i = idx_start
        while i < len(text):
            if text[i:i+4] == '<div':
                open_count += 1
            elif text[i:i+6] == '</div':
                open_count -= 1
                if open_count == 0:
                    close_idx = i + 6
                    # consume optional whitespace
                    while close_idx < len(text) and text[close_idx] in ' \t\r\n':
                        close_idx += 1
                    break
            i += 1

        print(f"Found exact 5a05849 container from {idx_start} to {close_idx}")
        extracted_card = text[idx_start:close_idx]
        print("Starts:", repr(extracted_card[:60]))
        print("Ends:", repr(extracted_card[-60:]))
        
        new_text = text[:idx_start] + text[close_idx:]
        with open(path, 'w', encoding='utf-8') as f:
            f.write(new_text)
        print(f"Successfully removed 4th card (Fees Structure) from {path}!\n")
    else:
        print(f"Markers not found in {path}")
