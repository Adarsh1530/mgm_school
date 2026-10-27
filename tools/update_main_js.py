with open('assets/js/main.js', 'r', encoding='utf-8') as f:
    c = f.read()

target = """      if (submenu) {
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
      }
    });
  });"""

repl = """      if (submenu) {
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
      }
    });
  });

  // Close mobile offcanvas when any submenu link is clicked
  const offcanvasLinks = document.querySelectorAll('.offcanvas-submenu a');
  offcanvasLinks.forEach(function (link) {
    link.addEventListener('click', function () {
      closeOffcanvas();
    });
  });"""

if target in c:
    c = c.replace(target, repl)
    with open('assets/js/main.js', 'w', encoding='utf-8') as f:
        f.write(c)
    print("Updated main.js with offcanvas close on click!")
else:
    print("Target not found in main.js")
