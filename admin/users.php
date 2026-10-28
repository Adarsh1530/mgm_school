<?php
/**
 * User Roles Management Page
 * Accessible only by Super Admin
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();
require_superadmin();

$user = current_user();
$activePage = 'users';
$adminTitle = 'User Roles Management';

$db = getDB();

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'Session validation expired. Please try again.');
        header("Location: " . ADMIN_URL . "/users.php");
        exit;
    }

    $action = $_POST['action'] ?? '';

    // 1. CREATE USER
    if ($action === 'create') {
        $newUsername = strtolower(trim($_POST['username'] ?? ''));
        $newEmail = strtolower(trim($_POST['email'] ?? ''));
        $newPassword = $_POST['password'] ?? '';
        $newRole = trim($_POST['role'] ?? 'admin');

        $allowedRoles = ['superadmin', 'admin', 'editor'];
        if (!in_array($newRole, $allowedRoles, true)) {
            $newRole = 'admin';
        }

        if (empty($newUsername) || empty($newPassword)) {
            set_flash('error', 'Username and Password are required.');
        } elseif (!preg_match('/^[a-zA-Z0-9_.-]{3,30}$/', $newUsername)) {
            set_flash('error', 'Username must be 3-30 characters long and contain only letters, numbers, dots, underscores, or hyphens.');
        } elseif (!empty($newEmail) && !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            set_flash('error', 'Please provide a valid email address.');
        } elseif (strlen($newPassword) < 6) {
            set_flash('error', 'Password must be at least 6 characters long.');
        } else {
            // Check username or email uniqueness
            $chk = $db->prepare("SELECT id FROM users WHERE username = :u OR (email = :e AND email != '') LIMIT 1");
            $chk->execute([':u' => $newUsername, ':e' => $newEmail]);
            if ($chk->fetch()) {
                set_flash('error', "A user with that username or email address already exists.");
            } else {
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role, created_at, updated_at) 
                                      VALUES (:u, :e, :p, :r, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
                $stmt->execute([
                    ':u' => $newUsername,
                    ':e' => $newEmail ?: ($newUsername . '@mgmschool.edu.in'),
                    ':p' => $passwordHash,
                    ':r' => $newRole
                ]);

                log_audit("Create User", "Super Admin {$user['username']} created user '{$newUsername}' with role '{$newRole}'.");
                set_flash('success', "User '{$newUsername}' was created successfully.");
                header("Location: " . ADMIN_URL . "/users.php");
                exit;
            }
        }
    }

    // 2. UPDATE USER
    elseif ($action === 'update') {
        $editId = (int)($_POST['id'] ?? 0);
        $editEmail = strtolower(trim($_POST['email'] ?? ''));
        $editRole = trim($_POST['role'] ?? 'admin');
        $editPassword = $_POST['password'] ?? '';

        $allowedRoles = ['superadmin', 'admin', 'editor'];
        if (!in_array($editRole, $allowedRoles, true)) {
            $editRole = 'admin';
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $editId]);
        $targetUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$targetUser) {
            set_flash('error', 'User not found.');
        } else {
            // Verify superadmin count before downgrading
            if ($targetUser['role'] === 'superadmin' && $editRole !== 'superadmin') {
                $superCount = (int)$db->query("SELECT COUNT(*) FROM users WHERE role = 'superadmin'")->fetchColumn();
                if ($superCount <= 1) {
                    set_flash('error', 'Cannot change role: At least one Super Admin must always exist in the system.');
                    header("Location: " . ADMIN_URL . "/users.php");
                    exit;
                }
            }

            // Verify email uniqueness
            if (!empty($editEmail)) {
                $chk = $db->prepare("SELECT id FROM users WHERE email = :e AND id != :id LIMIT 1");
                $chk->execute([':e' => $editEmail, ':id' => $editId]);
                if ($chk->fetch()) {
                    set_flash('error', 'That email address is already in use by another user.');
                    header("Location: " . ADMIN_URL . "/users.php");
                    exit;
                }
            }

            if (!empty($editPassword)) {
                if (strlen($editPassword) < 6) {
                    set_flash('error', 'New password must be at least 6 characters long.');
                    header("Location: " . ADMIN_URL . "/users.php");
                    exit;
                }
                $newHash = password_hash($editPassword, PASSWORD_DEFAULT);
                $up = $db->prepare("UPDATE users SET email = :e, role = :r, password_hash = :p, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
                $up->execute([
                    ':e' => $editEmail,
                    ':r' => $editRole,
                    ':p' => $newHash,
                    ':id' => $editId
                ]);
            } else {
                $up = $db->prepare("UPDATE users SET email = :e, role = :r, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
                $up->execute([
                    ':e' => $editEmail,
                    ':r' => $editRole,
                    ':id' => $editId
                ]);
            }

            // If updating self, update current session role as well
            if ($editId === (int)$user['id']) {
                $_SESSION['user_role'] = $editRole;
                $_SESSION['user_email'] = $editEmail;
            }

            log_audit("Update User", "Super Admin {$user['username']} updated user '{$targetUser['username']}'.");
            set_flash('success', "User '{$targetUser['username']}' updated successfully.");
            header("Location: " . ADMIN_URL . "/users.php");
            exit;
        }
    }

    // 3. DELETE USER
    elseif ($action === 'delete') {
        $deleteId = (int)($_POST['id'] ?? 0);

        if ($deleteId === (int)$user['id']) {
            set_flash('error', 'You cannot delete your own currently logged in account.');
        } else {
            $stmt = $db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $deleteId]);
            $targetUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$targetUser) {
                set_flash('error', 'User not found.');
            } elseif ($targetUser['role'] === 'superadmin') {
                $superCount = (int)$db->query("SELECT COUNT(*) FROM users WHERE role = 'superadmin'")->fetchColumn();
                if ($superCount <= 1) {
                    set_flash('error', 'Cannot delete the only Super Admin account.');
                } else {
                    $del = $db->prepare("DELETE FROM users WHERE id = :id");
                    $del->execute([':id' => $deleteId]);
                    log_audit("Delete User", "Super Admin {$user['username']} deleted user '{$targetUser['username']}'.");
                    set_flash('success', "User '{$targetUser['username']}' deleted successfully.");
                }
            } else {
                $del = $db->prepare("DELETE FROM users WHERE id = :id");
                $del->execute([':id' => $deleteId]);
                log_audit("Delete User", "Super Admin {$user['username']} deleted user '{$targetUser['username']}'.");
                set_flash('success', "User '{$targetUser['username']}' deleted successfully.");
            }
        }
        header("Location: " . ADMIN_URL . "/users.php");
        exit;
    }
}

// Fetch all users
$usersList = $db->query("SELECT id, username, email, role, created_at, updated_at FROM users ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

$totalUsers = count($usersList);
$superCount = 0;
$adminCount = 0;
foreach ($usersList as $u) {
    if ($u['role'] === 'superadmin') $superCount++;
    if ($u['role'] === 'admin') $adminCount++;
}

require_once __DIR__ . '/header.php';
?>

<!-- Page Actions Bar -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div class="d-flex align-items-center gap-2">
    <span class="badge bg-danger text-white"><i class="fa-solid fa-lock me-1"></i> Super Admin Only</span>
    <span class="text-muted small">Configure administrator logins, privilege levels, passwords, and user access across MGM Model School.</span>
  </div>
  <div>
    <button type="button" class="btn btn-admin-primary btn-sm px-3 py-2 fw-semibold shadow-sm" data-bs-toggle="collapse" data-bs-target="#addUserCollapse">
      <i class="fa-solid fa-user-plus me-1"></i> Add New User
    </button>
  </div>
</div>

<!-- Quick Stats Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card-metric border">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase">Total Users</span>
          <h3 class="fw-bold my-1 text-dark"><?= $totalUsers ?></h3>
          <span class="text-muted small">Configured Accounts</span>
        </div>
        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
          <i class="fa-solid fa-users fa-2x"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-metric border">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase">Super Admins</span>
          <h3 class="fw-bold my-1 text-danger"><?= $superCount ?></h3>
          <span class="badge bg-danger bg-opacity-10 text-danger fw-bold">Full Portal Access</span>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle">
          <i class="fa-solid fa-shield-halved fa-2x"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card-metric border">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase">School Admins</span>
          <h3 class="fw-bold my-1 text-info"><?= $adminCount ?></h3>
          <span class="badge bg-info bg-opacity-10 text-info fw-bold">Standard Admin Access</span>
        </div>
        <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
          <i class="fa-solid fa-user-shield fa-2x"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add User Collapsible Form -->
<div class="collapse mb-4" id="addUserCollapse">
  <div class="card border shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
      <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-user-plus me-2 text-danger"></i>Create New User Account</h6>
    </div>
    <div class="card-body p-4">
      <form method="POST" action="<?= ADMIN_URL ?>/users.php">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="action" value="create">

        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold small">Username <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control form-control-sm" placeholder="Enter your username" required>
            <div class="form-text small">e.g. jdoe, staff_admin</div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold small">Email Address</label>
            <input type="email" name="email" class="form-control form-control-sm" placeholder="admin@mgmschool.edu.in">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control form-control-sm" placeholder="Enter your password" required minlength="6">
            <div class="form-text small">Minimum 6 characters</div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold small">Role <span class="text-danger">*</span></label>
            <select name="role" class="form-select form-select-sm" required>
              <option value="admin" selected>School Admin (mgmschool access)</option>
              <option value="superadmin">Super Admin (full management)</option>
              <option value="editor">Content Editor</option>
            </select>
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#addUserCollapse">Cancel</button>
          <button type="submit" class="btn btn-admin-primary btn-sm px-3 fw-semibold">
            <i class="fa-solid fa-check me-1"></i> Save &amp; Create Account
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Users List Table -->
<div class="card border shadow-sm rounded-3">
  <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
    <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-list me-2 text-primary"></i>Active Admin Users (<?= $totalUsers ?>)</h6>
    <span class="text-muted small">Access level dynamically enforced upon login</span>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
      <thead class="table-light">
        <tr>
          <th style="width: 60px;" class="text-center">#</th>
          <th>User / Username</th>
          <th>Role / Privileges</th>
          <th>Email Address</th>
          <th>Created</th>
          <th style="width: 140px;" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usersList as $u): ?>
          <tr>
            <td class="text-center text-muted fw-bold">#<?= $u['id'] ?></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: <?= $u['role'] === 'superadmin' ? '#AB0C2F' : '#0B4EA2' ?>; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                  <?= strtoupper(substr($u['username'], 0, 1)) ?>
                </div>
                <div>
                  <span class="fw-bold text-dark"><?= e($u['username']) ?></span>
                  <?php if ((int)$u['id'] === (int)$user['id']): ?>
                    <span class="badge bg-success-subtle text-success ms-1 small fw-semibold">You</span>
                  <?php endif; ?>
                </div>
              </div>
            </td>
            <td>
              <?php if ($u['role'] === 'superadmin'): ?>
                <span class="badge bg-danger text-white px-2 py-1"><i class="fa-solid fa-shield-halved me-1"></i> Super Admin</span>
              <?php elseif ($u['role'] === 'admin'): ?>
                <span class="badge bg-primary text-white px-2 py-1"><i class="fa-solid fa-user-shield me-1"></i> School Admin</span>
              <?php else: ?>
                <span class="badge bg-secondary text-white px-2 py-1"><i class="fa-solid fa-user-pen me-1"></i> Editor</span>
              <?php endif; ?>
            </td>
            <td>
              <span class="text-muted"><?= e($u['email']) ?></span>
            </td>
            <td>
              <span class="text-muted small"><?= date('M d, Y', strtotime($u['created_at'])) ?></span>
            </td>
            <td class="text-center">
              <div class="d-inline-flex gap-1">
                <!-- Edit Button -->
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $u['id'] ?>" title="Edit User">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <!-- Delete Button -->
                <?php if ((int)$u['id'] === (int)$user['id']): ?>
                  <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Cannot delete your own account">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                <?php else: ?>
                  <form method="POST" action="<?= ADMIN_URL ?>/users.php" onsubmit="return confirm('Are you sure you want to delete user \'<?= e($u['username']) ?>\'? This action cannot be undone.');" style="display:inline-block; margin:0;">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                <?php endif; ?>
              </div>

              <!-- Edit Modal -->
              <div class="modal fade" id="editModal<?= $u['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content text-start">
                    <form method="POST" action="<?= ADMIN_URL ?>/users.php">
                      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                      <input type="hidden" name="action" value="update">
                      <input type="hidden" name="id" value="<?= $u['id'] ?>">

                      <div class="modal-header">
                        <h6 class="modal-title fw-bold text-dark">
                          <i class="fa-solid fa-user-gear me-2 text-primary"></i>Edit User: <?= e($u['username']) ?>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label fw-semibold small">Username</label>
                          <input type="text" class="form-control form-control-sm bg-light" value="<?= e($u['username']) ?>" readonly disabled>
                          <div class="form-text small">Usernames are permanent unique identifiers.</div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold small">Email Address</label>
                          <input type="email" name="email" class="form-control form-control-sm" value="<?= e($u['email']) ?>" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold small">Role / Privileges</label>
                          <select name="role" class="form-select form-select-sm" required>
                            <option value="superadmin" <?= $u['role'] === 'superadmin' ? 'selected' : '' ?>>Super Admin (full management)</option>
                            <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>School Admin (mgmschool access)</option>
                            <option value="editor" <?= $u['role'] === 'editor' ? 'selected' : '' ?>>Content Editor</option>
                          </select>
                          <div class="form-text small">School Admins cannot view or access this User Roles Management section.</div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold small">New Password (optional)</label>
                          <input type="password" name="password" class="form-control form-control-sm" placeholder="Leave blank to keep existing password" minlength="6">
                          <div class="form-text small">Enter a new password only if you wish to reset it (min 6 characters).</div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-admin-primary btn-sm px-3 fw-semibold">Save Changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
