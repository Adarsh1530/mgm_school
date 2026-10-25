<?php
/**
 * Admin Mandatory Disclosures Management
 * MGM Model School Management Portal
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

        // Add New Document
        if ($action === 'add') {
            $title = trim($_POST['title'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

            if (empty($title) || empty($_FILES['document']['name'])) {
                set_flash('error', 'Please provide both title and document file.');
            } else {
                $file = $_FILES['document'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'webp'];

                if (!in_array($ext, $allowed)) {
                    set_flash('error', 'Allowed formats: PDF, PNG, JPG, JPEG, WebP.');
                } elseif ($file['size'] > 25 * 1024 * 1024) {
                    set_flash('error', 'File size exceeds 25MB limit.');
                } else {
                    $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $subFolder = ($ext === 'pdf') ? 'docs' : 'images';
                    $targetDir = ($ext === 'pdf') ? DOCS_DIR : IMAGES_DIR;
                    $targetPath = $targetDir . '/' . $cleanName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $sizeKb = round($file['size'] / 1024) . ' KB';
                        $ins = $db->prepare("INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES (:title, :fn, :url, :sz, :so)");
                        $ins->execute([
                            ':title' => $title,
                            ':fn'    => $cleanName,
                            ':url'   => "assets/{$subFolder}/" . $cleanName,
                            ':sz'    => $sizeKb,
                            ':so'    => $sort
                        ]);
                        set_flash('success', "Disclosure '{$title}' added successfully.");
                    } else {
                        set_flash('error', 'Failed to save uploaded document.');
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/disclosures.php");
            exit;
        }

        // Edit & Replace Document
        if ($action === 'edit') {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

            if ($id > 0 && !empty($title)) {
                $existing = $db->query("SELECT * FROM mandatory_disclosures WHERE id = {$id}")->fetch();
                if ($existing) {
                    $fileName = $existing['file_name'];
                    $fileUrl = $existing['file_url'];
                    $fileSize = $existing['file_size'];

                    // Optional file replacement
                    if (!empty($_FILES['document']['name'])) {
                        $file = $_FILES['document'];
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'webp'];

                        if (!in_array($ext, $allowed)) {
                            set_flash('error', 'Allowed formats: PDF, PNG, JPG, JPEG, WebP.');
                            header("Location: " . ADMIN_URL . "/disclosures.php?edit={$id}");
                            exit;
                        } elseif ($file['size'] > 25 * 1024 * 1024) {
                            set_flash('error', 'File size exceeds 25MB limit.');
                            header("Location: " . ADMIN_URL . "/disclosures.php?edit={$id}");
                            exit;
                        } else {
                            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                            $subFolder = ($ext === 'pdf') ? 'docs' : 'images';
                            $targetDir = ($ext === 'pdf') ? DOCS_DIR : IMAGES_DIR;
                            $targetPath = $targetDir . '/' . $cleanName;

                            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                                $fileName = $cleanName;
                                $fileUrl = "assets/{$subFolder}/" . $cleanName;
                                $fileSize = round($file['size'] / 1024) . ' KB';
                            }
                        }
                    }

                    $upd = $db->prepare("UPDATE mandatory_disclosures SET title = :title, file_name = :fn, file_url = :url, file_size = :sz, sort_order = :so WHERE id = :id");
                    $upd->execute([
                        ':title' => $title,
                        ':fn'    => $fileName,
                        ':url'   => $fileUrl,
                        ':sz'    => $fileSize,
                        ':so'    => $sort,
                        ':id'    => $id
                    ]);

                    set_flash('success', "Disclosure '{$title}' updated successfully.");
                }
            }
            header("Location: " . ADMIN_URL . "/disclosures.php");
            exit;
        }

        // Delete Document
        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $doc = $db->query("SELECT * FROM mandatory_disclosures WHERE id = {$id}")->fetch();
                if ($doc) {
                    $db->exec("DELETE FROM mandatory_disclosures WHERE id = {$id}");
                    set_flash('success', "Document '{$doc['title']}' deleted.");
                }
            }
            header("Location: " . ADMIN_URL . "/disclosures.php");
            exit;
        }
    }
}

// Check if in Edit mode
$editDoc = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $editDoc = $db->query("SELECT * FROM mandatory_disclosures WHERE id = {$editId}")->fetch();
}

$disclosures = $db->query("SELECT * FROM mandatory_disclosures ORDER BY sort_order ASC, id ASC")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<div class="row g-4">
  
  <!-- Left Column: Add / Edit Document Form -->
  <div class="col-lg-4">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <h5 class="fw-bold text-dark mb-3">
        <?php if ($editDoc): ?>
          <i class="fa-solid fa-pen-to-square me-1 text-primary"></i> Edit & Replace Document
        <?php else: ?>
          <i class="fa-solid fa-plus-circle me-1 text-danger"></i> Add New Disclosure
        <?php endif; ?>
      </h5>

      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $editDoc ? 'edit' : 'add' ?>">
        <?php if ($editDoc): ?>
          <input type="hidden" name="id" value="<?= $editDoc['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold small">Document Title *</label>
          <input type="text" name="title" class="form-control" value="<?= e($editDoc['title'] ?? '') ?>" placeholder="e.g. FIRE SAFETY CERTIFICATE" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">
            <?= $editDoc ? 'Replace Document / Photo (Optional)' : 'Upload Document / Photo *' ?>
          </label>
          <input type="file" name="document" class="form-control" accept=".pdf,image/*" <?= $editDoc ? '' : 'required' ?>>
          <div class="form-text small">Accepted formats: PDF, PNG, JPG, WebP (Max 25MB)</div>

          <?php if ($editDoc): ?>
            <div class="alert alert-light border mt-2 p-2 small">
              <div class="fw-semibold text-dark">Current Document:</div>
              <div class="text-truncate text-muted"><?= e($editDoc['file_name']) ?> (<?= e($editDoc['file_size']) ?>)</div>
              <a href="<?= asset_url($editDoc['file_url']) ?>" target="_blank" class="fw-bold text-primary text-decoration-none mt-1 d-inline-block">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Preview Current File
              </a>
            </div>
          <?php endif; ?>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small">Display Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="<?= e($editDoc['sort_order'] ?? count($disclosures) + 1) ?>" min="0">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn-admin-primary flex-grow-1 py-2">
            <i class="fa-solid <?= $editDoc ? 'fa-floppy-disk' : 'fa-cloud-arrow-up' ?> me-1"></i>
            <?= $editDoc ? 'Save Updates' : 'Upload Document' ?>
          </button>
          <?php if ($editDoc): ?>
            <a href="<?= ADMIN_URL ?>/disclosures.php" class="btn btn-outline-secondary py-2">Cancel</a>
          <?php endif; ?>
        </div>
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
              <th style="width: 60px;">Order</th>
              <th>Document Title</th>
              <th>File Name</th>
              <th>Size</th>
              <th class="text-end" style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($disclosures as $d): ?>
              <tr class="<?= ($editDoc && $editDoc['id'] == $d['id']) ? 'table-warning' : '' ?>">
                <td class="fw-bold text-muted">#<?= $d['sort_order'] ?></td>
                <td class="fw-bold text-dark"><?= e($d['title']) ?></td>
                <td class="text-muted text-truncate" style="max-width: 180px;">
                  <?php if (str_ends_with(strtolower($d['file_url']), '.pdf')): ?>
                    <i class="fa-solid fa-file-pdf text-danger me-1"></i>
                  <?php else: ?>
                    <i class="fa-solid fa-file-image text-primary me-1"></i>
                  <?php endif; ?>
                  <?= e($d['file_name']) ?>
                </td>
                <td><span class="badge bg-light text-dark border"><?= e($d['file_size']) ?></span></td>
                <td class="text-end">
                  <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View Document">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
                  <a href="<?= ADMIN_URL ?>/disclosures.php?edit=<?= $d['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit & Replace">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this disclosure document?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $d['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
