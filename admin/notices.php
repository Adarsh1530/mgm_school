<?php
/**
 * Admin Notice Management System
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'notices';
$adminTitle = 'Notice Management System';

$db = getDB();

// Handle Actions (Add, Edit, Delete, Toggle)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        // Add Notice
        if ($action === 'add') {
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? 'General');
            $badgeColor = trim($_POST['badge_color'] ?? 'primary');
            $pubDate = !empty($_POST['publish_date']) ? $_POST['publish_date'] : date('Y-m-d');
            $displayDate = date('F j, Y', strtotime($pubDate));
            $summary = trim($_POST['summary'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $isTicker = isset($_POST['is_ticker']) ? 1 : 0;
            $sortOrder = (int)($_POST['sort_order'] ?? 0);

            // Generate slug
            $slugBase = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
            $slug = $slugBase ?: 'notice-' . time();

            if (empty($title)) {
                set_flash('error', 'Notice title is required.');
            } else {
                $pdfUrl = null;
                $imageUrl = null;

                // Handle file upload (PDF or Image)
                if (!empty($_FILES['attachment']['name'])) {
                    $file = $_FILES['attachment'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                    $maxSize = 10 * 1024 * 1024; // 10 MB

                    if (!in_array($ext, $allowed)) {
                        set_flash('error', "Invalid file format for attachment '{$file['name']}'. Only JPEG, PNG, and PDF files are allowed.");
                        header("Location: " . ADMIN_URL . "/notices.php");
                        exit;
                    } elseif ($file['size'] > $maxSize) {
                        $sizeMb = round($file['size'] / (1024 * 1024), 2);
                        set_flash('error', "Attachment '{$file['name']}' exceeds the 10 MB limit ({$sizeMb} MB). Please upload a file up to 10 MB.");
                        header("Location: " . ADMIN_URL . "/notices.php");
                        exit;
                    } else {
                        if (!is_dir(DOCS_DIR)) @mkdir(DOCS_DIR, 0777, true);
                        if (!is_dir(IMAGES_DIR)) @mkdir(IMAGES_DIR, 0777, true);
                        $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);

                        if ($ext === 'pdf') {
                            $targetPath = DOCS_DIR . '/' . $cleanName;
                            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                                $pdfUrl = 'assets/docs/' . $cleanName;
                            }
                        } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                            $targetPath = IMAGES_DIR . '/' . $cleanName;
                            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                                $imageUrl = 'assets/images/' . $cleanName;
                            }
                        }
                    }
                }

                $stmt = $db->prepare("INSERT INTO notices (title, slug, category, badge_color, publish_date, display_date, summary, content, image_url, pdf_url, is_active, is_ticker, sort_order) VALUES (:title, :slug, :cat, :badge, :pdate, :ddate, :summary, :content, :img, :pdf, :active, :ticker, :sort)");
                $stmt->execute([
                    ':title'    => $title,
                    ':slug'     => $slug,
                    ':cat'      => $category,
                    ':badge'    => $badgeColor,
                    ':pdate'    => $pubDate,
                    ':ddate'    => $displayDate,
                    ':summary'  => $summary ?: $title,
                    ':content'  => $content ?: $summary ?: $title,
                    ':img'      => $imageUrl,
                    ':pdf'      => $pdfUrl,
                    ':active'   => $isActive,
                    ':ticker'   => $isTicker,
                    ':sort'     => $sortOrder
                ]);

                set_flash('success', "Notice '{$title}' added successfully.");
            }
            header("Location: " . ADMIN_URL . "/notices.php");
            exit;
        }

        // Edit Notice
        if ($action === 'edit') {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? 'General');
            $badgeColor = trim($_POST['badge_color'] ?? 'primary');
            $pubDate = !empty($_POST['publish_date']) ? $_POST['publish_date'] : date('Y-m-d');
            $displayDate = date('F j, Y', strtotime($pubDate));
            $summary = trim($_POST['summary'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $isTicker = isset($_POST['is_ticker']) ? 1 : 0;
            $sortOrder = (int)($_POST['sort_order'] ?? 0);

            if ($id > 0 && !empty($title)) {
                $existing = $db->query("SELECT * FROM notices WHERE id = {$id}")->fetch();
                $pdfUrl = $existing['pdf_url'];
                $imageUrl = $existing['image_url'];

                // Handle file upload if provided
                if (!empty($_FILES['attachment']['name'])) {
                    $file = $_FILES['attachment'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                    $maxSize = 10 * 1024 * 1024; // 10 MB

                    if (!in_array($ext, $allowed)) {
                        set_flash('error', "Invalid file format for attachment '{$file['name']}'. Only JPEG, PNG, and PDF files are allowed.");
                        header("Location: " . ADMIN_URL . "/notices.php?edit={$id}");
                        exit;
                    } elseif ($file['size'] > $maxSize) {
                        $sizeMb = round($file['size'] / (1024 * 1024), 2);
                        set_flash('error', "Attachment '{$file['name']}' exceeds the 10 MB limit ({$sizeMb} MB). Please upload a file up to 10 MB.");
                        header("Location: " . ADMIN_URL . "/notices.php?edit={$id}");
                        exit;
                    } else {
                        if (!is_dir(DOCS_DIR)) @mkdir(DOCS_DIR, 0777, true);
                        if (!is_dir(IMAGES_DIR)) @mkdir(IMAGES_DIR, 0777, true);
                        $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);

                        if ($ext === 'pdf') {
                            $targetPath = DOCS_DIR . '/' . $cleanName;
                            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                                $pdfUrl = 'assets/docs/' . $cleanName;
                            }
                        } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                            $targetPath = IMAGES_DIR . '/' . $cleanName;
                            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                                $imageUrl = 'assets/images/' . $cleanName;
                            }
                        }
                    }
                }

                $stmt = $db->prepare("UPDATE notices SET title = :title, category = :cat, badge_color = :badge, publish_date = :pdate, display_date = :ddate, summary = :summary, content = :content, image_url = :img, pdf_url = :pdf, is_active = :active, is_ticker = :ticker, sort_order = :sort WHERE id = :id");
                $stmt->execute([
                    ':title'    => $title,
                    ':cat'      => $category,
                    ':badge'    => $badgeColor,
                    ':pdate'    => $pubDate,
                    ':ddate'    => $displayDate,
                    ':summary'  => $summary ?: $title,
                    ':content'  => $content ?: $summary ?: $title,
                    ':img'      => $imageUrl,
                    ':pdf'      => $pdfUrl,
                    ':active'   => $isActive,
                    ':ticker'   => $isTicker,
                    ':sort'     => $sortOrder,
                    ':id'       => $id
                ]);

                set_flash('success', "Notice '{$title}' updated successfully.");
            }
            header("Location: " . ADMIN_URL . "/notices.php");
            exit;
        }

        // Toggle Status
        if ($action === 'toggle_status') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $db->exec("UPDATE notices SET is_active = IF(is_active = 1, 0, 1) WHERE id = {$id}");
                set_flash('success', "Notice status updated.");
            }
            header("Location: " . ADMIN_URL . "/notices.php");
            exit;
        }

        // Delete Notice
        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $notice = $db->query("SELECT * FROM notices WHERE id = {$id}")->fetch();
                if ($notice) {
                    $db->exec("DELETE FROM notices WHERE id = {$id}");
                    set_flash('success', "Notice '{$notice['title']}' deleted.");
                }
            }
            header("Location: " . ADMIN_URL . "/notices.php");
            exit;
        }
    }
}

// Check if Editing a specific notice
$editNotice = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $editNotice = $db->query("SELECT * FROM notices WHERE id = {$editId}")->fetch();
}

$notices = $db->query("SELECT * FROM notices ORDER BY sort_order ASC, publish_date DESC")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<div class="row g-4">
  
  <!-- Left Column: Add / Edit Notice Form -->
  <div class="col-lg-5">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <h5 class="fw-bold text-dark mb-3">
        <?php if ($editNotice): ?>
          <i class="fa-solid fa-pen-to-square me-1 text-primary"></i> Edit Notice #<?= $editNotice['id'] ?>
        <?php else: ?>
          <i class="fa-solid fa-plus-circle me-1 text-danger"></i> Add New Notice
        <?php endif; ?>
      </h5>

      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $editNotice ? 'edit' : 'add' ?>">
        <?php if ($editNotice): ?>
          <input type="hidden" name="id" value="<?= $editNotice['id'] ?>">
        <?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold small">Notice Title *</label>
          <input type="text" name="title" class="form-control" value="<?= e($editNotice['title'] ?? '') ?>" placeholder="e.g. Admissions Open for Academic Year 2025-26" required>
        </div>

        <div class="row g-2 mb-3">
          <div class="col-sm-6">
            <label class="form-label fw-semibold small">Category</label>
            <select name="category" class="form-select">
              <?php 
              $categories = ['General', 'Admission', 'Academic', 'Achievement', 'Event', 'Sports', 'Circular', 'Exam'];
              foreach ($categories as $cat): 
              ?>
                <option value="<?= $cat ?>" <?= ($editNotice['category'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-sm-6">
            <label class="form-label fw-semibold small">Badge Color</label>
            <select name="badge_color" class="form-select">
              <?php 
              $colors = ['primary' => 'Blue (Primary)', 'danger' => 'Red (Danger)', 'success' => 'Green (Success)', 'warning' => 'Amber (Warning)', 'info' => 'Teal (Info)', 'secondary' => 'Gray (Secondary)'];
              foreach ($colors as $colKey => $colLabel): 
              ?>
                <option value="<?= $colKey ?>" <?= ($editNotice['badge_color'] ?? '') === $colKey ? 'selected' : '' ?>><?= $colLabel ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="row g-2 mb-3">
          <div class="col-sm-6">
            <label class="form-label fw-semibold small">Publish Date</label>
            <input type="date" name="publish_date" class="form-control" value="<?= e($editNotice['publish_date'] ?? date('Y-m-d')) ?>">
          </div>
          <div class="col-sm-6">
            <label class="form-label fw-semibold small">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="<?= e($editNotice['sort_order'] ?? count($notices) + 1) ?>" min="0">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Brief Summary / Headline</label>
          <textarea name="summary" class="form-control" rows="2" placeholder="Short description for ticker & preview cards..."><?= e($editNotice['summary'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Full Notice Content</label>
          <textarea name="content" class="form-control" rows="4" placeholder="Detailed circular content..."><?= e($editNotice['content'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Upload Attachment (JPEG, PNG, or PDF &mdash; Max 10 MB)</label>
          <input type="file" name="attachment" id="noticeAttachmentInput" class="form-control" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf">
          <div class="form-text small text-muted">Allowed formats: <strong>JPEG, PNG, PDF</strong> (Max <strong>10 MB</strong>).</div>
          <?php if (!empty($editNotice['pdf_url'])): ?>
            <div class="form-text mt-1 text-success">
              <i class="fa-solid fa-file-pdf me-1"></i> Current PDF: <a href="<?= asset_url($editNotice['pdf_url']) ?>" target="_blank" class="fw-semibold">View File</a> (upload new to replace)
            </div>
          <?php elseif (!empty($editNotice['image_url'])): ?>
            <div class="form-text mt-1 text-primary">
              <i class="fa-solid fa-image me-1"></i> Current Photo: <a href="<?= asset_url($editNotice['image_url']) ?>" target="_blank" class="fw-semibold">View Image</a> (upload new to replace)
            </div>
          <?php endif; ?>
        </div>

        <div class="mb-4 d-flex gap-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" <?= (!isset($editNotice) || !empty($editNotice['is_active'])) ? 'checked' : '' ?>>
            <label class="form-check-label fw-semibold small" for="isActiveCheck">Active / Published</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_ticker" id="isTickerCheck" value="1" <?= (!isset($editNotice) || !empty($editNotice['is_ticker'])) ? 'checked' : '' ?>>
            <label class="form-check-label fw-semibold small" for="isTickerCheck">Show in Top Ticker</label>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn-admin-primary flex-grow-1 py-2">
            <i class="fa-solid <?= $editNotice ? 'fa-floppy-disk' : 'fa-bullhorn' ?> me-1"></i>
            <?= $editNotice ? 'Save Changes' : 'Publish Notice' ?>
          </button>
          <?php if ($editNotice): ?>
            <a href="<?= ADMIN_URL ?>/notices.php" class="btn btn-outline-secondary py-2">Cancel</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Right Column: Notice List Table -->
  <div class="col-lg-7">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Active Notices & Circulars (<?= count($notices) ?>)</h5>
        <a href="<?= url('/notices/') ?>" target="_blank" class="btn btn-outline-info btn-sm">
          <i class="fa-solid fa-eye me-1"></i> View Live Notices
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
          <thead class="table-light">
            <tr>
              <th style="width: 50px;">Order</th>
              <th>Notice Details</th>
              <th>Date</th>
              <th>Status</th>
              <th class="text-end" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($notices as $n): ?>
              <tr class="<?= ($editNotice && $editNotice['id'] == $n['id']) ? 'table-warning' : '' ?>">
                <td class="fw-bold text-muted">#<?= $n['sort_order'] ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= e($n['title']) ?></div>
                  <div class="d-flex align-items-center gap-2 mt-1">
                    <span class="badge bg-<?= e($n['badge_color'] ?: 'primary') ?> bg-opacity-10 text-<?= e($n['badge_color'] ?: 'primary') ?> border border-<?= e($n['badge_color'] ?: 'primary') ?> border-opacity-25" style="font-size: 11px;">
                      <?= e($n['category']) ?>
                    </span>
                    <?php if ($n['is_ticker']): ?>
                      <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25" style="font-size: 10px;">Ticker</span>
                    <?php endif; ?>
                    <?php if ($n['pdf_url']): ?>
                      <a href="<?= asset_url($n['pdf_url']) ?>" target="_blank" class="text-danger small" title="PDF Attached"><i class="fa-solid fa-file-pdf"></i></a>
                    <?php elseif ($n['image_url']): ?>
                      <a href="<?= asset_url($n['image_url']) ?>" target="_blank" class="text-primary small" title="Photo Attached"><i class="fa-solid fa-image"></i></a>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="text-muted small whitespace-nowrap"><?= date('M j, Y', strtotime($n['publish_date'])) ?></td>
                <td>
                  <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="action" value="toggle_status">
                    <input type="hidden" name="id" value="<?= $n['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm badge <?= $n['is_active'] ? 'bg-success' : 'bg-secondary' ?> border-0" title="Click to toggle status">
                      <?= $n['is_active'] ? 'Active' : 'Draft' ?>
                    </button>
                  </form>
                </td>
                <td class="text-end">
                  <a href="<?= ADMIN_URL ?>/notices.php?edit=<?= $n['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Edit Notice">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Delete this notice?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $n['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Notice">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('noticeAttachmentInput');
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
