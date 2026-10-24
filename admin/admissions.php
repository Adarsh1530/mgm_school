<?php
/**
 * Admin Enquiries & Admissions Submissions
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'admissions';
$adminTitle = 'Form Submissions & Enquiries';

$db = getDB();

// Handle Status Update or Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'update_status') {
            $id = (int)($_POST['id'] ?? 0);
            $status = $_POST['status'] ?? 'new';
            if ($id > 0 && in_array($status, ['new', 'contacted', 'closed'])) {
                $db->prepare("UPDATE enquiries SET status = :st WHERE id = :id")->execute([':st' => $status, ':id' => $id]);
                log_audit("Enquiry Status Updated", "Submission ID {$id} marked as {$status}");
                set_flash('success', "Status updated to " . ucfirst($status));
            }
            header("Location: " . ADMIN_URL . "/admissions.php");
            exit;
        }

        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $db->prepare("DELETE FROM enquiries WHERE id = :id")->execute([':id' => $id]);
                log_audit("Enquiry Deleted", "Deleted enquiry ID {$id}");
                set_flash('success', "Submission deleted.");
            }
            header("Location: " . ADMIN_URL . "/admissions.php");
            exit;
        }
    }
}

$enquiries = $db->query("SELECT * FROM enquiries ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<div class="bg-white p-4 rounded-3 border shadow-sm">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold text-dark mb-0">Admission & Alumni Submissions (<?= count($enquiries) ?>)</h5>
  </div>

  <?php if (empty($enquiries)): ?>
    <div class="p-4 text-center text-muted">No submissions found.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Name</th>
            <th>Contact Phone</th>
            <th>Email</th>
            <th>Grade / Batch</th>
            <th>Message</th>
            <th>Status</th>
            <th>Date</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($enquiries as $row): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td>
                <span class="badge bg-<?= $row['type'] === 'admission' ? 'danger' : 'info' ?>">
                  <?= ucfirst($row['type']) ?>
                </span>
              </td>
              <td class="fw-bold text-dark"><?= e($row['name']) ?></td>
              <td><a href="tel:<?= e($row['phone']) ?>"><?= e($row['phone']) ?></a></td>
              <td><?= e($row['email'] ?: '-') ?></td>
              <td>
                <?php if ($row['grade_applied']): ?>
                  <span class="badge bg-light text-dark border"><?= e($row['grade_applied']) ?></span>
                <?php elseif ($row['passing_year']): ?>
                  <span class="badge bg-light text-primary border">Batch <?= e($row['passing_year']) ?></span>
                  <?php if ($row['profession']): ?><div class="small text-muted"><?= e($row['profession']) ?></div><?php endif; ?>
                <?php else: ?>
                  -
                <?php endif; ?>
              </td>
              <td class="text-muted small" style="max-width: 250px;"><?= e($row['message'] ?: '-') ?></td>
              <td>
                <form method="POST" action="" class="d-inline">
                  <input type="hidden" name="action" value="update_status">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                  <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="font-size: 12px; width: 110px;">
                    <option value="new" <?= $row['status'] === 'new' ? 'selected' : '' ?>>New</option>
                    <option value="contacted" <?= $row['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                    <option value="closed" <?= $row['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                  </select>
                </form>
              </td>
              <td class="text-muted small"><?= date('M j, Y', strtotime($row['created_at'])) ?></td>
              <td class="text-end">
                <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Delete this submission?');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Entry">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
