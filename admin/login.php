<?php
/**
 * Admin Login Page
 * MGM Model School Recreation Project
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// If already logged in, redirect to dashboard
if (is_logged_in()) {
    if (!empty($_SESSION['flash']) && strpos($_SESSION['flash']['message'] ?? '', 'Please log in') !== false) {
        unset($_SESSION['flash']);
    }
    header("Location: " . ADMIN_URL . "/");
    exit;
}

$error = '';
$flash = get_flash();
if ($flash && ($flash['type'] ?? '') === 'error') {
    $error = $flash['message'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = "Session validation expired. Please try again.";
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = "Please enter both username and password.";
        } else {
            try {
                $db = getDB();
                $stmt = $db->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
                $stmt->execute([':u' => $username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password_hash'])) {
                    // Wipe any stale flash messages before entering dashboard
                    unset($_SESSION['flash']);

                    // Regenerate session id to protect against session fixation
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];

                    // Issue persistent 14-day authentication token
                    issue_admin_token($user);

                    log_audit("User Login", "Admin user {$user['username']} logged in successfully.");

                    header("Location: " . ADMIN_URL . "/");
                    exit;
                } else {
                    $error = "Invalid username or password.";
                    log_audit("Failed Login Attempt", "Attempted username: {$username}");
                }
            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                $error = "An error occurred during authentication.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login – MGM Model School</title>
  
  <link rel="icon" type="image/png" href="<?= asset_url('images/new-mgm-logo.png') ?>">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?= asset_url('css/bootstrap.css') ?>">

  <style>
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: #12141A;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 20px;
    }
    .login-box {
      width: 100%;
      max-width: 420px;
      background: #ffffff;
      border-radius: 12px;
      padding: 36px 32px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    .btn-login {
      background-color: #AB0C2F;
      color: #ffffff;
      font-weight: 600;
      padding: 12px;
      border-radius: 6px;
      border: none;
      width: 100%;
      transition: background 0.2s;
    }
    .btn-login:hover {
      background-color: #8c0926;
      color: #ffffff;
    }
  </style>
</head>
<body>

  <div class="login-box">
    
    <div class="text-center mb-4">
      <img src="<?= asset_url('images/new-mgm-logo.png') ?>" alt="MGM Crest" style="max-height: 70px;">
      <h4 class="fw-bold text-dark mt-3 mb-1">MGM Model School</h4>
      <p class="text-muted small">Content Management Portal</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2 small" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= e($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

      <div class="mb-3">
        <label class="form-label fw-semibold text-dark small">Username</label>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="username" class="form-control" placeholder="Enter your username" required autofocus value="<?= e($_POST['username'] ?? '') ?>">
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold text-dark small">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
      </div>

      <button type="submit" class="btn-login mb-3">
        <i class="fa-solid fa-right-to-bracket me-1"></i> Sign In to Portal
      </button>

      <div class="text-center">
        <a href="<?= url('/') ?>" class="text-muted small text-decoration-none">
          <i class="fa-solid fa-arrow-left me-1"></i> Back to MGM Website
        </a>
      </div>
    </form>

  </div>

</body>
</html>
