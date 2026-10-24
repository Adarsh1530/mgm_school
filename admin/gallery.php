<?php
/**
 * Admin Gallery Management
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'gallery';
$adminTitle = 'Gallery Photos Management';

$db = getDB();

// Handle Actions (Add, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            $title = trim($_POST['title'] ?? '');
            $category = trim($_POST['category'] ?? 'Events');
            $caption = trim($_POST['caption'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

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
                    $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $fileName = time() . '_' . $cleanName;
                    $targetPath = IMAGES_DIR . '/' . $fileName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $ins = $db->prepare("INSERT INTO gallery (title, caption, image_path, category, sort_order) VALUES (:title, :cap, :ip, :cat, :so)");
                        $ins->execute([
                            ':title' => $title,
                            ':cap'   => $caption,
                            ':ip'    => 'assets/images/' . $fileName,
                            ':cat'   => $category,
                            ':so'    => $sort
                        ]);
                        log_audit("Gallery Photo Added", "Uploaded photo: {$title} ({$fileName})");
                        set_flash('success', "Photo '{$title}' added to gallery.");
                    } else {
                        set_flash('error', 'Failed to save uploaded photo.');
                    }
                }
            }
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $photo = $db->query("SELECT * FROM gallery WHERE id = {$id}")->fetch();
                if ($photo) {
                    $db->exec("DELETE FROM gallery WHERE id = {$id}");
                    log_audit("Gallery Photo Deleted", "Deleted photo ID {$id}: {$photo['title']}");
                    set_flash('success', "Photo '{$photo['title']}' deleted.");
                }
            }
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }
    }
}

$photos = $db->query("SELECT * FROM gallery ORDER BY sort_order ASC, id ASC")->fetchAll();

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
          <input type="text" name="title" class="form-control" placeholder="e.g. Annual Sports Day" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Category</label>
          <select name="category" class="form-control">
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

        <div class="mb-3">
          <label class="form-label fw-semibold small">Upload Image *</label>
          <input type="file" name="photo" class="form-control" accept="image/*" required>
          <div class="form-text small">Accepted formats: JPG, PNG, WebP</div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="<?= count($photos) + 1 ?>" min="0">
        </div>

        <button type="submit" class="btn-admin-primary w-100 py-2">
          <i class="fa-solid fa-upload me-1"></i> Upload to Gallery
        </button>
      </form>
    </div>
  </div>

  <!-- Right Column: Gallery Photos Table -->
  <div class="col-lg-8">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Gallery Items (<?= count($photos) ?>)</h5>
        <a href="<?= url('/gallery/') ?>" target="_blank" class="btn btn-outline-info btn-sm">
          <i class="fa-solid fa-eye me-1"></i> View Live Gallery
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
          <thead class="table-light">
            <tr>
              <th>Thumb</th>
              <th>Order</th>
              <th>Title</th>
              <th>Category</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($photos as $p): ?>
              <tr>
                <td>
                  <img src="<?= asset_url($p['image_path']) ?>" alt="" style="width: 50px; height: 38px; object-fit: cover; border-radius: 4px;">
                </td>
                <td class="fw-bold"><?= $p['sort_order'] ?></td>
                <td class="fw-bold text-dark"><?= e($p['title']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= e($p['category']) ?></span></td>
                <td class="text-end">
                  <a href="<?= asset_url($p['image_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View Full Image">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </a>
                  <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this gallery item?');">
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
