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
    return in_array($ext, ['png', 'jpg', 'jpeg']);
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
                $allowed = ['pdf', 'png', 'jpg', 'jpeg'];
                $maxSize = 10 * 1024 * 1024; // 10 MB

                if (!in_array($ext, $allowed)) {
                    set_flash('error', "Invalid file format for '{$file['name']}'. Only JPEG, PNG, and PDF files are allowed.");
                    header("Location: " . ADMIN_URL . "/disclosures.php");
                    exit;
                } elseif ($file['size'] > $maxSize) {
                    $sizeMb = round($file['size'] / (1024 * 1024), 2);
                    set_flash('error', "File '{$file['name']}' exceeds the 10 MB limit ({$sizeMb} MB). Please upload a file up to 10 MB.");
                    header("Location: " . ADMIN_URL . "/disclosures.php");
                    exit;
                } else {
                    $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $isImg = in_array($ext, ['png', 'jpg', 'jpeg']);

                    if (!is_dir(DOCS_DIR)) @mkdir(DOCS_DIR, 0777, true);
                    if (!is_dir(IMAGES_DIR)) @mkdir(IMAGES_DIR, 0777, true);

                    if ($file['size'] >= 1048576) {
                        $sizeFormatted = round($file['size'] / 1048576, 1) . ' MB';
                    } else {
                        $sizeFormatted = max(1, round($file['size'] / 1024)) . ' KB';
                    }
                    
                    if ($isImg) {
                        $targetPathImg = IMAGES_DIR . '/' . $cleanName;
                        $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                        if (move_uploaded_file($file['tmp_name'], $targetPathImg)) {
                            @copy($targetPathImg, $targetPathDoc);
                            $fileUrl = "assets/images/" . $cleanName;

                            $ins = $db->prepare("INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES (:title, :fn, :url, :sz, :so)");
                            $ins->execute([
                                ':title' => $title,
                                ':fn'    => $cleanName,
                                ':url'   => $fileUrl,
                                ':sz'    => $sizeFormatted,
                                ':so'    => $sort
                            ]);
                            set_flash('success', "Image disclosure '{$title}' added successfully.");
                        } else {
                            set_flash('error', 'Failed to save uploaded image. Check directory permissions.');
                        }
                    } else {
                        $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                        $targetPathImg = IMAGES_DIR . '/' . $cleanName;
                        if (move_uploaded_file($file['tmp_name'], $targetPathDoc)) {
                            @copy($targetPathDoc, $targetPathImg);
                            $fileUrl = "assets/docs/" . $cleanName;

                            $ins = $db->prepare("INSERT INTO mandatory_disclosures (title, file_name, file_url, file_size, sort_order) VALUES (:title, :fn, :url, :sz, :so)");
                            $ins->execute([
                                ':title' => $title,
                                ':fn'    => $cleanName,
                                ':url'   => $fileUrl,
                                ':sz'    => $sizeFormatted,
                                ':so'    => $sort
                            ]);
                            set_flash('success', "PDF disclosure '{$title}' added successfully.");
                        } else {
                            set_flash('error', 'Failed to save uploaded document. Check directory permissions.');
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
                        $allowed = ['pdf', 'png', 'jpg', 'jpeg'];
                        $maxSize = 10 * 1024 * 1024; // 10 MB

                        if (!in_array($ext, $allowed)) {
                            set_flash('error', "Invalid file format for '{$file['name']}'. Only JPEG, PNG, and PDF files are allowed.");
                            header("Location: " . ADMIN_URL . "/disclosures.php?edit={$id}");
                            exit;
                        } elseif ($file['size'] > $maxSize) {
                            $sizeMb = round($file['size'] / (1024 * 1024), 2);
                            set_flash('error', "File '{$file['name']}' exceeds the 10 MB limit ({$sizeMb} MB). Please upload a file up to 10 MB.");
                            header("Location: " . ADMIN_URL . "/disclosures.php?edit={$id}");
                            exit;
                        } else {
                            if (!is_dir(DOCS_DIR)) @mkdir(DOCS_DIR, 0777, true);
                            if (!is_dir(IMAGES_DIR)) @mkdir(IMAGES_DIR, 0777, true);

                            $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                            $isImg = in_array($ext, ['png', 'jpg', 'jpeg']);

                            if ($file['size'] >= 1048576) {
                                $sizeFormatted = round($file['size'] / 1048576, 1) . ' MB';
                            } else {
                                $sizeFormatted = max(1, round($file['size'] / 1024)) . ' KB';
                            }

                            if ($isImg) {
                                $targetPathImg = IMAGES_DIR . '/' . $cleanName;
                                $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                                if (move_uploaded_file($file['tmp_name'], $targetPathImg)) {
                                    @copy($targetPathImg, $targetPathDoc);
                                    $fileName = $cleanName;
                                    $fileUrl = "assets/images/" . $cleanName;
                                    $fileSize = $sizeFormatted;
                                }
                            } else {
                                $targetPathDoc = DOCS_DIR . '/' . $cleanName;
                                $targetPathImg = IMAGES_DIR . '/' . $cleanName;
                                if (move_uploaded_file($file['tmp_name'], $targetPathDoc)) {
                                    @copy($targetPathDoc, $targetPathImg);
                                    $fileName = $cleanName;
                                    $fileUrl = "assets/docs/" . $cleanName;
                                    $fileSize = $sizeFormatted;
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
            <?= $editDoc ? 'Replace Document / Image (Optional &mdash; Max 10 MB)' : 'Upload Document or Image (Max 10 MB) *' ?>
          </label>
          <input type="file" name="document" id="disclosureFileInput" class="form-control" accept=".pdf,.png,.jpg,.jpeg,image/jpeg,image/png,application/pdf" <?= $editDoc ? '' : 'required' ?>>
          <div class="form-text small text-muted">
            <i class="fa-solid fa-circle-info me-1 text-primary"></i> Accepted formats: <strong>JPEG, PNG, PDF</strong> (Max <strong>10 MB</strong>).
          </div>

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
            <?= $editDoc ? 'Save Updates' : 'Upload Disclosure' ?>
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
              <th style="width: 45px;" class="text-center">#</th>
              <th style="width: 65px;" class="text-center">Preview</th>
              <th>Document Title</th>
              <th>File Name &amp; Size</th>
              <th class="text-end" style="width: 125px; min-width: 125px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($disclosures as $d): 
              $isImg = is_image_file($d['file_url']);
            ?>
              <tr class="<?= ($editDoc && $editDoc['id'] == $d['id']) ? 'table-warning' : '' ?>">
                <td class="text-center fw-bold text-muted"><?= $d['sort_order'] ?></td>
                <td class="text-center">
                  <?php if ($isImg): ?>
                    <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="d-inline-block border rounded p-1 bg-white shadow-sm" title="Preview image in new tab">
                      <img src="<?= asset_url($d['file_url']) ?>" alt="<?= e($d['title']) ?>" style="width: 38px; height: 38px; object-fit: cover; border-radius: 4px; display: block;">
                    </a>
                  <?php else: ?>
                    <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="d-inline-flex align-items-center justify-content-center border rounded bg-danger-subtle text-danger shadow-sm text-decoration-none" style="width: 38px; height: 38px;" title="Open PDF in new tab">
                      <i class="fa-solid fa-file-pdf fa-lg"></i>
                    </a>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="fw-bold text-dark text-decoration-none d-block">
                    <?= e($d['title']) ?>
                  </a>
                </td>
                <td>
                  <div class="text-truncate text-muted small" style="max-width: 250px;" title="<?= e($d['file_name']) ?>">
                    <?= e($d['file_name']) ?>
                  </div>
                  <span class="badge bg-light text-dark border small mt-1"><?= e($d['file_size']) ?></span>
                </td>
                <td class="text-end" style="white-space: nowrap;">
                  <div class="d-inline-flex align-items-center justify-content-end gap-1 flex-nowrap">
                    <a href="<?= asset_url($d['file_url']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="View File">
                      <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <a href="<?= ADMIN_URL ?>/disclosures.php?edit=<?= $d['id'] ?>" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="Edit &amp; Replace">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form method="POST" action="" class="d-inline-block m-0 p-0" onsubmit="return confirm('Are you sure you want to delete this disclosure document?');">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= $d['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('disclosureFileInput');
  if (fileInput) {
    fileInput.addEventListener('change', function() {
      if (!this.files || !this.files[0]) return;
      const file = this.files[0];
      const maxBytes = 10 * 1024 * 1024; // 10MB
      const allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
      const ext = file.name.split('.').pop().toLowerCase();
      
      if (!allowedExts.includes(ext)) {
        alert('Invalid file format ("' + file.name + '"). Only JPEG, PNG, and PDF files are allowed.');
        this.value = '';
        return;
      }
      if (file.size > maxBytes) {
        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        alert('File size exceeds the 10 MB limit (Selected: ' + sizeMb + ' MB). Please choose a file up to 10 MB.');
        this.value = '';
        return;
      }
    });
  }
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
