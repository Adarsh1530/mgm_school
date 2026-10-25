<?php
/**
 * Admin Popup Image Management
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'popup';
$adminTitle = 'Popup Image Management';

$db = getDB();

// Handle Save Action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $isActive = isset($_POST['is_active']) ? '1' : '0';
        $title = trim($_POST['title'] ?? 'Special Announcement');
        $redirectUrl = trim($_POST['redirect_url'] ?? '');
        $showDelay = (int)($_POST['show_delay'] ?? 800);
        $displayMode = trim($_POST['display_mode'] ?? 'session');

        // Fetch current image
        $currImgStmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = 'popup_image_url'");
        $currImgStmt->execute();
        $imageUrl = $currImgStmt->fetchColumn() ?: 'assets/images/Untitled-design-4.png';

        // Handle photo upload
        if (!empty($_FILES['popup_image']['name'])) {
            $file = $_FILES['popup_image'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (!in_array($ext, $allowed)) {
                set_flash('error', 'Only JPG, PNG, WebP, or GIF images are allowed.');
            } elseif ($file['size'] > 15 * 1024 * 1024) {
                set_flash('error', 'Image size exceeds 15MB limit.');
            } else {
                $cleanName = 'popup_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                $targetPath = IMAGES_DIR . '/' . $cleanName;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $imageUrl = 'assets/images/' . $cleanName;
                } else {
                    set_flash('error', 'Failed to save uploaded image.');
                }
            }
        }

        // Upsert settings in site_settings
        $settingsToSave = [
            'popup_active'       => $isActive,
            'popup_title'        => $title,
            'popup_image_url'    => $imageUrl,
            'popup_redirect_url' => $redirectUrl,
            'popup_delay'        => (string)$showDelay,
            'popup_mode'         => $displayMode
        ];

        $upsertStmt = $db->prepare("
            INSERT INTO site_settings (setting_key, setting_value) 
            VALUES (:k, :v) 
            ON DUPLICATE KEY UPDATE setting_value = :v2
        ");

        foreach ($settingsToSave as $k => $v) {
            $upsertStmt->execute([':k' => $k, ':v' => $v, ':v2' => $v]);
        }

        set_flash('success', 'Popup image settings saved successfully.');
        header("Location: " . ADMIN_URL . "/popup.php");
        exit;
    }
}

// Fetch current popup settings
$stmt = $db->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key LIKE 'popup_%'");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$popupActive = isset($settings['popup_active']) ? (int)$settings['popup_active'] : 1;
$popupTitle = $settings['popup_title'] ?? 'Admissions Open 2025-2026';
$popupImage = $settings['popup_image_url'] ?? 'assets/images/Untitled-design-4.png';
$popupRedirect = $settings['popup_redirect_url'] ?? 'admission-procedure/';
$popupDelay = isset($settings['popup_delay']) ? (int)$settings['popup_delay'] : 800;
$popupMode = $settings['popup_mode'] ?? 'session';

require_once __DIR__ . '/header.php';
?>

<div class="row g-4">
  
  <!-- Left Column: Settings Form -->
  <div class="col-lg-6">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-window-restore me-2 text-danger"></i> Popup Announcement Settings</h5>
        <span class="badge <?= $popupActive ? 'bg-success' : 'bg-secondary' ?> px-3 py-2">
          <?= $popupActive ? 'Currently Active' : 'Currently Disabled' ?>
        </span>
      </div>

      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="form-check form-switch mb-3 p-3 bg-light rounded border">
          <input class="form-check-input ms-0 me-3" type="checkbox" name="is_active" id="popupActiveSwitch" value="1" <?= $popupActive ? 'checked' : '' ?> style="transform: scale(1.3);">
          <label class="form-check-label fw-bold text-dark" for="popupActiveSwitch">
            Enable Popup on Public Website
            <div class="text-muted fw-normal small">When enabled, visitors will see this announcement flyer when opening the site.</div>
          </label>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Announcement Title / Alt Text *</label>
          <input type="text" name="title" class="form-control" value="<?= e($popupTitle) ?>" placeholder="e.g. Admissions Open 2025-2026" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Upload / Replace Popup Image Flyer</label>
          <input type="file" name="popup_image" class="form-control" accept="image/*">
          <div class="form-text small">Accepted formats: JPG, PNG, WebP, GIF (Max 15MB). Leave empty to retain current image.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Click Redirect URL (Optional)</label>
          <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-link"></i></span>
            <input type="text" name="redirect_url" class="form-control" value="<?= e($popupRedirect) ?>" placeholder="e.g. admission-procedure/ or https://...">
          </div>
          <div class="form-text small">Visitors are redirected to this URL when clicking the popup poster image.</div>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-sm-6">
            <label class="form-label fw-semibold small">Display Delay (Milliseconds)</label>
            <input type="number" name="show_delay" class="form-control" value="<?= $popupDelay ?>" min="0" step="100">
            <div class="form-text small">800ms = 0.8 seconds after page load.</div>
          </div>
          <div class="col-sm-6">
            <label class="form-label fw-semibold small">Display Frequency</label>
            <select name="display_mode" class="form-select">
              <option value="session" <?= $popupMode === 'session' ? 'selected' : '' ?>>Once Per Browser Session (Recommended)</option>
              <option value="always" <?= $popupMode === 'always' ? 'selected' : '' ?>>Every Page Load / Refresh</option>
            </select>
          </div>
        </div>

        <button type="submit" class="btn-admin-primary w-100 py-2">
          <i class="fa-solid fa-floppy-disk me-1"></i> Save Popup Settings
        </button>
      </form>
    </div>
  </div>

  <!-- Right Column: Live Poster Preview -->
  <div class="col-lg-6">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-eye me-2 text-primary"></i> Current Popup Preview</h5>
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="testPopupModal()">
          <i class="fa-solid fa-play me-1"></i> Test Live Modal
        </button>
      </div>

      <div class="p-3 rounded border text-center" style="background: #F1F5F9;">
        <div class="mb-2 text-muted small">Current Poster Image:</div>
        <div class="d-inline-block position-relative shadow-sm rounded overflow-hidden" style="max-width: 100%; border: 3px solid #ffffff;">
          <img src="<?= asset_url($popupImage) ?>" alt="<?= e($popupTitle) ?>" id="previewImg" style="max-height: 380px; width: auto; max-width: 100%; object-fit: contain; display: block;">
        </div>
        <div class="mt-3 text-start small border-top pt-2">
          <div><b>Title:</b> <?= e($popupTitle) ?></div>
          <div><b>Redirect URL:</b> <?= $popupRedirect ? '<a href="' . e(url($popupRedirect)) . '" target="_blank">' . e($popupRedirect) . '</a>' : '<span class="text-muted">None (Image Only)</span>' ?></div>
          <div><b>Delay:</b> <?= $popupDelay ?>ms &bull; <b>Frequency:</b> <?= $popupMode === 'session' ? 'Once per session' : 'Every load' ?></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Modal simulation script -->
<script>
function testPopupModal() {
  const overlay = document.createElement('div');
  overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(6,26,56,0.85);backdrop-filter:blur(6px);z-index:99999;display:flex;align-items:center;justify-content:center;padding:20px;';
  
  const card = document.createElement('div');
  card.style.cssText = 'position:relative;max-width:90vw;max-height:90vh;display:flex;align-items:center;justify-content:center;box-shadow:0 24px 48px rgba(0,0,0,0.6);border-radius:12px;background:#fff;overflow:hidden;';
  
  const closeBtn = document.createElement('button');
  closeBtn.innerHTML = '&times;';
  closeBtn.style.cssText = 'position:absolute;top:8px;right:8px;width:38px;height:38px;border-radius:50%;background:#EF4444;color:#fff;border:2px solid #fff;font-size:1.5rem;line-height:1;cursor:pointer;z-index:10;box-shadow:0 4px 12px rgba(0,0,0,0.3);';
  closeBtn.onclick = () => document.body.removeChild(overlay);
  
  const img = document.createElement('img');
  img.src = document.getElementById('previewImg').src;
  img.style.cssText = 'display:block;max-width:85vw;max-height:80vh;width:auto;height:auto;object-fit:contain;';
  
  card.appendChild(closeBtn);
  card.appendChild(img);
  overlay.appendChild(card);
  overlay.onclick = (e) => { if (e.target === overlay) document.body.removeChild(overlay); };
  document.body.appendChild(overlay);
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
