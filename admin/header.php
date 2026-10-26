<?php
/**
 * Admin Panel Header
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();
$user = current_user();
$activePage = $activePage ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($adminTitle ?? 'Admin Dashboard') ?> – MGM School Portal</title>
  
  <link rel="icon" type="image/png" href="<?= asset_url('images/new-mgm-logo.png') ?>">

  <!-- Google Fonts: DM Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="<?= asset_url('css/bootstrap.css') ?>">

  <style>
    :root {
      --admin-primary: #AB0C2F;
      --admin-primary-dark: #8c0926;
      --admin-dark: #12141A;
      --admin-sidebar: #1A1D24;
      --admin-border: #E5E7EB;
    }
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: #F8F9FA;
      color: #374151;
      margin: 0;
      min-height: 100vh;
      display: flex;
    }
    .admin-sidebar {
      width: 260px;
      background-color: var(--admin-sidebar);
      color: #9CA3AF;
      flex-shrink: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .admin-brand {
      padding: 18px 22px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .admin-brand img {
      width: 44px;
      height: 44px;
      object-fit: contain;
      background: #ffffff;
      border-radius: 50%;
      padding: 3px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    }
    .admin-brand span {
      color: #ffffff;
      font-weight: 700;
      font-size: 16px;
      letter-spacing: 0.3px;
    }
    .admin-menu {
      list-style: none;
      padding: 18px 12px;
      margin: 0;
      flex-grow: 1;
    }
    .admin-menu li {
      margin-bottom: 6px;
    }
    .admin-menu a {
      color: #9CA3AF;
      text-decoration: none;
      padding: 12px 16px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 500;
      font-size: 14.5px;
      transition: all 0.2s;
    }
    .admin-menu a:hover {
      background-color: rgba(171, 12, 47, 0.15);
      color: #ffffff;
    }
    .admin-menu li.active a {
      background-color: var(--admin-primary);
      color: #ffffff;
      box-shadow: 0 4px 10px rgba(171, 12, 47, 0.3);
    }
    .admin-content-wrap {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }
    .admin-topbar {
      background-color: #ffffff;
      border-bottom: 1px solid var(--admin-border);
      padding: 14px 28px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .admin-main {
      padding: 28px;
      flex-grow: 1;
    }
    .card-metric {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid var(--admin-border);
      padding: 22px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.02);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-metric:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }
    .btn-admin-primary {
      background-color: var(--admin-primary);
      color: #ffffff;
      border: none;
      font-weight: 600;
      padding: 8px 18px;
      border-radius: 6px;
      transition: background 0.2s;
    }
    .btn-admin-primary:hover {
      background-color: var(--admin-primary-dark);
      color: #ffffff;
    }
    .table-admin {
      background: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid var(--admin-border);
    }
  </style>
</head>
<body>

  <!-- Admin Sidebar -->
  <aside class="admin-sidebar">
    <div class="admin-brand">
      <img src="<?= asset_url('images/new-mgm-logo.png') ?>" alt="MGM Crest">
      <div>
        <span>MGM School</span>
        <div style="font-size: 11px; color: #9CA3AF;">Admin Portal</div>
      </div>
    </div>

    <ul class="admin-menu">
      <li class="<?= $activePage === 'dashboard' ? 'active' : '' ?>">
        <a href="<?= ADMIN_URL ?>/"><i class="fa-solid fa-gauge"></i> Dashboard</a>
      </li>
      <li class="<?= $activePage === 'notices' ? 'active' : '' ?>">
        <a href="<?= ADMIN_URL ?>/notices.php"><i class="fa-solid fa-bullhorn"></i> Notice Management</a>
      </li>
      <li class="<?= $activePage === 'disclosures' ? 'active' : '' ?>">
        <a href="<?= ADMIN_URL ?>/disclosures.php"><i class="fa-solid fa-file-pdf"></i> Mandatory Disclosures</a>
      </li>
      <li class="<?= $activePage === 'gallery' ? 'active' : '' ?>">
        <a href="<?= ADMIN_URL ?>/gallery.php"><i class="fa-solid fa-images"></i> Gallery Management</a>
      </li>
      <li class="<?= $activePage === 'popup' ? 'active' : '' ?>">
        <a href="<?= ADMIN_URL ?>/popup.php"><i class="fa-solid fa-window-restore"></i> Popup Notification</a>
      </li>
    </ul>

    <div class="p-3 border-top border-secondary">
      <a href="<?= url('/') ?>" target="_blank" class="btn btn-outline-light btn-sm w-100 py-2">
        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Site
      </a>
    </div>
  </aside>

  <!-- Admin Main Content Wrap -->
  <div class="admin-content-wrap">
    
    <!-- Top Header -->
    <header class="admin-topbar">
      <div>
        <h5 class="fw-bold mb-0 text-dark"><?= e($adminTitle ?? 'Dashboard') ?></h5>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span class="text-muted small">Signed in as <b><?= e($user['username']) ?></b> (<?= e($user['role']) ?>)</span>
        <a href="<?= ADMIN_URL ?>/logout.php" class="btn btn-outline-danger btn-sm">
          <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
        </a>
      </div>
    </header>

    <!-- Main Content Body -->
    <main class="admin-main">
      <?php $flash = get_flash(); if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : 'success' ?> alert-dismissible fade show mb-4" role="alert">
          <?= e($flash['message']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
