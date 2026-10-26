<?php
/**
 * Image Popup Notification Management
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'popup';
$adminTitle = 'Popup Notification Management';

$db = getDB();

// Handle Actions (Save Settings, Delete Image)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed. Please try again.');
    } else {
        $action = $_POST['action'] ?? 'save';

        if ($action === 'delete_image') {
            $currImg = get_setting('popup_image_url', '');
            if (!empty($currImg)) {
                $filePath = __DIR__ . '/../' . ltrim($currImg, '/');
                if (file_exists($filePath) && strpos($currImg, 'assets/images/popups/') !== false) {
                    @unlink($filePath);
                }
            }
            set_setting('popup_image_url', '');
            set_setting('popup_enabled', '0');
            set_flash('success', 'Popup image was deleted and popup notification disabled.');
            redirect(ADMIN_URL . '/popup.php');
        }

        if ($action === 'save') {
            $enabled   = isset($_POST['is_active']) ? '1' : '0';
            $title     = trim($_POST['title'] ?? '');
            $linkUrl   = trim($_POST['link_url'] ?? '');
            $startDate = trim($_POST['start_date'] ?? '');
            $endDate   = trim($_POST['end_date'] ?? '');

            // Validate date logic if both provided
            if (!empty($startDate) && !empty($endDate) && $startDate > $endDate) {
                set_flash('error', 'Start Date cannot be after End Date.');
                redirect(ADMIN_URL . '/popup.php');
            }

            $currentImg = get_setting('popup_image_url', '');
            $newImgPath = $currentImg;

            // Handle Image Upload
            if (!empty($_FILES['popup_image']['name'])) {
                $file = $_FILES['popup_image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

                if (!in_array($ext, $allowed)) {
                    set_flash('error', 'Invalid file format. Only JPG, PNG, WebP, and GIF are allowed.');
                    redirect(ADMIN_URL . '/popup.php');
                } elseif ($file['size'] > 15 * 1024 * 1024) {
                    set_flash('error', 'File size exceeds 15MB limit.');
                    redirect(ADMIN_URL . '/popup.php');
                } else {
                    $popupsDir = IMAGES_DIR . '/popups';
                    if (!is_dir($popupsDir)) {
                        @mkdir($popupsDir, 0755, true);
                    }

                    $cleanName = 'popup_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                    $targetPath = $popupsDir . '/' . $cleanName;

                    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                        // Delete previous uploaded popup if it was in assets/images/popups/
                        if (!empty($currentImg) && strpos($currentImg, 'assets/images/popups/') !== false) {
                            $oldFile = __DIR__ . '/../' . ltrim($currentImg, '/');
                            if (file_exists($oldFile)) {
                                @unlink($oldFile);
                            }
                        }
                        $newImgPath = 'assets/images/popups/' . $cleanName;
                    } else {
                        set_flash('error', 'Failed to save the uploaded image file.');
                        redirect(ADMIN_URL . '/popup.php');
                    }
                }
            }

            // Save all settings
            set_setting('popup_enabled', $enabled);
            set_setting('popup_image_url', $newImgPath);
            set_setting('popup_title', $title);
            set_setting('popup_link_url', $linkUrl);
            set_setting('popup_start_date', $startDate);
            set_setting('popup_end_date', $endDate);

            set_flash('success', 'Popup notification settings saved successfully.');
            redirect(ADMIN_URL . '/popup.php');
        }
    }
}

// Read current settings
$enabled   = get_setting('popup_enabled', '0');
$imageUrl  = get_setting('popup_image_url', '');
$title     = get_setting('popup_title', '');
$linkUrl   = get_setting('popup_link_url', '');
$startDate = get_setting('popup_start_date', '');
$endDate   = get_setting('popup_end_date', '');

$today = date('Y-m-d');
$isDateActive = true;
if (!empty($startDate) && $today < $startDate) {
    $isDateActive = false;
}
if (!empty($endDate) && $today > $endDate) {
    $isDateActive = false;
}

$isCurrentlyLive = ($enabled === '1' && !empty($imageUrl) && $isDateActive);

require_once __DIR__ . '/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold mb-1 text-dark">Image Popup Notification</h4>
    <p class="text-muted small mb-0">Upload announcement flyers, admission notifications, or event banners to popup when visitors open the site.</p>
  </div>
  <div>
    <a href="<?= url('/') ?>" target="_blank" class="btn btn-outline-danger btn-sm">
      <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Preview On Live Site
    </a>
  </div>
</div>

<!-- Status Banner Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4" style="background: #ffffff;">
  <div class="card-body p-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3">
        <?php if ($isCurrentlyLive): ?>
          <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fa-solid fa-circle-check"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2">
              <h5 class="fw-bold mb-0 text-dark">Popup is Live &amp; Active</h5>
              <span class="badge bg-success px-2 py-1">Active</span>
            </div>
            <p class="text-muted small mb-0">Visitors will see this popup banner upon opening the school website.</p>
          </div>
        <?php elseif ($enabled === '1' && !$isDateActive): ?>
          <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.12); color: #F59E0B; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fa-solid fa-calendar-xmark"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2">
              <h5 class="fw-bold mb-0 text-dark">Outside Scheduled Date Range</h5>
              <span class="badge bg-warning text-dark px-2 py-1">Scheduled / Expired</span>
            </div>
            <p class="text-muted small mb-0">Enabled in settings, but current date is outside the start/end schedule window.</p>
          </div>
        <?php else: ?>
          <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(107, 114, 128, 0.12); color: #6B7280; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="fa-solid fa-power-off"></i>
          </div>
          <div>
            <div class="d-flex align-items-center gap-2">
              <h5 class="fw-bold mb-0 text-dark">Popup is Disabled</h5>
              <span class="badge bg-secondary px-2 py-1">Disabled</span>
            </div>
            <p class="text-muted small mb-0">No popup will be shown to visitors. Enable it below whenever you want to announce.</p>
          </div>
        <?php endif; ?>
      </div>

      <div class="text-end">
        <span class="text-muted small d-block">Today's Date: <b><?= date('d M Y') ?></b></span>
        <?php if (!empty($startDate) || !empty($endDate)): ?>
          <span class="badge bg-light text-dark border">
            Schedule: <?= !empty($startDate) ? e($startDate) : 'Start' ?> &rarr; <?= !empty($endDate) ? e($endDate) : 'Indefinite' ?>
          </span>
        <?php else: ?>
          <span class="badge bg-light text-muted border">No date limits (Always active when enabled)</span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  
  <!-- Left Column: Settings Form -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm rounded-4" style="background: #ffffff;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h5 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-sliders text-danger me-2"></i>Configure Notification</h5>
        <p class="text-muted small mb-0">Customize popup visibility, image banner, announcement title, and active period.</p>
      </div>

      <div class="card-body p-4">
        <form method="POST" action="<?= ADMIN_URL ?>/popup.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
          <input type="hidden" name="action" value="save">

          <!-- Enable / Disable Switch -->
          <div class="p-3 mb-4 rounded-3" style="background: #F9FAFB; border: 1px solid #E5E7EB;">
            <div class="form-check form-switch d-flex align-items-center gap-3 ps-0 mb-0">
              <input class="form-check-input ms-0" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= $enabled === '1' ? 'checked' : '' ?> style="width: 48px; height: 26px; cursor: pointer;">
              <label class="form-check-label fw-bold text-dark cursor-pointer mb-0" for="is_active" style="cursor: pointer;">
                Enable Popup Image Notification
                <span class="d-block text-muted small fw-normal">Switch ON to display this popup when visitors access the website.</span>
              </label>
            </div>
          </div>

          <!-- Image Upload / Replace -->
          <div class="mb-4">
            <label class="form-label fw-bold text-dark">
              Popup Image Banner <?= empty($imageUrl) ? '<span class="text-danger">*</span>' : '' ?>
            </label>
            <input type="file" name="popup_image" id="popup_image" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
            <div class="form-text small text-muted">
              Supported formats: JPG, PNG, WebP, GIF. Maximum recommended size: 15MB.
              <?php if (!empty($imageUrl)): ?>
                <span class="text-primary d-block mt-1"><i class="fa-solid fa-info-circle me-1"></i>Select a new file only if you want to replace the current image.</span>
              <?php endif; ?>
            </div>
          </div>

          <!-- Announcement Title -->
          <div class="mb-3">
            <label class="form-label fw-bold text-dark">Announcement Title / Caption</label>
            <input type="text" name="title" class="form-control" value="<?= e($title) ?>" placeholder="e.g., Admissions Open 2026-27 or Annual Sports Meet">
            <div class="form-text small text-muted">Used for image alt text and accessibility labels.</div>
          </div>

          <!-- Optional Redirect Link -->
          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Target Action Link (Optional)</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-link"></i></span>
              <input type="text" name="link_url" class="form-control" value="<?= e($linkUrl) ?>" placeholder="e.g., /admission-procedure/ or https://...">
            </div>
            <div class="form-text small text-muted">When visitors click on the popup image, they will be redirected to this URL. Leave blank if image is informational only.</div>
          </div>

          <!-- Scheduling Date Range -->
          <div class="mb-4 p-3 rounded-3" style="background: #F8FAFC; border: 1px solid #E2E8F0;">
            <label class="form-label fw-bold text-dark mb-2">
              <i class="fa-regular fa-calendar-days text-primary me-1"></i> Display Schedule (Optional)
            </label>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small text-muted fw-semibold">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= e($startDate) ?>">
                <span class="small text-muted" style="font-size: 11px;">Starts showing on this date (leave blank for immediate).</span>
              </div>
              <div class="col-md-6">
                <label class="form-label small text-muted fw-semibold">End Date</label>
                <input type="date" name="end_date" class="form-control" value="<?= e($endDate) ?>">
                <span class="small text-muted" style="font-size: 11px;">Stops showing after this date (leave blank for indefinite).</span>
              </div>
            </div>
          </div>

          <!-- Save Button -->
          <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-admin-primary px-4 py-2">
              <i class="fa-solid fa-floppy-disk me-1"></i> Save Popup Settings
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Right Column: Current Image Preview & Delete Action -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-4" style="background: #ffffff;">
      <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h5 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-image text-danger me-2"></i>Current Popup Banner</h5>
        <p class="text-muted small mb-0">Visual preview of the image currently configured for popup notification.</p>
      </div>

      <div class="card-body p-4 text-center">
        <?php if (!empty($imageUrl)): ?>
          <?php 
            $displayImg = $imageUrl;
            if (!preg_match('#^https?://#i', $displayImg)) {
                $displayImg = asset_url(str_replace('assets/', '', $displayImg));
            }
          ?>
          <div class="position-relative d-inline-block rounded-3 overflow-hidden border p-2 mb-3" style="background: #FAF8F5; max-width: 100%;">
            <img src="<?= e($displayImg) ?>" alt="<?= e($title) ?>" class="img-fluid rounded" style="max-height: 380px; object-fit: contain;">
          </div>

          <div class="text-start p-3 bg-light rounded-3 mb-3 small">
            <div class="mb-1 text-muted">Image Path: <span class="text-dark fw-semibold font-monospace" style="font-size: 11.5px;"><?= e($imageUrl) ?></span></div>
            <div class="mb-1 text-muted">Title: <span class="text-dark fw-semibold"><?= !empty($title) ? e($title) : '<em>None</em>' ?></span></div>
            <div class="text-muted">Target Link: <span class="text-dark fw-semibold"><?= !empty($linkUrl) ? e($linkUrl) : '<em>None</em>' ?></span></div>
          </div>

          <!-- Actions -->
          <div class="d-flex justify-content-center gap-2">
            <!-- Delete Form -->
            <form method="POST" action="<?= ADMIN_URL ?>/popup.php" onsubmit="return confirm('Are you sure you want to delete this popup image? The notification will be disabled.');">
              <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
              <input type="hidden" name="action" value="delete_image">
              <button type="submit" class="btn btn-outline-danger btn-sm px-3 py-2">
                <i class="fa-solid fa-trash-can me-1"></i> Delete Image
              </button>
            </form>
          </div>

        <?php else: ?>
          <div class="py-5 text-center text-muted">
            <div class="mb-3" style="font-size: 48px; color: #D1D5DB;">
              <i class="fa-solid fa-image"></i>
            </div>
            <h6 class="fw-bold text-secondary">No Popup Image Configured</h6>
            <p class="small text-muted mb-0">Use the form on the left to upload an announcement image and enable the popup notification.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
