<?php
/**
 * Admin Gallery Management & Reordering System
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'gallery';
$adminTitle = 'Gallery Photos Management';

$db = getDB();

// Helper to normalize all gallery positions to consecutive 1..N
function normalize_gallery_order(PDO $db): void {
    $rows = $db->query("SELECT id FROM gallery ORDER BY sort_order ASC, id ASC")->fetchAll(PDO::FETCH_COLUMN);
    $stmt = $db->prepare("UPDATE gallery SET sort_order = :ord WHERE id = :id");
    $pos = 1;
    foreach ($rows as $id) {
        $stmt->execute([':ord' => $pos, ':id' => $id]);
        $pos++;
    }
}

// Handle Actions (Add, Reorder, Move Step, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        // Add Photo
        if ($action === 'add') {
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? 'Events');
            $caption = trim($_POST['caption'] ?? '');

            if (empty($title) || empty($_FILES['photo']['name'])) {
                set_flash('error', 'Please provide photo title and image file.');
            } else {
                $file = $_FILES['photo'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($ext, $allowed)) {
                    set_flash('error', 'Only JPG, PNG, and WebP images are allowed.');
                } elseif ($file['size'] > 15 * 1024 * 1024) {
                    set_flash('error', 'Image size exceeds 15MB limit.');
                } else {
                    $cleanName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $targetPath = IMAGES_DIR . '/' . $cleanName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $maxOrder = (int)$db->query("SELECT COALESCE(MAX(sort_order), 0) FROM gallery")->fetchColumn();
                        $ins = $db->prepare("INSERT INTO gallery (title, caption, image_path, category, sort_order) VALUES (:title, :cap, :ip, :cat, :so)");
                        $ins->execute([
                            ':title' => $title,
                            ':cap'   => $caption,
                            ':ip'    => 'assets/images/' . $cleanName,
                            ':cat'   => $category,
                            ':so'    => $maxOrder + 1
                        ]);
                        normalize_gallery_order($db);
                        set_flash('success', "Photo '{$title}' added to gallery.");
                    } else {
                        set_flash('error', 'Failed to save uploaded photo.');
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        // Direct Rank Reordering (e.g. 1st position to 6th position, others shift smoothly)
        if ($action === 'reorder') {
            $id = (int)($_POST['id'] ?? 0);
            $newPos = (int)($_POST['new_position'] ?? 0);

            if ($id > 0 && $newPos > 0) {
                // First ensure positions are clean 1..N
                normalize_gallery_order($db);

                $current = $db->query("SELECT * FROM gallery WHERE id = {$id}")->fetch();
                $totalPhotos = (int)$db->query("SELECT COUNT(*) FROM gallery")->fetchColumn();

                if ($current) {
                    $oldPos = (int)$current['sort_order'];
                    if ($newPos > $totalPhotos) $newPos = $totalPhotos;
                    if ($newPos < 1) $newPos = 1;

                    if ($newPos !== $oldPos) {
                        if ($newPos > $oldPos) {
                            // Moving DOWN: items between oldPos + 1 and newPos shift UP by 1
                            $db->exec("UPDATE gallery SET sort_order = sort_order - 1 WHERE sort_order > {$oldPos} AND sort_order <= {$newPos}");
                        } else {
                            // Moving UP: items between newPos and oldPos - 1 shift DOWN by 1
                            $db->exec("UPDATE gallery SET sort_order = sort_order + 1 WHERE sort_order >= {$newPos} AND sort_order < {$oldPos}");
                        }

                        // Place target at newPos
                        $db->exec("UPDATE gallery SET sort_order = {$newPos} WHERE id = {$id}");

                        // Re-normalize to guarantee perfect sequential order
                        normalize_gallery_order($db);

                        set_flash('success', "Photo '{$current['title']}' moved from position #{$oldPos} to #{$newPos}. Other photos shifted accordingly.");
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        // Move 1 Step (Up or Down)
        if ($action === 'move_step') {
            $id = (int)($_POST['id'] ?? 0);
            $direction = $_POST['direction'] ?? '';

            if ($id > 0 && ($direction === 'up' || $direction === 'down')) {
                normalize_gallery_order($db);
                $current = $db->query("SELECT * FROM gallery WHERE id = {$id}")->fetch();
                if ($current) {
                    $currentOrder = (int)$current['sort_order'];
                    $targetOrder = ($direction === 'up') ? $currentOrder - 1 : $currentOrder + 1;

                    // Find neighbor photo
                    $neighbor = $db->query("SELECT id FROM gallery WHERE sort_order = {$targetOrder}")->fetch();
                    if ($neighbor) {
                        $db->exec("UPDATE gallery SET sort_order = {$currentOrder} WHERE id = {$neighbor['id']}");
                        $db->exec("UPDATE gallery SET sort_order = {$targetOrder} WHERE id = {$id}");
                        normalize_gallery_order($db);
                        set_flash('success', "Photo order updated.");
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        // Delete Photo
        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $photo = $db->query("SELECT * FROM gallery WHERE id = {$id}")->fetch();
                if ($photo) {
                    $db->exec("DELETE FROM gallery WHERE id = {$id}");
                    normalize_gallery_order($db);
                    set_flash('success', "Photo '{$photo['title']}' deleted.");
                }
            }
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }
    }
}

// Initial normalization if needed so consecutive ranks always show
normalize_gallery_order($db);

$photos = $db->query("SELECT * FROM gallery ORDER BY sort_order ASC, id ASC")->fetchAll();
$totalCount = count($photos);

require_once __DIR__ . '/header.php';
?>

<div class="row g-4">
  
  <!-- Left Column: Add Photo Form -->
  <div class="col-lg-4">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle me-1 text-danger"></i> Add Gallery Image</h5>

      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold small">Photo Title *</label>
          <input type="text" name="title" class="form-control" placeholder="e.g. Annual Sports Day & Aquatic Meet" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Category</label>
          <select name="category" class="form-select">
            <option value="Events">School Events</option>
            <option value="Academics">Academics & Labs</option>
            <option value="Sports">Sports & Swimming</option>
            <option value="Campus">Campus Infrastructure</option>
            <option value="Arts">Cultural & Arts</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Caption / Description</label>
          <input type="text" name="caption" class="form-control" placeholder="Brief description...">
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small">Upload Image *</label>
          <input type="file" name="photo" class="form-control" accept="image/*" required>
          <div class="form-text small">Accepted formats: JPG, PNG, WebP (Max 15MB)</div>
        </div>

        <button type="submit" class="btn-admin-primary w-100 py-2">
          <i class="fa-solid fa-upload me-1"></i> Upload to Gallery
        </button>
      </form>
    </div>
  </div>

  <!-- Right Column: Gallery Photos Table with Direct Reordering -->
  <div class="col-lg-8">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="fw-bold text-dark mb-0">Gallery Items (<?= $totalCount ?>)</h5>
          <div class="text-muted small">Change position number to reorder photo (other photos shift automatically).</div>
        </div>
        <a href="<?= url('/gallery/') ?>" target="_blank" class="btn btn-outline-info btn-sm">
          <i class="fa-solid fa-eye me-1"></i> View Live Gallery
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
          <thead class="table-light">
            <tr>
              <th style="width: 140px;">Position / Order</th>
              <th style="width: 70px;">Thumb</th>
              <th>Photo Title & Info</th>
              <th>Category</th>
              <th class="text-end" style="width: 110px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($photos as $idx => $p): ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-1">
                    <!-- Direct Position Reorder Form -->
                    <form method="POST" action="" class="d-inline-flex align-items-center gap-1">
                      <input type="hidden" name="action" value="reorder">
                      <input type="hidden" name="id" value="<?= $p['id'] ?>">
                      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                      <select name="new_position" class="form-select form-select-sm py-1 px-2 fw-bold text-dark" style="width: 68px;" onchange="this.form.submit()">
                        <?php for ($i = 1; $i <= $totalCount; $i++): ?>
                          <option value="<?= $i ?>" <?= $p['sort_order'] == $i ? 'selected' : '' ?>>
                            #<?= $i ?>
                          </option>
                        <?php endfor; ?>
                      </select>
                    </form>

                    <!-- Quick Step Arrows -->
                    <div class="btn-group-vertical btn-group-sm">
                      <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="action" value="move_step">
                        <input type="hidden" name="direction" value="up">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <button type="submit" class="btn btn-light btn-sm py-0 px-1 border" <?= $p['sort_order'] <= 1 ? 'disabled' : '' ?> title="Move Up">
                          <i class="fa-solid fa-chevron-up" style="font-size: 9px;"></i>
                        </button>
                      </form>
                      <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="action" value="move_step">
                        <input type="hidden" name="direction" value="down">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <button type="submit" class="btn btn-light btn-sm py-0 px-1 border" <?= $p['sort_order'] >= $totalCount ? 'disabled' : '' ?> title="Move Down">
                          <i class="fa-solid fa-chevron-down" style="font-size: 9px;"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
                <td>
                  <img src="<?= asset_url($p['image_path']) ?>" alt="<?= e($p['title']) ?>" class="rounded border" style="width: 52px; height: 52px; object-fit: cover;">
                </td>
                <td>
                  <div class="fw-bold text-dark"><?= e($p['title']) ?></div>
                  <?php if (!empty($p['caption'])): ?>
                    <div class="text-muted small text-truncate" style="max-width: 250px;"><?= e($p['caption']) ?></div>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                    <?= e($p['category']) ?>
                  </span>
                </td>
                <td class="text-end">
                  <a href="<?= asset_url($p['image_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View Full Image">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
                  <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Photo">
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
