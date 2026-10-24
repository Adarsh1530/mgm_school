<?php
/**
 * Admin School Settings
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'settings';
$adminTitle = 'School Information & Site Settings';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $allowedKeys = [
            'site_title', 'school_name', 'affiliation_no', 'founder_name',
            'phone_primary', 'phone_secondary', 'email_primary', 'email_secondary',
            'school_address', 'copyright_text', 'facebook_url', 'youtube_url', 'whatsapp_url'
        ];

        $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v) ON DUPLICATE KEY UPDATE setting_value = :v");

        foreach ($allowedKeys as $k) {
            if (isset($_POST[$k])) {
                $val = trim($_POST[$k]);
                $stmt->execute([':k' => $k, ':v' => $val]);
            }
        }

        log_audit("Settings Updated", "Updated school contact and site settings.");
        set_flash('success', "School settings updated successfully.");
        header("Location: " . ADMIN_URL . "/settings.php");
        exit;
    }
}

// Fetch all settings
$settings = [];
$res = $db->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll();
foreach ($res as $r) {
    $settings[$r['setting_key']] = $r['setting_value'];
}

require_once __DIR__ . '/header.php';
?>

<div class="bg-white p-4 p-md-5 rounded-3 border shadow-sm" style="max-width: 900px;">
  <h5 class="fw-bold text-dark mb-4"><i class="fa-solid fa-sliders me-2 text-danger"></i> Configure School & Website Settings</h5>

  <form method="POST" action="">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

    <div class="row g-3 mb-4">
      <div class="col-12"><h6 class="fw-bold text-muted text-uppercase small border-bottom pb-2">Institutional Identification</h6></div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">School Name</label>
        <input type="text" name="school_name" class="form-control" value="<?= e($settings['school_name'] ?? '') ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Affiliation Details</label>
        <input type="text" name="affiliation_no" class="form-control" value="<?= e($settings['affiliation_no'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Founder Name</label>
        <input type="text" name="founder_name" class="form-control" value="<?= e($settings['founder_name'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Website Browser Title</label>
        <input type="text" name="site_title" class="form-control" value="<?= e($settings['site_title'] ?? '') ?>">
      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-12"><h6 class="fw-bold text-muted text-uppercase small border-bottom pb-2">Contact & Location</h6></div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Primary Phone</label>
        <input type="text" name="phone_primary" class="form-control" value="<?= e($settings['phone_primary'] ?? '') ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Secondary Phone</label>
        <input type="text" name="phone_secondary" class="form-control" value="<?= e($settings['phone_secondary'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Primary Email</label>
        <input type="email" name="email_primary" class="form-control" value="<?= e($settings['email_primary'] ?? '') ?>" required>
      </div>

      <div class="col-md-6">
        <label class="form-label fw-semibold small">Secondary Email</label>
        <input type="email" name="email_secondary" class="form-control" value="<?= e($settings['email_secondary'] ?? '') ?>">
      </div>

      <div class="col-12">
        <label class="form-label fw-semibold small">Physical Campus Address</label>
        <textarea name="school_address" class="form-control" rows="2"><?= e($settings['school_address'] ?? '') ?></textarea>
      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-12"><h6 class="fw-bold text-muted text-uppercase small border-bottom pb-2">Footer & Social Links</h6></div>

      <div class="col-12">
        <label class="form-label fw-semibold small">Footer Copyright Text</label>
        <input type="text" name="copyright_text" class="form-control" value="<?= e($settings['copyright_text'] ?? '') ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold small">Facebook Page URL</label>
        <input type="url" name="facebook_url" class="form-control" value="<?= e($settings['facebook_url'] ?? '') ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold small">YouTube Channel URL</label>
        <input type="url" name="youtube_url" class="form-control" value="<?= e($settings['youtube_url'] ?? '') ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold small">WhatsApp URL / Number</label>
        <input type="text" name="whatsapp_url" class="form-control" value="<?= e($settings['whatsapp_url'] ?? '') ?>">
      </div>
    </div>

    <button type="submit" class="btn-admin-primary px-4 py-2">
      <i class="fa-solid fa-floppy-disk me-1"></i> Save All Settings
    </button>
  </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
