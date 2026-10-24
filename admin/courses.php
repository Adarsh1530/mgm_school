<?php
/**
 * Admin Courses & Curriculum Management
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'courses';
$adminTitle = 'Courses & Curriculum Management';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            $classLevel = trim($_POST['class_level'] ?? '');
            $streamName = trim($_POST['stream_name'] ?? '');
            $subjects = trim($_POST['subjects'] ?? '');
            $sort = (int)($_POST['sort_order'] ?? 0);

            if (empty($classLevel) || empty($subjects)) {
                set_flash('error', 'Please provide Class Level and Subjects.');
            } else {
                $ins = $db->prepare("INSERT INTO courses (class_level, stream_name, subjects, sort_order) VALUES (:cl, :sn, :sub, :so)");
                $ins->execute([
                    ':cl'  => $classLevel,
                    ':sn'  => $streamName,
                    ':sub' => $subjects,
                    ':so'  => $sort
                ]);
                log_audit("Course Stream Added", "Added stream: {$classLevel} - {$streamName}");
                set_flash('success', "Course stream added successfully.");
            }
            header("Location: " . ADMIN_URL . "/courses.php");
            exit;
        }

        if ($action === 'delete') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $db->exec("DELETE FROM courses WHERE id = {$id}");
                log_audit("Course Stream Deleted", "Deleted stream ID {$id}");
                set_flash('success', "Stream deleted.");
            }
            header("Location: " . ADMIN_URL . "/courses.php");
            exit;
        }
    }
}

$courses = $db->query("SELECT * FROM courses ORDER BY sort_order ASC, id ASC")->fetchAll();

require_once __DIR__ . '/header.php';
?>

<div class="row g-4">
  
  <!-- Add Stream Form -->
  <div class="col-lg-4">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle me-1 text-danger"></i> Add Class / Stream</h5>

      <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold small">Class Level *</label>
          <input type="text" name="class_level" class="form-control" placeholder="e.g. XI – XII" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Stream / Group Title</label>
          <input type="text" name="stream_name" class="form-control" placeholder="e.g. Group XIII - Science">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold small">Subjects Taught *</label>
          <textarea name="subjects" class="form-control" rows="4" placeholder="List subjects separated by commas..." required></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold small">Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="<?= count($courses) + 1 ?>">
        </div>

        <button type="submit" class="btn-admin-primary w-100 py-2">
          Save Stream
        </button>
      </form>
    </div>
  </div>

  <!-- Courses Table -->
  <div class="col-lg-8">
    <div class="bg-white p-4 rounded-3 border shadow-sm">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Active Subject Matrices (<?= count($courses) ?>)</h5>
        <a href="<?= url('/courses-offered/') ?>" target="_blank" class="btn btn-outline-info btn-sm">
          <i class="fa-solid fa-eye me-1"></i> Live Page
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
          <thead class="table-light">
            <tr>
              <th>Order</th>
              <th>Class</th>
              <th>Stream</th>
              <th>Subjects</th>
              <th class="text-end">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($courses as $c): ?>
              <tr>
                <td class="fw-bold"><?= $c['sort_order'] ?></td>
                <td class="fw-bold text-dark"><?= e($c['class_level']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= e($c['stream_name']) ?></span></td>
                <td class="small text-muted" style="max-width: 300px;"><?= e($c['subjects']) ?></td>
                <td class="text-end">
                  <form method="POST" action="" style="display: inline-block;" onsubmit="return confirm('Delete this stream entry?');">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
