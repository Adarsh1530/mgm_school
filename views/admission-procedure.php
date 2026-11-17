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

<!-- Online Admission CTA Hero Card -->
<section class="mgm-admission-portal-banner py-4" style="background: #ffffff;">
  <div class="container custom-container-larg">
    <div class="p-4 p-md-5 rounded-4 shadow text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #ab0c2f 0%, #760920 100%); color: #ffffff;">
      <div style="position: absolute; right: -25px; bottom: -30px; opacity: 0.08; font-size: 180px; pointer-events: none; color: #fff;">
        <i class="fa-solid fa-graduation-cap"></i>
      </div>
      <div class="position-relative" style="z-index: 2;">
        <span class="badge px-3 py-2 text-uppercase mb-3 rounded-pill" style="background: rgba(255,255,255,0.2); color: #ffffff; font-size: 12px; letter-spacing: 1px; font-weight: 700;">
          <i class="fa-solid fa-bell me-1"></i> Admissions Open for Academic Year 2026–2027
        </span>
        <h2 class="text-white fw-bold mb-3" style="font-size: clamp(24px, 3.5vw, 34px); letter-spacing: -0.5px;">Online Admission Application Portal</h2>
        <p class="text-white-50 mb-4 mx-auto" style="max-width: 700px; font-size: 16px; line-height: 1.6;">
          Parents and guardians can now register student admissions directly through our official MGM Model School AMS ERP Portal.
        </p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
          <a href="https://mgmmodel.amserp.in/index.php/user/login/loginguest" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill fw-bold" style="background: #ffffff; color: #ab0c2f; text-decoration: none; font-size: 16px; box-shadow: 0 6px 18px rgba(0,0,0,0.2); transition: transform 0.2s ease, box-shadow 0.2s ease;">
            <span>Apply Online Now (AMS ERP Portal)</span>
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Original Elementor Content & Accordions -->
<?= render_content($page['content_html']) ?>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
