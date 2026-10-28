<?php
/**
 * Admin Dashboard View
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'dashboard';
$adminTitle = 'Dashboard Overview';

$db = getDB();

// Fast Metric Counts
$noticesCount = (int)$db->query("SELECT COUNT(*) FROM notices")->fetchColumn();
$activeNoticesCount = (int)$db->query("SELECT COUNT(*) FROM notices WHERE is_active = 1")->fetchColumn();
$disclosuresCount = (int)$db->query("SELECT COUNT(*) FROM mandatory_disclosures")->fetchColumn();
$galleryCount = (int)$db->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$usersCount = 0;
if (is_superadmin()) {
    $usersCount = (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
}

// Popup Notification Status
$popupActive = false;
try {
    $popupActive = (int)$db->query("SELECT COUNT(*) FROM popups WHERE is_active = 1")->fetchColumn() > 0;
} catch (\Throwable $e) {
    $popupActive = (get_setting('popup_enabled', '0') === '1' && !empty(get_setting('popup_image_url', '')));
}

require_once __DIR__ . '/header.php';
?>

<!-- Statistics Metric Cards -->
<div class="row g-4 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">School Notices</div>
          <h2 class="fw-bold my-1 text-dark"><?= $noticesCount ?></h2>
          <div class="text-muted small mb-2"><span class="badge bg-success bg-opacity-10 text-success fw-bold"><?= $activeNoticesCount ?> Active</span></div>
          <a href="<?= ADMIN_URL ?>/notices.php" class="text-danger small fw-bold">Manage Notices &rarr;</a>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
          <i class="fa-solid fa-bullhorn fa-2x" style="color: var(--admin-primary);"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Disclosures</div>
          <h2 class="fw-bold my-1 text-dark"><?= $disclosuresCount ?></h2>
          <div class="text-muted small mb-2"><span class="badge bg-secondary bg-opacity-10 text-secondary fw-bold">CBSE Documents</span></div>
          <a href="<?= ADMIN_URL ?>/disclosures.php" class="text-danger small fw-bold">Manage Documents &rarr;</a>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
          <i class="fa-solid fa-file-pdf fa-2x" style="color: var(--admin-primary);"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Gallery Photos</div>
          <h2 class="fw-bold my-1 text-dark"><?= $galleryCount ?></h2>
          <div class="text-muted small mb-2"><span class="badge bg-primary bg-opacity-10 text-primary fw-bold">Reorder Enabled</span></div>
          <a href="<?= ADMIN_URL ?>/gallery.php" class="text-danger small fw-bold">Manage Photos &rarr;</a>
        </div>
        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
          <i class="fa-solid fa-images fa-2x"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Popup Notification</div>
          <h2 class="fw-bold my-1 text-dark"><?= $popupActive ? 'ON' : 'OFF' ?></h2>
          <div class="text-muted small mb-2">
            <?php if ($popupActive): ?>
              <span class="badge bg-success bg-opacity-10 text-success fw-bold">Active &amp; Live</span>
            <?php else: ?>
              <span class="badge bg-secondary bg-opacity-10 text-secondary fw-bold">Disabled</span>
            <?php endif; ?>
          </div>
          <a href="<?= ADMIN_URL ?>/popup.php" class="text-danger small fw-bold">Configure Popup &rarr;</a>
        </div>
        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
          <i class="fa-solid fa-window-restore fa-2x" style="color: #F59E0B;"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (is_superadmin()): ?>
  <!-- Super Admin Management Banner -->
  <div class="card border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #1A1D24 0%, #2A303C 100%); color: #ffffff;">
    <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3">
        <div style="width: 54px; height: 54px; border-radius: 12px; background: rgba(171, 12, 47, 0.2); border: 1px solid rgba(171, 12, 47, 0.4); display: flex; align-items: center; justify-content: center; font-size: 24px; color: #ff6b81;">
          <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
          <div class="d-flex align-items-center gap-2">
            <h5 class="fw-bold mb-0 text-white">User Roles &amp; Access Control</h5>
            <span class="badge bg-danger text-white">Super Admin Exclusive</span>
          </div>
          <p class="text-white-50 small mb-0 mt-1">There are currently <b><?= $usersCount ?> users</b> configured. Manage administrative credentials, roles, and access rights.</p>
        </div>
      </div>
      <div>
        <a href="<?= ADMIN_URL ?>/users.php" class="btn btn-danger btn-sm px-3 py-2 fw-semibold shadow-sm">
          <i class="fa-solid fa-users-gear me-1"></i> Manage User Roles &rarr;
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
