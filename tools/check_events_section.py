with open('views/homepage_clean_extracted.html', 'r', encoding='utf-8') as f:
    text = f.read()

start_marker = '<div class="elementor-element elementor-element-810665c e-con-full e-flex e-con e-parent" data-id="810665c"'
end_marker = '<div class="elementor-element elementor-element-0c3ddc4 e-con-full e-flex e-con e-parent" data-id="0c3ddc4"'

idx_start = text.find(start_marker)
idx_end = text.find(end_marker)

print('Found start:', idx_start)
print('Found end:', idx_end)

section = text[idx_start:idx_end]
print('Section length:', len(section))
print('Starts with:', repr(section[:80]))
print('Ends with:', repr(section[-80:]))

open_divs = section.count('<div')
close_divs = section.count('</div')
print(f'Div balance: open={open_divs}, close={close_divs}')
