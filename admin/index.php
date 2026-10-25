<?php
/**
 * Admin Dashboard
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'dashboard';
$adminTitle = 'Dashboard Overview';

$db = getDB();

// Gather statistics
$noticesCount = (int)$db->query("SELECT COUNT(*) FROM notices")->fetchColumn();
$activeNoticesCount = (int)$db->query("SELECT COUNT(*) FROM notices WHERE is_active = 1")->fetchColumn();
$disclosuresCount = (int)$db->query("SELECT COUNT(*) FROM mandatory_disclosures")->fetchColumn();
$galleryCount = (int)$db->query("SELECT COUNT(*) FROM gallery")->fetchColumn();

// Popup setting
$popupActive = (int)$db->query("SELECT setting_value FROM site_settings WHERE setting_key = 'popup_active'")->fetchColumn();

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
          <div class="text-muted small fw-semibold text-uppercase">Mandatory Disclosures</div>
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
          <div class="text-muted small fw-semibold text-uppercase">Popup Announcement</div>
          <h2 class="fw-bold my-1 text-dark"><?= $popupActive ? 'Active' : 'Off' ?></h2>
          <div class="text-muted small mb-2">
            <span class="badge <?= $popupActive ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary' ?> fw-bold">
              <?= $popupActive ? 'Live on Site' : 'Disabled' ?>
            </span>
          </div>
          <a href="<?= ADMIN_URL ?>/popup.php" class="text-danger small fw-bold">Manage Popup &rarr;</a>
        </div>
        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
          <i class="fa-solid fa-window-restore fa-2x" style="color: #d97706;"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
