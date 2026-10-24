<?php
/**
 * Admission Procedure View
 * Exact Visual Recreation of Reference WordPress Website with Authentic Poster
 */
require_once __DIR__ . '/../config/config.php';

$currentSlug = "admission-procedure";
$page = get_page_by_slug($currentSlug);

$pageTitle = $page['title'] ?? "Admission Procedure";
$breadcrumbTitle = $page['breadcrumb_title'] ?? $pageTitle;
$metaDescription = $page['meta_description'] ?? "Admission procedure and eligibility requirements for MGM Model School.";
$wpId = 15998;

// Handle Form Submission if POST
$successMsg = '';
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'admission_enquiry') {
    $db = getDB();
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $grade = trim($_POST['grade_applied'] ?? '');
    $msg = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($phone)) {
        try {
            $stmt = $db->prepare("INSERT INTO enquiries (type, name, email, phone, grade_applied, message, status) VALUES ('admission', :name, :email, :phone, :grade, :msg, 'new')");
            $stmt->execute([
                ':name'  => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':grade' => $grade,
                ':msg'   => $msg
            ]);
            $successMsg = "Thank you! Your admission enquiry has been submitted. Our admissions desk will contact you.";
        } catch (Exception $e) {
            $errorMsg = "An error occurred while saving your enquiry.";
        }
    } else {
        $errorMsg = "Please provide name and phone number.";
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

<!-- Original Elementor Content & Accordions -->
<?= render_content($page['content_html']) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
