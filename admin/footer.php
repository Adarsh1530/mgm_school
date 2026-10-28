<?php
/**
 * Admin Panel Footer
 * MGM Model School Recreation Project
 */
?>
    </main>

    <footer class="admin-footer bg-white border-top py-3 px-4 text-muted small d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>
        MGM Model School Admin Portal &copy; <?= date('Y') ?> &bull; Internal Content Management System
      </div>
    </footer>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
      document.getElementById('adminSidebar')?.classList.toggle('show');
      document.getElementById('sidebarBackdrop')?.classList.toggle('show');
    });
    document.getElementById('sidebarBackdrop')?.addEventListener('click', function() {
      document.getElementById('adminSidebar')?.classList.remove('show');
      this.classList.remove('show');
    });
  </script>
</body>
</html>
