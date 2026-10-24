<?php
/**
 * Admin Mandatory Disclosures Management
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'disclosures';
$adminTitle = 'Mandatory Disclosures Management';

$db = getDB();

// Handle Actions (Add, Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            $title = trim($_POST['title'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

            if (empty($title) || empty($_FILES['document']['name'])) {
                set_flash('error', 'Please provide both title and PDF document.');
            } else {
                $file = $_FILES['document'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                if ($ext !== 'pdf') {
                    set_flash('error', 'Only PDF files are permitted for Mandatory Disclosures.');
                } elseif ($file['size'] > 25 * 1024 * 1024) {
                    set_flash('error', 'PDF file size exceeds 25MB limit.');
                } else {
                    $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $fileName = time() . '_' . $cleanName;
                    $targetPath = DOCS_DIR . '/' . $fileName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $sizeKb = round($file['size'] / 1024) . ' KB';
                        $ins = $db->prepare("INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES (:title, :fn, :url, :sz, :so)");
                        $ins->execute([
                            ':title' => $title,
                            ':fn'    => $fileName,
                            ':url'   => 'assets/docs/' . $fileName,
                            ':sz'    => $sizeKb,
                            ':so'    => $sort
                        ]);
                        log_audit("Disclosure Added", "Uploaded new document: {$title} ({$fileName})");
                        set_flash('success', "Document '{$title}' added successfully.");
                    } else {
                        set_flash('error', 'Failed to save uploaded file.');
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/disclosures.php");
            exit;
        }

        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $doc = $db->query("SELECT * FROM mandatory_disclosures WHERE id = {$id}")->fetch();
                if ($doc) {
                    $db->exec("DELETE FROM mandatory_disclosures WHERE id = {$id}");
                    log_audit("Disclosure Deleted", "Deleted document ID {$id}: {$doc['title']}");
                    set_flash('success', "Document '{$doc['title']}' deleted.");
                }
            }
            header("Location: " . ADMIN_URL . "/disclosures.php");
            exit;
        }
    }
}

$disclosures = $db->query("SELECT * FROM mandatory_disclosures ORDER BY sort_order ASC, id ASC")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<div class="row g-4">
  
  <!-- Left Column: Add Document Form -->
  <div class="col-lg-4">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle me-1 text-danger"></i> Add New Disclosure</h5>

      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold small">Document Title *</label>
          <input type="text" name="title" class="form-control" placeholder="e.g. FIRE SAFETY CERTIFICATE" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Upload PDF File *</label>
          <input type="file" name="document" class="form-control" accept=".pdf" required>
          <div class="form-text small">Accepted format: .pdf (Max 25MB)</div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small">Display Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="<?= count($disclosures) + 1 ?>" min="0">
        </div>

        <button type="submit" class="btn-admin-primary w-100 py-2">
          <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload Document
        </button>
      </form>
    </div>
  </div>

  <!-- Right Column: Disclosures List -->
  <div class="col-lg-8">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Active Disclosure Documents (<?= count($disclosures) ?>)</h5>
        <a href="<?= url('/mandatory-disclosure/') ?>" target="_blank" class="btn btn-outline-info btn-sm">
          <i class="fa-solid fa-eye me-1"></i> View Live Page
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
          <thead class="table-light">
            <tr>
              <th>Order</th>
              <th>Document Title</th>
              <th>Filename</th>
              <th>Size</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($disclosures as $d): ?>
              <tr>
                <td class="fw-bold"><?= $d['sort_order'] ?></td>
                <td class="fw-bold text-dark"><?= e($d['title']) ?></td>
                <td class="text-muted text-truncate" style="max-width: 180px;"><?= e($d['file_name']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= e($d['file_size']) ?></span></td>
                <td class="text-end">
                  <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View Document">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
                  <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this disclosure document?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Document">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
