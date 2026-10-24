<?php
/**
 * Alumni View
 * Exact Visual Recreation of Reference WordPress Website with Interactive Alumni Registration
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "alumni";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Alumni";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "MGM Model School Alumni Association";
$wpId = 15992;

$successMsg = '';
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'alumni_join') {
    $db = getDB();
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $year = trim($_POST['passing_year'] ?? '');
    $prof = trim($_POST['profession'] ?? '');

    if (!empty($name) && !empty($phone)) {
        try {
            $stmt = $db->prepare("INSERT INTO enquiries (type, name, email, phone, passing_year, profession, status) VALUES ('alumni', :name, :email, :phone, :yr, :prof, 'new')");
            $stmt->execute([
                ':name'  => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':yr'    => $year,
                ':prof'  => $prof
            ]);
            $successMsg = "Thank you! You have successfully registered with the MGM Model School Alumni Network.";
        } catch (Exception $e) {
            $errorMsg = "An error occurred while saving your details.";
        }
    } else {
        $errorMsg = "Please provide your name and phone number.";
    }
}

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/breadcrumb.php';
?>

<?php if (!empty($successMsg)): ?>
  <div class="container my-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fa-solid fa-circle-check me-2"></i> <?= e($successMsg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>
<?php endif; ?>
<?php if (!empty($errorMsg)): ?>
  <div class="container my-3">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= e($errorMsg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>
<?php endif; ?>

<!-- Original Elementor Content -->
<?= render_content($page['content_html']) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
