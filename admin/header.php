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
  <title><?= e($adminTitle ?? 'Admin Dashboard') ?> – MGM Model School Portal</title>
  
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
    html, body {
      height: 100%;
      height: 100dvh;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: #F8F9FA;
      color: #374151;
      height: 100vh;
      height: 100dvh;
      width: 100%;
      overflow: hidden;
      display: flex;
    }
    .admin-sidebar {
      width: 260px;
      background-color: var(--admin-sidebar);
      color: #9CA3AF;
      flex-shrink: 0;
      height: 100vh;
      height: 100dvh;
      position: sticky;
      top: 0;
      display: flex;
      flex-direction: column;
      z-index: 1000;
      transition: transform 0.3s ease, left 0.3s ease;
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
      font-size: 15px;
      letter-spacing: 0.2px;
      white-space: nowrap;
    }
    .admin-menu {
      list-style: none;
      padding: 18px 12px;
      margin: 0;
      flex-grow: 1;
      overflow-y: auto;
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
      flex: 1 1 auto;
      min-width: 0;
      height: 100vh;
      height: 100dvh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      position: relative;
    }
    .admin-topbar {
      flex-shrink: 0;
      background-color: #ffffff;
      border-bottom: 1px solid var(--admin-border);
      padding: 14px 28px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 10;
    }
    .admin-main {
      padding: 24px 28px 36px 28px;
      flex: 1 1 auto;
      min-height: 0;
      overflow-y: auto;
      overflow-x: hidden;
    }
    /* Uniform Bottom Bar Height & Alignment for both Sidebar and Footer */
    .admin-sidebar-footer {
      height: 60px;
      min-height: 60px;
      max-height: 60px;
      flex-shrink: 0;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
      padding: 0 16px;
      display: flex;
      align-items: center;
      box-sizing: border-box;
    }
    .admin-sidebar-footer .btn {
      height: 38px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 500;
      padding: 0 12px;
      margin: 0;
    }

    .admin-footer {
      height: 60px;
      min-height: 60px;
      max-height: 60px;
      flex-shrink: 0;
      background-color: #ffffff;
      border-top: 1px solid var(--admin-border);
      padding: 0 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: #6B7280;
      font-size: 13px;
      box-sizing: border-box;
      z-index: 20;
    }
    .admin-footer a {
      color: var(--admin-primary);
      text-decoration: none;
      font-weight: 700;
      transition: color 0.15s ease, text-decoration 0.15s ease;
    }
    .admin-footer a:hover {
      color: var(--admin-primary-dark);
      text-decoration: underline;
    }
    .admin-footer-text {
      flex: 1;
      min-width: 0;
      line-height: 1.4;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .admin-footer-brand {
      flex-shrink: 0;
      display: inline-flex;
      align-items: center;
      margin-left: 20px;
    }
    .sparkit-footer-logo-link {
      display: inline-flex;
      align-items: center;
      text-decoration: none !important;
      line-height: 1;
      border-radius: 4px;
      transition: transform 0.2s ease, opacity 0.2s ease;
    }
    .sparkit-footer-logo-link:hover {
      transform: scale(1.04);
      opacity: 0.95;
    }
    .sparkit-footer-logo-video {
      height: 54px;
      width: auto;
      max-width: 115px;
      object-fit: contain;
      mix-blend-mode: multiply;
      display: block;
      border-radius: 4px;
      background: transparent;
      pointer-events: none;
    }

    /* Mobile & Tablet Responsiveness */
    @media (max-width: 991.98px) {
      .admin-sidebar {
        position: fixed;
        left: -260px;
        top: 0;
        bottom: 0;
        height: 100vh;
        height: 100dvh;
        z-index: 1050;
        box-shadow: 4px 0 20px rgba(0,0,0,0.3);
      }
      .admin-sidebar.show {
        left: 0;
      }
      .admin-sidebar-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1040;
      }
      .admin-sidebar-backdrop.show {
        display: block;
      }
      .admin-topbar {
        padding: 12px 16px;
      }
      .admin-main {
        padding: 16px 16px 28px 16px;
      }
      .admin-footer {
        padding: 0 16px;
      }
    }
    @media (max-width: 767.98px) {
      .admin-footer {
        height: auto;
        min-height: 60px;
        max-height: none;
        padding: 10px 16px;
        gap: 12px;
      }
      .admin-footer-text {
        white-space: normal;
        font-size: 11.5px;
      }
      .admin-footer-brand {
        margin-left: 8px;
      }
      .sparkit-footer-logo-video {
        height: 38px;
        max-width: 85px;
      }
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
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-brand">
      <img src="<?= asset_url('images/new-mgm-logo.png') ?>" alt="MGM Crest">
      <div>
        <span>MGM Model School</span>
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
        <a href="<?= ADMIN_URL ?>/gallery.php"><i class="fa-solid fa-images"></i> Image & Gallery Upload</a>
      </li>
      <li class="<?= $activePage === 'popup' ? 'active' : '' ?>">
        <a href="<?= ADMIN_URL ?>/popup.php"><i class="fa-solid fa-window-restore"></i> Popup Notification</a>
      </li>
      <?php if (($user['role'] ?? '') === 'superadmin'): ?>
        <li class="<?= $activePage === 'users' ? 'active' : '' ?>">
          <a href="<?= ADMIN_URL ?>/users.php"><i class="fa-solid fa-users-gear"></i> User Roles Management</a>
        </li>
      <?php endif; ?>
    </ul>

    <div class="admin-sidebar-footer">
      <a href="<?= url('/') ?>" target="_blank" class="btn btn-outline-light btn-sm w-100">
        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Site
      </a>
    </div>
  </aside>

  <!-- Mobile Sidebar Backdrop Overlay -->
  <div class="admin-sidebar-backdrop" id="sidebarBackdrop"></div>

  <!-- Admin Main Content Wrap -->
  <div class="admin-content-wrap">
    
    <!-- Top Header -->
    <header class="admin-topbar">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" id="sidebarToggle" aria-label="Toggle navigation" style="padding: 4px 10px;">
          <i class="fa-solid fa-bars"></i>
        </button>
        <h5 class="fw-bold mb-0 text-dark"><?= e($adminTitle ?? 'Dashboard') ?></h5>
      </div>
      <div class="d-flex align-items-center gap-3">
        <?php
          $roleRaw = $user['role'] ?? 'admin';
          $roleBadge = ($roleRaw === 'superadmin') ? 'Super Admin' : (($roleRaw === 'admin') ? 'School Admin' : ucfirst($roleRaw));
        ?>
        <span class="text-muted small">Signed in as <b><?= e($user['username']) ?></b> (<span class="badge <?= $roleRaw === 'superadmin' ? 'bg-danger' : 'bg-primary' ?> text-white fw-bold"><?= e($roleBadge) ?></span>)</span>
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
