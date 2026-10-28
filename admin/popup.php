<?php
/**
 * Image Popup Notification Management & History Portal
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'popup';
$adminTitle = 'Popup Notification Management';

$db = getDB();

// Ensure popups table exists
try {
    $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
    if ($driver === 'sqlite') {
        $db->exec("CREATE TABLE IF NOT EXISTS popups (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            image_url TEXT NOT NULL,
            link_url TEXT DEFAULT '',
            is_active INTEGER NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
    } else {
        $db->exec("CREATE TABLE IF NOT EXISTS `popups` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) NOT NULL,
            `image_url` varchar(500) NOT NULL,
            `link_url` varchar(500) DEFAULT '',
            `is_active` tinyint(1) NOT NULL DEFAULT 0,
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    // Seed table if empty from current settings
    $pCount = (int)$db->query("SELECT COUNT(*) FROM popups")->fetchColumn();
    if ($pCount === 0) {
        $currImg = get_setting('popup_image_url', '');
        $currTitle = get_setting('popup_title', 'Admissions Open 2026-27');
        $currLink = get_setting('popup_link_url', '/admission-procedure/');
        $currEnabled = (get_setting('popup_enabled', '0') === '1') ? 1 : 0;

        if (!empty($currImg)) {
            $ins = $db->prepare("INSERT INTO popups (title, image_url, link_url, is_active, created_at, updated_at) VALUES (:t, :i, :l, :a, NOW(), NOW())");
            $ins->execute([
                ':t' => $currTitle,
                ':i' => $currImg,
                ':l' => $currLink,
                ':a' => $currEnabled
            ]);
        }

        // Add historical reference popup if not already present
        $altImg = 'assets/images/admission-procedure-infographic.jpeg';
        if ($currImg !== $altImg && file_exists(__DIR__ . '/../' . $altImg)) {
            $ins2 = $db->prepare("INSERT INTO popups (title, image_url, link_url, is_active, created_at, updated_at) VALUES (:t, :i, :l, :a, NOW(), NOW())");
            $ins2->execute([
                ':t' => 'Admissions Open 2026-27 Infographic Flyer',
                ':i' => $altImg,
                ':l' => '/admission-procedure/',
                ':a' => 0
            ]);
        }
    }
} catch (\Throwable $e) {
    // Ignore schema creation errors if already exists
}

// Ensure redirect function is available
if (!function_exists('redirect')) {
    function redirect(string $url): void {
        header("Location: " . $url);
        exit;
    }
}

// Handle POST Actions (Create, Edit, Toggle Active, Delete)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed. Please try again.');
        header("Location: " . ADMIN_URL . "/popup.php");
        exit;
    }

    $action = $_POST['action'] ?? '';

    // Action 1: Toggle Active / Deactive
    if ($action === 'toggle_active') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM popups WHERE id = ?");
        $stmt->execute([$id]);
        $popup = $stmt->fetch();

        if ($popup) {
            if ((int)$popup['is_active'] === 1) {
                // Deactivate this popup
                $db->prepare("UPDATE popups SET is_active = 0 WHERE id = ?")->execute([$id]);
                set_setting('popup_enabled', '0');
                set_flash('success', "Popup '" . e($popup['title']) . "' has been deactivated.");
            } else {
                // Deactivate all others first, then activate this one
                $db->exec("UPDATE popups SET is_active = 0");
                $db->prepare("UPDATE popups SET is_active = 1 WHERE id = ?")->execute([$id]);
                
                // Synchronize with site_settings
                set_setting('popup_enabled', '1');
                set_setting('popup_image_url', $popup['image_url']);
                set_setting('popup_title', $popup['title']);
                set_setting('popup_link_url', $popup['link_url']);

                set_flash('success', "Popup '" . e($popup['title']) . "' is now Live & Active on the website.");
            }
        }
        header("Location: " . ADMIN_URL . "/popup.php");
        exit;
    }

    // Action 2: Delete Popup
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $db->prepare("SELECT * FROM popups WHERE id = ?");
        $stmt->execute([$id]);
        $popup = $stmt->fetch();

        if ($popup) {
            $wasActive = ((int)$popup['is_active'] === 1);
            
            // Delete record
            $db->prepare("DELETE FROM popups WHERE id = ?")->execute([$id]);

            // If it was in assets/images/popups/, remove file
            if (!empty($popup['image_url']) && strpos($popup['image_url'], 'assets/images/popups/') !== false) {
                $filePath = __DIR__ . '/../' . ltrim($popup['image_url'], '/');
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            // If it was the active popup, disable site_settings
            if ($wasActive) {
                // Check if another popup exists to activate, or disable
                $next = $db->query("SELECT * FROM popups ORDER BY id DESC LIMIT 1")->fetch();
                if ($next) {
                    $db->prepare("UPDATE popups SET is_active = 1 WHERE id = ?")->execute([$next['id']]);
                    set_setting('popup_enabled', '1');
                    set_setting('popup_image_url', $next['image_url']);
                    set_setting('popup_title', $next['title']);
                    set_setting('popup_link_url', $next['link_url']);
                } else {
                    set_setting('popup_enabled', '0');
                    set_setting('popup_image_url', '');
                }
            }

            set_flash('success', "Popup '" . e($popup['title']) . "' was deleted successfully.");
        }
        header("Location: " . ADMIN_URL . "/popup.php");
        exit;
    }

    // Action 3: Save (Create or Edit)
    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $linkUrl = trim($_POST['link_url'] ?? '');
        $setActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            set_flash('error', 'Please enter a title/caption for the popup.');
            header("Location: " . ADMIN_URL . ($id > 0 ? "/popup.php?edit={$id}" : "/popup.php"));
            exit;
        }

        $popupsDir = IMAGES_DIR . '/popups';
        if (!is_dir($popupsDir)) {
            @mkdir($popupsDir, 0755, true);
        }

        // EDIT MODE
        if ($id > 0) {
            $stmt = $db->prepare("SELECT * FROM popups WHERE id = ?");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();

            if (!$existing) {
                set_flash('error', 'Popup record not found.');
                header("Location: " . ADMIN_URL . "/popup.php");
                exit;
            }

            $imageUrl = $existing['image_url'];

            // Optional new image upload
            if (!empty($_FILES['popup_image']['name'])) {
                $file = $_FILES['popup_image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                $maxSize = 10 * 1024 * 1024; // 10 MB

                if (!in_array($ext, $allowed)) {
                    set_flash('error', "Invalid file format for '{$file['name']}'. Only JPEG, PNG, and PDF files are allowed.");
                    header("Location: " . ADMIN_URL . "/popup.php?edit={$id}");
                    exit;
                } elseif ($file['size'] > $maxSize) {
                    $sizeMb = round($file['size'] / (1024 * 1024), 2);
                    set_flash('error', "File '{$file['name']}' exceeds the 10 MB limit ({$sizeMb} MB). Please upload a file up to 10 MB.");
                    header("Location: " . ADMIN_URL . "/popup.php?edit={$id}");
                    exit;
                } else {
                    $cleanName = 'popup_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $targetPath = $popupsDir . '/' . $cleanName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        $imageUrl = 'assets/images/popups/' . $cleanName;
                    } else {
                        set_flash('error', 'Failed to save the uploaded image file.');
                        header("Location: " . ADMIN_URL . "/popup.php?edit={$id}");
                        exit;
                    }
                }
            }

            $newActive = ($setActive === 1) ? 1 : 0;
            if ($newActive === 1) {
                $db->exec("UPDATE popups SET is_active = 0");
            }

            $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
            $nowFunc = ($driver === 'sqlite') ? "datetime('now')" : "NOW()";

            $upd = $db->prepare("UPDATE popups SET title = :t, link_url = :l, image_url = :i, is_active = :a, updated_at = {$nowFunc} WHERE id = :id");
            $upd->execute([
                ':t'  => $title,
                ':l'  => $linkUrl,
                ':i'  => $imageUrl,
                ':a'  => $newActive,
                ':id' => $id
            ]);

            // Sync to site_settings
            if ($newActive === 1) {
                set_setting('popup_enabled', '1');
                set_setting('popup_image_url', $imageUrl);
                set_setting('popup_title', $title);
                set_setting('popup_link_url', $linkUrl);
            } elseif ((int)$existing['is_active'] === 1 && $newActive === 0) {
                set_setting('popup_enabled', '0');
            }

            set_flash('success', "Popup '{$title}' updated successfully.");
            header("Location: " . ADMIN_URL . "/popup.php");
            exit;

        } else {
            // CREATE MODE
            if (empty($_FILES['popup_image']['name'])) {
                set_flash('error', 'Please select an image banner for the popup.');
                header("Location: " . ADMIN_URL . "/popup.php");
                exit;
            }

            $file = $_FILES['popup_image'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
            $maxSize = 10 * 1024 * 1024; // 10 MB

            if (!in_array($ext, $allowed)) {
                set_flash('error', "Invalid file format for '{$file['name']}'. Only JPEG, PNG, and PDF files are allowed.");
                header("Location: " . ADMIN_URL . "/popup.php");
                exit;
            } elseif ($file['size'] > $maxSize) {
                $sizeMb = round($file['size'] / (1024 * 1024), 2);
                set_flash('error', "File '{$file['name']}' exceeds the 10 MB limit ({$sizeMb} MB). Please upload a file up to 10 MB.");
                header("Location: " . ADMIN_URL . "/popup.php");
                exit;
            } else {
                $cleanName = 'popup_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                $targetPath = $popupsDir . '/' . $cleanName;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $newImgPath = 'assets/images/popups/' . $cleanName;

                    if ($setActive === 1) {
                        $db->exec("UPDATE popups SET is_active = 0");
                    }

                    $driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME);
                    $nowFunc = ($driver === 'sqlite') ? "datetime('now')" : "NOW()";

                    $ins = $db->prepare("INSERT INTO popups (title, image_url, link_url, is_active, created_at, updated_at) VALUES (:t, :i, :l, :a, {$nowFunc}, {$nowFunc})");
                    $ins->execute([
                        ':t' => $title,
                        ':i' => $newImgPath,
                        ':l' => $linkUrl,
                        ':a' => $setActive
                    ]);

                    if ($setActive === 1) {
                        set_setting('popup_enabled', '1');
                        set_setting('popup_image_url', $newImgPath);
                        set_setting('popup_title', $title);
                        set_setting('popup_link_url', $linkUrl);
                        set_flash('success', "New popup created and activated live on the website.");
                    } else {
                        set_flash('success', "New popup created successfully and added to history.");
                    }
                } else {
                    set_flash('error', 'Failed to save the uploaded image.');
                }
            }
            header("Location: " . ADMIN_URL . "/popup.php");
            exit;
        }
    }
}

// Check if Editing a popup
$editPopup = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM popups WHERE id = ?");
    $stmt->execute([$editId]);
    $editPopup = $stmt->fetch();
}

// Fetch all popups ordered by Active first, then most recently updated
$popupsList = $db->query("SELECT * FROM popups ORDER BY is_active DESC, updated_at DESC, id DESC")->fetchAll();

// Find currently active popup
$activePopup = null;
foreach ($popupsList as $p) {
    if ((int)$p['is_active'] === 1) {
        $activePopup = $p;
        break;
    }
}

require_once __DIR__ . '/header.php';
?>

<!-- Active Status Banner -->
<div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff;">
  <div class="card-body p-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3">
        <?php if ($activePopup): ?>
          <div style="width: 50px; height: 50px; border-radius: 14px; background: rgba(16, 185, 129, 0.12); color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-circle-check"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <h5 class="fw-bold mb-0 text-dark">Popup is Live &amp; Active</h5>
              <span class="badge bg-success px-2 py-1">Active</span>
            </div>
            <p class="text-muted small mb-0">
              Active Banner: <strong class="text-dark"><?= e($activePopup['title']) ?></strong> &bull; Visitors will see this announcement upon opening the website.
            </p>
          </div>
        <?php else: ?>
          <div style="width: 50px; height: 50px; border-radius: 14px; background: rgba(107, 114, 128, 0.12); color: #6B7280; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            <i class="fa-solid fa-power-off"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <h5 class="fw-bold mb-0 text-dark">Popup is Currently Inactive</h5>
              <span class="badge bg-secondary px-2 py-1">Disabled</span>
            </div>
            <p class="text-muted small mb-0">No popup is currently shown to visitors. You can activate any popup from the history table below or create a new one.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">

  <!-- Left Column: Create or Edit Popup Form -->
  <div class="col-xl-4 col-lg-5">
    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: #ffffff;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h5 class="fw-bold mb-1 text-dark">
          <?php if ($editPopup): ?>
            <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Edit Popup
          <?php else: ?>
            <i class="fa-solid fa-circle-plus text-danger me-2"></i>Create New Popup
          <?php endif; ?>
        </h5>
        <p class="text-muted small mb-0">
          <?= $editPopup ? 'Modify the announcement details or replace the flyer image.' : 'Upload a flyer banner to announce admissions, events, or notices.' ?>
        </p>
      </div>

      <div class="card-body p-4">
        <form method="POST" action="<?= ADMIN_URL ?>/popup.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="action" value="save">
          <?php if ($editPopup): ?>
            <input type="hidden" name="id" value="<?= $editPopup['id'] ?>">
          <?php endif; ?>

          <!-- Title -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Announcement Title / Caption *</label>
            <input type="text" name="title" class="form-control" value="<?= e($editPopup['title'] ?? '') ?>" placeholder="e.g., Admissions Open 2026-27" required>
            <div class="form-text small text-muted">Used for accessibility labels and admin reference.</div>
          </div>

          <!-- Image Upload -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark small">
              Popup Banner / Flyer <?= $editPopup ? '(Optional Replacement &mdash; Max 10 MB)' : '(Max 10 MB) *' ?>
            </label>
            <input type="file" name="popup_image" id="popupImageFileInput" class="form-control" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf" <?= $editPopup ? '' : 'required' ?>>
            <div class="form-text small text-muted">Supported formats: <strong>JPEG, PNG, PDF</strong> (Max <strong>10 MB</strong>).</div>

            <?php if ($editPopup && !empty($editPopup['image_url'])): ?>
              <div class="mt-3 p-2 border rounded-3 bg-light text-center">
                <span class="d-block small text-muted mb-1 text-start fw-semibold">Current Attached Banner:</span>
                <a href="<?= asset_url(str_replace('assets/', '', $editPopup['image_url'])) ?>" target="_blank" title="View Full Image">
                  <img src="<?= asset_url(str_replace('assets/', '', $editPopup['image_url'])) ?>" alt="Current Banner" class="img-fluid rounded border" style="max-height: 140px; object-fit: contain; background: #fff;">
                </a>
                <div class="text-truncate text-muted small mt-1 font-monospace" style="font-size: 11px;">
                  <?= e($editPopup['image_url']) ?>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Target Link -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Target Action Link (Optional)</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-link"></i></span>
              <input type="text" name="link_url" class="form-control" value="<?= e($editPopup['link_url'] ?? '') ?>" placeholder="e.g. /admission-procedure/ or https://...">
            </div>
            <div class="form-text small text-muted">When visitors click the popup, they are redirected here.</div>
          </div>

          <!-- Set Active Immediately Checkbox -->
          <div class="p-3 mb-4 rounded-3 border" style="background: #F9FAFB;">
            <div class="form-check form-switch d-flex align-items-center gap-3 ps-0 mb-0">
              <input class="form-check-input ms-0" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= ($editPopup ? ((int)$editPopup['is_active'] === 1 ? 'checked' : '') : 'checked') ?> style="width: 44px; height: 24px; cursor: pointer;">
              <label class="form-check-label fw-semibold text-dark small cursor-pointer mb-0" for="is_active" style="cursor: pointer;">
                <?= $editPopup ? 'Keep Active on Website' : 'Set as Active Immediately' ?>
                <span class="d-block text-muted" style="font-size: 11px; font-weight: normal;">Deactivates any previous popup so only one is shown.</span>
              </label>
            </div>
          </div>

          <!-- Submit Buttons -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-semibold">
              <i class="fa-solid <?= $editPopup ? 'fa-floppy-disk' : 'fa-plus' ?> me-1"></i>
              <?= $editPopup ? 'Save Changes' : 'Create Popup' ?>
            </button>
            <?php if ($editPopup): ?>
              <a href="<?= ADMIN_URL ?>/popup.php" class="btn btn-outline-secondary py-2">Cancel</a>
            <?php endif; ?>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Right Column: History List of Popups -->
  <div class="col-xl-8 col-lg-7">
    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: #ffffff;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
          <h5 class="fw-bold mb-1 text-dark">
            <i class="fa-solid fa-clock-rotate-left text-danger me-2"></i>Popup Notification History (<?= count($popupsList) ?>)
          </h5>
          <p class="text-muted small mb-0">Recently created and previous popup banners. You can directly activate any older popup anytime.</p>
        </div>
      </div>

      <div class="card-body p-4">
        <?php if (!empty($popupsList)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
              <thead class="table-light">
                <tr>
                  <th style="width: 40px;" class="text-center">#</th>
                  <th style="width: 65px;" class="text-center">Preview</th>
                  <th>Popup Title &amp; Target Link</th>
                  <th style="width: 95px;" class="text-center">Status</th>
                  <th class="text-end" style="width: 175px; min-width: 175px; white-space: nowrap;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($popupsList as $idx => $p): 
                  $isActive = ((int)$p['is_active'] === 1);
                  $imgSrc = asset_url(str_replace('assets/', '', $p['image_url']));
                  $isEditingThis = ($editPopup && (int)$editPopup['id'] === (int)$p['id']);
                ?>
                  <tr class="<?= $isEditingThis ? 'table-warning' : ($isActive ? 'table-success-subtle' : '') ?>" style="<?= $isActive ? 'background-color: rgba(16, 185, 129, 0.04);' : '' ?>">
                    <td class="text-center fw-bold text-muted"><?= $idx + 1 ?></td>
                    <td class="text-center">
                      <a href="<?= $imgSrc ?>" target="_blank" class="d-inline-block border rounded p-1 bg-white shadow-sm" title="Click to view full flyer">
                        <img src="<?= $imgSrc ?>" alt="<?= e($p['title']) ?>" style="width: 44px; height: 44px; object-fit: cover; border-radius: 4px; display: block;">
                      </a>
                    </td>
                    <td>
                      <div class="fw-bold text-dark"><?= e($p['title']) ?></div>
                      <?php if (!empty($p['link_url'])): ?>
                        <div class="text-truncate text-muted small mt-1" style="max-width: 250px;">
                          <i class="fa-solid fa-link text-primary me-1" style="font-size: 11px;"></i>
                          <a href="<?= e($p['link_url']) ?>" target="_blank" class="text-decoration-none text-muted font-monospace" style="font-size: 11.5px;">
                            <?= e($p['link_url']) ?>
                          </a>
                        </div>
                      <?php else: ?>
                        <span class="text-muted small" style="font-size: 11px;"><em>No redirect link</em></span>
                      <?php endif; ?>
                      <div class="text-muted mt-1" style="font-size: 11px;">
                        Created: <?= date('d M Y', strtotime($p['created_at'])) ?>
                      </div>
                    </td>
                    <td class="text-center">
                      <?php if ($isActive): ?>
                        <span class="badge bg-success text-white px-2 py-1 fw-semibold">
                          <i class="fa-solid fa-circle-check me-1"></i> Active
                        </span>
                      <?php else: ?>
                        <span class="badge bg-light text-muted border px-2 py-1 fw-semibold">
                          Inactive
                        </span>
                      <?php endif; ?>
                    </td>
                    <td class="text-end" style="white-space: nowrap;">
                      <div class="d-inline-flex align-items-center justify-content-end gap-1 flex-nowrap">
                        
                        <!-- 1. Active / Deactive Toggle Button -->
                        <form method="POST" action="<?= ADMIN_URL ?>/popup.php" class="d-inline m-0 p-0">
                          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                          <input type="hidden" name="action" value="toggle_active">
                          <input type="hidden" name="id" value="<?= $p['id'] ?>">
                          <?php if ($isActive): ?>
                            <button type="submit" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1" title="Deactivate this popup" style="font-size: 12px; padding: 5px 9px;">
                              <i class="fa-solid fa-power-off"></i> Deactive
                            </button>
                          <?php else: ?>
                            <button type="submit" class="btn btn-sm btn-success text-white d-inline-flex align-items-center gap-1" title="Directly activate this popup" style="font-size: 12px; padding: 5px 9px;">
                              <i class="fa-solid fa-bolt"></i> Active
                            </button>
                          <?php endif; ?>
                        </form>

                        <!-- 2. Edit Button -->
                        <a href="<?= ADMIN_URL ?>/popup.php?edit=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center justify-content-center" style="width: 31px; height: 31px; padding: 0;" title="Edit details">
                          <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- 3. Delete Button -->
                        <form method="POST" action="<?= ADMIN_URL ?>/popup.php" class="d-inline m-0 p-0" onsubmit="return confirm('Are you sure you want to delete this popup record?');">
                          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="id" value="<?= $p['id'] ?>">
                          <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center justify-content-center" style="width: 31px; height: 31px; padding: 0;" title="Delete">
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
        <?php else: ?>
          <div class="py-5 text-center text-muted">
            <i class="fa-solid fa-window-restore fs-1 text-secondary opacity-50 mb-3 d-block"></i>
            <h6 class="fw-bold text-dark">No Popups Found in History</h6>
            <p class="small text-muted mb-0">Use the form on the left to create your first announcement popup.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileInput = document.getElementById('popupImageFileInput');
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
