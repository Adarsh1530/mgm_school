<?php
/**
 * Admin Dashboard
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'dashboard';
$adminTitle = 'Dashboard Overview';

$db = getDB();

// Gather statistics
$pagesCount = $db->query("SELECT COUNT(*) FROM pages")->fetchColumn();
$disclosuresCount = $db->query("SELECT COUNT(*) FROM mandatory_disclosures")->fetchColumn();
$galleryCount = $db->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$coursesCount = $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$enquiriesCount = $db->query("SELECT COUNT(*) FROM enquiries")->fetchColumn();

// Recent enquiries
$recentEnquiries = $db->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 5")->fetchAll();

// Recent audit logs
$recentLogs = $db->query("SELECT a.*, u.username FROM audit_logs a LEFT JOIN users u ON a.user_id = u.id ORDER BY a.id DESC LIMIT 6")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<!-- Statistics Metric Cards -->
<div class="row g-4 mb-5">
  <div class="col-xl-3 col-sm-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Managed Pages</div>
          <h2 class="fw-bold my-1 text-dark"><?= $pagesCount ?></h2>
          <a href="<?= ADMIN_URL ?>/pages.php" class="text-danger small fw-bold">Manage Pages &rarr;</a>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
          <i class="fa-solid fa-file-lines fa-2x" style="color: var(--admin-primary);"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Mandatory Disclosures</div>
          <h2 class="fw-bold my-1 text-dark"><?= $disclosuresCount ?></h2>
          <a href="<?= ADMIN_URL ?>/disclosures.php" class="text-danger small fw-bold">Manage Documents &rarr;</a>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
          <i class="fa-solid fa-file-pdf fa-2x" style="color: var(--admin-primary);"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Gallery Photos</div>
          <h2 class="fw-bold my-1 text-dark"><?= $galleryCount ?></h2>
          <a href="<?= ADMIN_URL ?>/gallery.php" class="text-danger small fw-bold">Manage Photos &rarr;</a>
        </div>
        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
          <i class="fa-solid fa-images fa-2x"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">Form Submissions</div>
          <h2 class="fw-bold my-1 text-dark"><?= $enquiriesCount ?></h2>
          <a href="<?= ADMIN_URL ?>/admissions.php" class="text-danger small fw-bold">View Inquiries &rarr;</a>
        </div>
        <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
          <i class="fa-solid fa-inbox fa-2x"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  
  <!-- Left Column: Recent Enquiries -->
  <div class="col-lg-7">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-envelope-open-text me-2 text-danger"></i> Recent Admission & Alumni Submissions</h5>
        <a href="<?= ADMIN_URL ?>/admissions.php" class="btn btn-sm btn-outline-secondary">View All</a>
      </div>

      <?php if (empty($recentEnquiries)): ?>
        <p class="text-muted small my-3">No submissions recorded yet.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
            <thead class="table-light">
              <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Grade / Batch</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentEnquiries as $enq): ?>
                <tr>
                  <td>
                    <span class="badge bg-<?= $enq['type'] === 'admission' ? 'danger' : 'info' ?>">
                      <?= ucfirst($enq['type']) ?>
                    </span>
                  </td>
                  <td class="fw-bold text-dark"><?= e($enq['name']) ?></td>
                  <td><?= e($enq['phone']) ?></td>
                  <td><?= e($enq['grade_applied'] ?? ($enq['passing_year'] ? 'Batch ' . $enq['passing_year'] : '-')) ?></td>
                  <td>
                    <span class="badge bg-secondary"><?= e($enq['status']) ?></span>
                  </td>
                  <td class="text-muted"><?= date('M j, Y', strtotime($enq['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Right Column: Recent Audit Activity -->
  <div class="col-lg-5">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i> Administrative Audit Trail</h5>
        <a href="<?= ADMIN_URL ?>/audit_logs.php" class="btn btn-sm btn-outline-secondary">All Logs</a>
      </div>

      <ul class="list-group list-group-flush" style="font-size: 13px;">
        <?php foreach ($recentLogs as $log): ?>
          <li class="list-group-item px-0 py-2 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold text-dark"><?= e($log['action']) ?></span>
              <span class="text-muted" style="font-size: 11px;"><?= date('M j, H:i', strtotime($log['created_at'])) ?></span>
            </div>
            <div class="text-muted small text-truncate"><?= e($log['details']) ?></div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
