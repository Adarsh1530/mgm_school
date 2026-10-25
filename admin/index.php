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

// Recent notices
$recentNotices = $db->query("SELECT * FROM notices ORDER BY sort_order ASC, publish_date DESC LIMIT 5")->fetchAll();

// Recent disclosures
$recentDisclosures = $db->query("SELECT * FROM mandatory_disclosures ORDER BY sort_order ASC LIMIT 6")->fetchAll();

// Recent gallery photos
$recentPhotos = $db->query("SELECT * FROM gallery ORDER BY sort_order ASC LIMIT 6")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<!-- Statistics Metric Cards -->
<div class="row g-4 mb-4">
  <div class="col-xl-4 col-md-4">
    <div class="card-metric">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="text-muted small fw-semibold text-uppercase">School Notices & Circulars</div>
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

  <div class="col-xl-4 col-md-4">
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

  <div class="col-xl-4 col-md-4">
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
</div>

<div class="row g-4">
  
  <!-- Left Column: School Notices -->
  <div class="col-lg-7">
    <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-bullhorn me-2 text-danger"></i> Recent School Notices</h5>
        <div class="d-flex gap-2">
          <a href="<?= ADMIN_URL ?>/notices.php?action=new" class="btn btn-sm btn-admin-primary"><i class="fa-solid fa-plus me-1"></i> Add Notice</a>
          <a href="<?= ADMIN_URL ?>/notices.php" class="btn btn-sm btn-outline-secondary">View All</a>
        </div>
      </div>

      <?php if (empty($recentNotices)): ?>
        <p class="text-muted small my-3">No notices recorded yet.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
            <thead class="table-light">
              <tr>
                <th>Order</th>
                <th>Notice Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Status</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentNotices as $n): ?>
                <tr>
                  <td class="fw-bold text-muted">#<?= $n['sort_order'] ?></td>
                  <td class="fw-bold text-dark">
                    <?= e(mb_strimwidth($n['title'], 0, 42, '...')) ?>
                  </td>
                  <td>
                    <span class="badge bg-<?= e($n['badge_color'] ?: 'primary') ?> bg-opacity-10 text-<?= e($n['badge_color'] ?: 'primary') ?> border border-<?= e($n['badge_color'] ?: 'primary') ?> border-opacity-25">
                      <?= e($n['category']) ?>
                    </span>
                  </td>
                  <td class="text-muted small"><?= date('M j, Y', strtotime($n['publish_date'])) ?></td>
                  <td>
                    <?php if ($n['is_active']): ?>
                      <span class="badge bg-success">Active</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Draft</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-end">
                    <a href="<?= ADMIN_URL ?>/notices.php?edit=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Notice">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <!-- Mandatory Disclosures Quick Table -->
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-file-pdf me-2 text-danger"></i> Mandatory Disclosures (Top <?= count($recentDisclosures) ?>)</h5>
        <a href="<?= ADMIN_URL ?>/disclosures.php" class="btn btn-sm btn-outline-secondary">Manage Documents</a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
          <thead class="table-light">
            <tr>
              <th style="width: 60px;">Order</th>
              <th>Document Title</th>
              <th>File Size</th>
              <th class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentDisclosures as $d): ?>
              <tr>
                <td class="fw-bold text-muted">#<?= $d['sort_order'] ?></td>
                <td class="fw-bold text-dark"><?= e($d['title']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= e($d['file_size']) ?></span></td>
                <td class="text-end">
                  <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View Document">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
                  <a href="<?= ADMIN_URL ?>/disclosures.php?edit=<?= $d['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit & Replace">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Right Column: Gallery Photos Overview with Quick Order -->
  <div class="col-lg-5">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-images me-2 text-primary"></i> Gallery Photos (Top 6)</h5>
        <a href="<?= ADMIN_URL ?>/gallery.php" class="btn btn-sm btn-outline-secondary">Change Order</a>
      </div>

      <div class="row g-3">
        <?php foreach ($recentPhotos as $p): ?>
          <div class="col-sm-6">
            <div class="card h-100 border shadow-none" style="background: #FAFAFA;">
              <div class="position-relative">
                <img src="<?= asset_url($p['image_path']) ?>" alt="<?= e($p['title']) ?>" class="card-img-top" style="height: 120px; object-fit: cover;">
                <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75">
                  Pos #<?= $p['sort_order'] ?>
                </span>
              </div>
              <div class="card-body p-2">
                <div class="fw-bold text-dark text-truncate small" title="<?= e($p['title']) ?>"><?= e($p['title']) ?></div>
                <div class="text-muted small" style="font-size: 11px;"><?= e($p['category']) ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-4 pt-3 border-top text-center">
        <a href="<?= ADMIN_URL ?>/gallery.php" class="btn btn-outline-danger btn-sm px-4">
          <i class="fa-solid fa-arrow-down-up-across-line me-1"></i> Open Gallery Order Manager
        </a>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
