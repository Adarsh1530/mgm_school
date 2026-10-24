<?php
/**
 * Admin Page Management
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'pages';
$adminTitle = 'Manage Pages';

$db = getDB();
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$editPage = null;

if ($editId > 0) {
    $stmt = $db->prepare("SELECT * FROM pages WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $editId]);
    $editPage = $stmt->fetch();
}

// Handle Form Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_page') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $breadcrumb = trim($_POST['breadcrumb_title'] ?? '');
        $metaDesc = trim($_POST['meta_description'] ?? '');
        $content = $_POST['content_html'] ?? '';
        $isPublished = isset($_POST['is_published']) ? 1 : 0;

        if ($id > 0 && !empty($title)) {
            $upd = $db->prepare("UPDATE pages SET title = :title, breadcrumb_title = :bc, meta_description = :meta, content_html = :content, is_published = :pub WHERE id = :id");
            $upd->execute([
                ':title'   => $title,
                ':bc'      => $breadcrumb,
                ':meta'    => $metaDesc,
                ':content' => $content,
                ':pub'     => $isPublished,
                ':id'      => $id
            ]);
            log_audit("Page Updated", "Page ID {$id} ({$title}) was modified.");
            set_flash('success', "Page '{$title}' updated successfully.");
            header("Location: " . ADMIN_URL . "/pages.php");
            exit;
        }
    }
}

// Fetch all pages
$allPages = $db->query("SELECT * FROM pages ORDER BY id ASC")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<?php if ($editPage): ?>
  <!-- Edit Page Form -->
  <div class="bg-white p-4 rounded-3 border shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="fw-bold text-dark mb-0">Editing Page: <?= e($editPage['title']) ?></h5>
      <a href="<?= ADMIN_URL ?>/pages.php" class="btn btn-outline-secondary btn-sm">Cancel & Return</a>
    </div>

    <form method="POST" action="">
      <input type="hidden" name="action" value="save_page">
      <input type="hidden" name="id" value="<?= $editPage['id'] ?>">
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Page Title</label>
          <input type="text" name="title" class="form-control" value="<?= e($editPage['title']) ?>" required>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">URL Slug (Fixed)</label>
          <input type="text" class="form-control bg-light" value="<?= e($editPage['slug']) ?>" disabled>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Breadcrumb Banner Title</label>
          <input type="text" name="breadcrumb_title" class="form-control" value="<?= e($editPage['breadcrumb_title'] ?? $editPage['title']) ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Meta Description (SEO)</label>
          <input type="text" name="meta_description" class="form-control" value="<?= e($editPage['meta_description']) ?>">
        </div>

        <div class="col-12">
          <div class="form-check form-switch my-2">
            <input class="form-check-input" type="checkbox" name="is_published" id="isPub" value="1" <?= $editPage['is_published'] ? 'checked' : '' ?>>
            <label class="form-check-label fw-semibold" for="isPub">Published & Visible on Website</label>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label fw-semibold">HTML Content / Layout</label>
          <textarea name="content_html" class="form-control font-monospace" rows="18"><?= e($editPage['content_html']) ?></textarea>
          <small class="text-muted">You can edit text, headings, image references, and layouts directly.</small>
        </div>

        <div class="col-12 text-end mt-4">
          <button type="submit" class="btn-admin-primary px-4 py-2">Save Page Changes</button>
        </div>
      </div>
    </form>
  </div>
<?php endif; ?>

<!-- All Pages Table -->
<div class="bg-white p-4 rounded-3 border shadow-sm">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark mb-0">All Website Pages (<?= count($allPages) ?>)</h5>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="font-size: 14px;">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Page Title</th>
          <th>Slug / Route</th>
          <th>Status</th>
          <th>Updated</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($allPages as $p): ?>
          <tr>
            <td><?= $p['id'] ?></td>
            <td class="fw-bold text-dark"><?= e($p['title']) ?></td>
            <td><code>/<?= e($p['slug']) ?>/</code></td>
            <td>
              <span class="badge bg-<?= $p['is_published'] ? 'success' : 'secondary' ?>">
                <?= $p['is_published'] ? 'Published' : 'Draft' ?>
              </span>
            </td>
            <td class="text-muted small"><?= date('M j, Y H:i', strtotime($p['updated_at'])) ?></td>
            <td class="text-end">
              <a href="<?= url('/' . $p['slug'] . '/') ?>" target="_blank" class="btn btn-sm btn-outline-info me-1" title="View Live Page">
                <i class="fa-solid fa-eye"></i>
              </a>
              <a href="<?= ADMIN_URL ?>/pages.php?edit=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit Page Content">
                <i class="fa-solid fa-pen-to-square"></i> Edit
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
