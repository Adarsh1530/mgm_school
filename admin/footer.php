<?php
/**
 * Admin Panel Footer
 * MGM Model School Recreation Project
 */
?>
    </main>

    <footer class="admin-footer bg-white">
      <div>
        <strong>MGM Model School</strong> | Admin Portal - Content Management System | &copy; <?= date('Y') ?> | <em>Technology Partner:</em> <a href="https://sparkitts.com" target="_blank" rel="noopener noreferrer"><strong>SparkIT Techno Solutions Pvt. Ltd.</strong></a>
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
