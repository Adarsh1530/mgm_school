<?php
/**
 * Admin Mandatory Disclosures Management
 * MGM Model School Management Portal
 * Supports both PDF documents and uploaded Images with live previews
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'disclosures';
$adminTitle = 'Mandatory Disclosures Management';

$db = getDB();

// Helper to check if file is an image
function is_image_file(string $path): bool {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif']);
}

// Handle Actions (Add, Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        // Add New Document / Image
        if ($action === 'add') {
            $title = trim($_POST['title'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

            if (empty($title) || empty($_FILES['document']['name'])) {
                set_flash('error', 'Please provide both title and document/image file.');
            } else {
                $file = $_FILES['document'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'webp', 'gif'];

                if (!in_array($ext, $allowed)) {
                    set_flash('error', 'Allowed formats: PDF, PNG, JPG, JPEG, WebP.');
                } elseif ($file['size'] > 25 * 1024 * 1024) {
                    set_flash('error', 'File size exceeds 25MB limit.');
                } else {
                    $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $isImg = in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif']);
                    
                    if ($isImg) {
                        $targetPathImg = IMAGES_DIR . '/' . $cleanName;
                        $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                        if (move_uploaded_file($file['tmp_name'], $targetPathImg)) {
                            @copy($targetPathImg, $targetPathDoc);
                            $sizeKb = round($file['size'] / 1024) . ' KB';
                            $fileUrl = "assets/images/" . $cleanName;

                            $ins = $db->prepare("INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES (:title, :fn, :url, :sz, :so)");
                            $ins->execute([
                                ':title' => $title,
                                ':fn'    => $cleanName,
                                ':url'   => $fileUrl,
                                ':sz'    => $sizeKb,
                                ':so'    => $sort
                            ]);
                            set_flash('success', "Image disclosure '{$title}' added successfully.");
                        } else {
                            set_flash('error', 'Failed to save uploaded image.');
                        }
                    } else {
                        $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                        if (move_uploaded_file($file['tmp_name'], $targetPathDoc)) {
                            $sizeKb = round($file['size'] / 1024) . ' KB';
                            $fileUrl = "assets/docs/" . $cleanName;

                            $ins = $db->prepare("INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES (:title, :fn, :url, :sz, :so)");
                            $ins->execute([
                                ':title' => $title,
                                ':fn'    => $cleanName,
                                ':url'   => $fileUrl,
                                ':sz'    => $sizeKb,
                                ':so'    => $sort
                            ]);
                            set_flash('success', "PDF disclosure '{$title}' added successfully.");
                        } else {
                            set_flash('error', 'Failed to save uploaded document.');
                        }
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/disclosures.php");
            exit;
        }

        // Edit & Replace Document / Image
        if ($action === 'edit') {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

            if ($id > 0 && !empty($title)) {
                $stmt = $db->prepare("SELECT * FROM mandatory_disclosures WHERE id = ?");
                $stmt->execute([$id]);
                $existing = $stmt->fetch();

                if ($existing) {
                    $fileName = $existing['file_name'];
                    $fileUrl = $existing['file_url'];
                    $fileSize = $existing['file_size'];

                    // Optional file replacement
                    if (!empty($_FILES['document']['name'])) {
                        $file = $_FILES['document'];
                        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'webp', 'gif'];

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
                            $isImg = in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'gif']);

                            if ($isImg) {
                                $targetPathImg = IMAGES_DIR . '/' . $cleanName;
                                $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                                if (move_uploaded_file($file['tmp_name'], $targetPathImg)) {
                                    @copy($targetPathImg, $targetPathDoc);
                                    $fileName = $cleanName;
                                    $fileUrl = "assets/images/" . $cleanName;
                                    $fileSize = round($file['size'] / 1024) . ' KB';
                                }
                            } else {
                                $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                                if (move_uploaded_file($file['tmp_name'], $targetPathDoc)) {
                                    $fileName = $cleanName;
                                    $fileUrl = "assets/docs/" . $cleanName;
                                    $fileSize = round($file['size'] / 1024) . ' KB';
                                }
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
                $stmt = $db->prepare("SELECT * FROM mandatory_disclosures WHERE id = ?");
                $stmt->execute([$id]);
                $doc = $stmt->fetch();
                if ($doc) {
                    $delStmt = $db->prepare("DELETE FROM mandatory_disclosures WHERE id = ?");
                    $delStmt->execute([$id]);
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
    $stmt = $db->prepare("SELECT * FROM mandatory_disclosures WHERE id = ?");
    $stmt->execute([$editId]);
    $editDoc = $stmt->fetch();
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
          <i class="fa-solid fa-pen-to-square me-1 text-primary"></i> Edit Disclosure
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
          <input type="text" name="title" class="form-control" value="<?= e($editDoc['title'] ?? '') ?>" placeholder="e.g. FEE STRUCTURE, FIRE SAFETY CERTIFICATE" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">
            <?= $editDoc ? 'Replace Document / Image (Optional)' : 'Upload Document / Image *' ?>
          </label>
          <input type="file" name="document" class="form-control" accept=".pdf,image/png,image/jpeg,image/webp,image/*" <?= $editDoc ? '' : 'required' ?>>
          <div class="form-text small text-muted">Accepted formats: PDF, PNG, JPG, JPEG, WebP (Max 25MB)</div>

          <?php if ($editDoc): 
            $isEditImg = is_image_file($editDoc['file_url']);
          ?>
            <div class="alert alert-light border mt-3 p-3 rounded-3 small">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-dark">Current Attached File:</span>
                <?php if ($isEditImg): ?>
                  <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold">
                    <i class="fa-solid fa-file-image me-1"></i> IMAGE
                  </span>
                <?php else: ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold">
                    <i class="fa-solid fa-file-pdf me-1"></i> PDF
                  </span>
                <?php endif; ?>
              </div>

              <div class="text-truncate text-muted mb-2">
                <strong>File:</strong> <?= e($editDoc['file_name']) ?> <span class="badge bg-light text-dark border ms-1"><?= e($editDoc['file_size']) ?></span>
              </div>

              <?php if ($isEditImg): ?>
                <div class="text-center p-2 bg-white rounded border my-2">
                  <a href="<?= asset_url($editDoc['file_url']) ?>" target="_blank" title="Click to view full image">
                    <img src="<?= asset_url($editDoc['file_url']) ?>" alt="Preview" class="img-fluid rounded" style="max-height: 140px; object-fit: contain;">
                  </a>
                </div>
              <?php endif; ?>

              <div class="mt-2 pt-2 border-top">
                <a href="<?= asset_url($editDoc['file_url']) ?>" target="_blank" class="fw-bold text-primary text-decoration-none d-inline-flex align-items-center gap-1">
                  <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Current Document in New Tab
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small">Display Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="<?= e($editDoc['sort_order'] ?? count($disclosures) + 1) ?>" min="0">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-danger flex-grow-1 py-2 fw-semibold" style="background: var(--admin-primary); border-color: var(--admin-primary);">
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
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
          <h5 class="fw-bold text-dark mb-0">Active Mandatory Disclosures (<?= count($disclosures) ?>)</h5>
          <span class="text-muted small">Synchronized with public Mandatory Disclosure section</span>
        </div>
        <a href="<?= url('/mandatory-disclosure/') ?>" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold">
          <i class="fa-solid fa-eye me-1"></i> View Public Page
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
          <thead class="table-light">
            <tr>
              <th style="width: 50px;">#</th>
              <th style="width: 70px;">Preview</th>
              <th style="width: 80px;">Type</th>
              <th>Document Title</th>
              <th>File Name &amp; Size</th>
              <th class="text-end" style="width: 120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($disclosures as $d): 
              $isImg = is_image_file($d['file_url']);
            ?>
              <tr class="<?= ($editDoc && $editDoc['id'] == $d['id']) ? 'table-warning' : '' ?>">
                <td class="fw-bold text-muted">#<?= $d['sort_order'] ?></td>
                <td>
                  <?php if ($isImg): ?>
                    <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="d-inline-block border rounded p-1 bg-white shadow-sm" title="Preview image in new tab">
                      <img src="<?= asset_url($d['file_url']) ?>" alt="<?= e($d['title']) ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; display: block;">
                    </a>
                  <?php else: ?>
                    <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="d-inline-flex align-items-center justify-content-center border rounded bg-danger-subtle text-danger shadow-sm text-decoration-none" style="width: 40px; height: 40px;" title="Open PDF">
                      <i class="fa-solid fa-file-pdf fa-lg"></i>
                    </a>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($isImg): ?>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle py-1 px-2 fw-semibold">
                      <i class="fa-solid fa-image me-1"></i> Image
                    </span>
                  <?php else: ?>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle py-1 px-2 fw-semibold">
                      <i class="fa-solid fa-file-pdf me-1"></i> PDF
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="fw-bold text-dark text-decoration-none">
                    <?= e($d['title']) ?>
                  </a>
                </td>
                <td>
                  <div class="text-truncate text-muted small" style="max-width: 220px;" title="<?= e($d['file_name']) ?>">
                    <?= e($d['file_name']) ?>
                  </div>
                  <span class="badge bg-light text-dark border small mt-1"><?= e($d['file_size']) ?></span>
                </td>
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
