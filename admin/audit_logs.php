<?php
/**
 * Admin Audit Trail Logs
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'audit_logs';
$adminTitle = 'System Audit Trail';

$db = getDB();
$logs = $db->query("SELECT a.*, u.username FROM audit_logs a LEFT JOIN users u ON a.user_id = u.id ORDER BY a.id DESC LIMIT 100")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<div class="bg-white p-4 rounded-3 border shadow-sm">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clipboard-list me-2 text-danger"></i> Administrative Audit Trail (Last 100 Actions)</h5>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Timestamp</th>
          <th>User</th>
          <th>Action</th>
          <th>Details</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $l): ?>
          <tr>
            <td><?= $l['id'] ?></td>
            <td class="text-muted"><?= date('M j, Y H:i:s', strtotime($l['created_at'])) ?></td>
            <td>
              <span class="badge bg-secondary"><?= e($l['username'] ?? 'System') ?></span>
            </td>
            <td class="fw-bold text-dark"><?= e($l['action']) ?></td>
            <td class="text-muted" style="max-width: 400px;"><?= e($l['details']) ?></td>
            <td><code><?= e($l['ip_address']) ?></code></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
