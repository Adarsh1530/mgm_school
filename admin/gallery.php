<?php
/**
 * Gallery & Image Package Management
 * Exact BVB Manvila Layout & Functional Structure
 * MGM Model School Management Portal
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_login();

$activePage = 'gallery';
$adminTitle = 'Gallery & Image Package Management';

$db = getDB();

// Normalize sort orders to 1..N
function normalize_gallery_positions(PDO $db): void {
    $rows = $db->query("SELECT id FROM gallery ORDER BY sort_order ASC, id DESC")->fetchAll(PDO::FETCH_COLUMN);
    $stmt = $db->prepare("UPDATE gallery SET sort_order = :ord WHERE id = :id");
    $pos = 1;
    foreach ($rows as $id) {
        $stmt->execute([':ord' => $pos, ':id' => $id]);
        $pos++;
    }
}

// Process Upload Helper
function handle_image_upload(array $file): ?string {
    if (empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed) || $file['size'] > 20 * 1024 * 1024) {
        return null;
    }
    $filename = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target = IMAGES_DIR . '/' . $filename;
    if (move_uploaded_file($file['tmp_name'], $target)) {
        return 'assets/images/' . $filename;
    }
    return null;
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        set_flash('error', 'CSRF verification failed.');
        header("Location: " . ADMIN_URL . "/gallery.php");
        exit;
    }

    $action = $_POST['action'] ?? '';

    // 1. ADD NEW GALLERY EVENT (Appears #1 Automatically)
    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $eventDate = trim($_POST['event_date'] ?? date('F d, Y'));
        $displayOrder = max(1, (int)($_POST['display_order'] ?? 1));
        $tags = $_POST['filter_tags'] ?? ['EVENTS'];
        $sections = $_POST['target_sections'] ?? ['MOMENTS (GALLERY)'];
        $primaryCategory = !empty($tags) ? ucfirst(strtolower($tags[0])) : 'Events';

        if (empty($title) || empty($_FILES['main_image']['name'])) {
            set_flash('error', 'Please provide an Event Title and Main Highlight Image.');
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        $mainImgPath = handle_image_upload($_FILES['main_image']);
        if (!$mainImgPath) {
            set_flash('error', 'Failed to upload Main Highlight Image. Only JPG, PNG, and WebP up to 20MB are allowed.');
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        // Sub-images collection (up to 10)
        $subImages = [];

        // Check Quick Batch Upload files
        if (!empty($_FILES['batch_sub_images']['name'][0])) {
            $totalBatch = min(10, count($_FILES['batch_sub_images']['name']));
            for ($i = 0; $i < $totalBatch; $i++) {
                if ($_FILES['batch_sub_images']['error'][$i] === UPLOAD_ERR_OK) {
                    $singleFile = [
                        'name' => $_FILES['batch_sub_images']['name'][$i],
                        'type' => $_FILES['batch_sub_images']['type'][$i],
                        'tmp_name' => $_FILES['batch_sub_images']['tmp_name'][$i],
                        'error' => $_FILES['batch_sub_images']['error'][$i],
                        'size' => $_FILES['batch_sub_images']['size'][$i]
                    ];
                    $subPath = handle_image_upload($singleFile);
                    if ($subPath) {
                        $subImages[] = $subPath;
                    }
                }
            }
        }

        // Individual slot uploads (1..10)
        for ($s = 1; $s <= 10; $s++) {
            if (count($subImages) >= 10) break;
            if (!empty($_FILES["sub_image_{$s}"]['name'])) {
                $subPath = handle_image_upload($_FILES["sub_image_{$s}"]);
                if ($subPath) {
                    $subImages[] = $subPath;
                }
            }
        }

        // Shift existing orders down to make space for position $displayOrder
        $db->prepare("UPDATE gallery SET sort_order = sort_order + 1 WHERE sort_order >= :pos")->execute([':pos' => $displayOrder]);

        $ins = $db->prepare("INSERT INTO gallery (title, subtitle, caption, event_date, image_path, category, filter_tags, target_sections, sub_images, sort_order, is_active) 
            VALUES (:title, :sub, :cap, :ed, :img, :cat, :tags, :sec, :sub_imgs, :ord, 1)");
        $ins->execute([
            ':title'    => $title,
            ':sub'      => $subtitle,
            ':cap'      => $subtitle,
            ':ed'       => $eventDate,
            ':img'      => $mainImgPath,
            ':cat'      => $primaryCategory,
            ':tags'     => json_encode(array_values($tags)),
            ':sec'      => json_encode(array_values($sections)),
            ':sub_imgs' => json_encode(array_values(array_slice($subImages, 0, 10))),
            ':ord'      => $displayOrder
        ]);

        normalize_gallery_positions($db);
        set_flash('success', "Gallery event '{$title}' uploaded successfully as #{$displayOrder}.");
        header("Location: " . ADMIN_URL . "/gallery.php");
        exit;
    }

    // 2. EDIT GALLERY EVENT
    if ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $eventDate = trim($_POST['event_date'] ?? date('F d, Y'));
        $displayOrder = max(1, (int)($_POST['display_order'] ?? 1));
        $tags = $_POST['filter_tags'] ?? ['EVENTS'];
        $sections = $_POST['target_sections'] ?? ['MOMENTS (GALLERY)'];
        $primaryCategory = !empty($tags) ? ucfirst(strtolower($tags[0])) : 'Events';

        $existing = $db->query("SELECT * FROM gallery WHERE id = {$id}")->fetch();
        if (!$existing) {
            set_flash('error', 'Gallery event not found.');
            header("Location: " . ADMIN_URL . "/gallery.php");
            exit;
        }

        // Main Image replacement or keep existing
        $mainImgPath = $existing['image_path'];
        if (!empty($_FILES['main_image']['name'])) {
            $newMain = handle_image_upload($_FILES['main_image']);
            if ($newMain) {
                $mainImgPath = $newMain;
            }
        }

        // Existing sub-images from hidden fields
        $existingSubImages = [];
        if (!empty($_POST['existing_sub_images'])) {
            $raw = is_array($_POST['existing_sub_images']) ? $_POST['existing_sub_images'] : json_decode($_POST['existing_sub_images'], true);
            if (is_array($raw)) {
                $existingSubImages = array_filter($raw, fn($p) => !empty($p));
            }
        }

        // Check if clear all sub-images requested
        if (!empty($_POST['clear_all_sub_images']) && $_POST['clear_all_sub_images'] === '1') {
            $existingSubImages = [];
        }

        // Batch upload
        if (!empty($_FILES['batch_sub_images']['name'][0])) {
            $totalBatch = min(10 - count($existingSubImages), count($_FILES['batch_sub_images']['name']));
            for ($i = 0; $i < $totalBatch; $i++) {
                if ($_FILES['batch_sub_images']['error'][$i] === UPLOAD_ERR_OK) {
                    $singleFile = [
                        'name' => $_FILES['batch_sub_images']['name'][$i],
                        'type' => $_FILES['batch_sub_images']['type'][$i],
                        'tmp_name' => $_FILES['batch_sub_images']['tmp_name'][$i],
                        'error' => $_FILES['batch_sub_images']['error'][$i],
                        'size' => $_FILES['batch_sub_images']['size'][$i]
                    ];
                    $subPath = handle_image_upload($singleFile);
                    if ($subPath) {
                        $existingSubImages[] = $subPath;
                    }
                }
            }
        }

        // Individual slot uploads
        for ($s = 1; $s <= 10; $s++) {
            if (count($existingSubImages) >= 10) break;
            if (!empty($_FILES["sub_image_{$s}"]['name'])) {
                $subPath = handle_image_upload($_FILES["sub_image_{$s}"]);
                if ($subPath) {
                    $existingSubImages[] = $subPath;
                }
            }
        }

        // Reordering: Adjust sort order
        if ($displayOrder !== (int)$existing['sort_order']) {
            $db->prepare("UPDATE gallery SET sort_order = :ord WHERE id = :id")->execute([':ord' => $displayOrder, ':id' => $id]);
        }

        $upd = $db->prepare("UPDATE gallery SET 
            title = :title,
            subtitle = :sub,
            caption = :cap,
            event_date = :ed,
            image_path = :img,
            category = :cat,
            filter_tags = :tags,
            target_sections = :sec,
            sub_images = :sub_imgs,
            sort_order = :ord
            WHERE id = :id");
        $upd->execute([
            ':title'    => $title,
            ':sub'      => $subtitle,
            ':cap'      => $subtitle,
            ':ed'       => $eventDate,
            ':img'      => $mainImgPath,
            ':cat'      => $primaryCategory,
            ':tags'     => json_encode(array_values($tags)),
            ':sec'      => json_encode(array_values($sections)),
            ':sub_imgs' => json_encode(array_values(array_slice($existingSubImages, 0, 10))),
            ':ord'      => $displayOrder,
            ':id'       => $id
        ]);

        normalize_gallery_positions($db);
        set_flash('success', "Gallery event '{$title}' updated successfully.");
        header("Location: " . ADMIN_URL . "/gallery.php");
        exit;
    }

    // 3. REORDER SINGLE EVENT (UP/DOWN or DIRECT VALUE)
    if ($action === 'reorder') {
        $id = (int)($_POST['id'] ?? 0);
        $direction = $_POST['direction'] ?? '';
        $newOrder = isset($_POST['new_order']) ? (int)$_POST['new_order'] : null;

        $current = $db->query("SELECT id, sort_order FROM gallery WHERE id = {$id}")->fetch();
        if ($current) {
            $curOrder = (int)$current['sort_order'];
            if ($direction === 'up' && $curOrder > 1) {
                $targetOrder = $curOrder - 1;
                $db->prepare("UPDATE gallery SET sort_order = :cur WHERE sort_order = :tgt")->execute([':cur' => $curOrder, ':tgt' => $targetOrder]);
                $db->prepare("UPDATE gallery SET sort_order = :tgt WHERE id = :id")->execute([':tgt' => $targetOrder, ':id' => $id]);
            } elseif ($direction === 'down') {
                $targetOrder = $curOrder + 1;
                $db->prepare("UPDATE gallery SET sort_order = :cur WHERE sort_order = :tgt")->execute([':cur' => $curOrder, ':tgt' => $targetOrder]);
                $db->prepare("UPDATE gallery SET sort_order = :tgt WHERE id = :id")->execute([':tgt' => $targetOrder, ':id' => $id]);
            } elseif ($newOrder !== null && $newOrder > 0) {
                $db->prepare("UPDATE gallery SET sort_order = :ord WHERE id = :id")->execute([':ord' => $newOrder, ':id' => $id]);
            }
            normalize_gallery_positions($db);
            set_flash('success', 'Display order updated.');
        }
        header("Location: " . ADMIN_URL . "/gallery.php");
        exit;
    }

    // 4. DELETE SINGLE EVENT
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $item = $db->query("SELECT title FROM gallery WHERE id = {$id}")->fetch();
            $db->prepare("DELETE FROM gallery WHERE id = :id")->execute([':id' => $id]);
            normalize_gallery_positions($db);
            set_flash('success', "Event '{$item['title']}' deleted.");
        }
        header("Location: " . ADMIN_URL . "/gallery.php");
        exit;
    }

    // 5. DELETE ALL PACKAGES
    if ($action === 'delete_all') {
        $db->exec("DELETE FROM gallery");
        set_flash('success', 'All gallery event packages have been removed.');
        header("Location: " . ADMIN_URL . "/gallery.php");
        exit;
    }
}

// Fetch all gallery events
$galleryEvents = $db->query("SELECT * FROM gallery ORDER BY sort_order ASC, id DESC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/header.php';
?>

<!-- Custom Admin Styling for Exact BVB Reference Look -->
<style>
  :root {
    --bvb-navy: #041b3b;
    --bvb-blue: #0f3966;
    --bvb-primary-btn: #0f3966;
    --bvb-light-blue: #eff6ff;
    --bvb-border-blue: #bfdbfe;
    --bvb-badge-green: #dcfce7;
    --bvb-badge-green-text: #15803d;
    --bvb-badge-blue: #e0f2fe;
    --bvb-badge-blue-text: #0369a1;
  }

  .admin-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }
  .admin-page-title {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin: 0;
  }
  .btn-view-public {
    background: #ffffff;
    color: var(--bvb-blue);
    border: 1.5px solid var(--bvb-blue);
    border-radius: 8px;
    font-weight: 600;
    font-size: 13.5px;
    padding: 8px 18px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
  }
  .btn-view-public:hover {
    background: var(--bvb-blue);
    color: #ffffff;
  }

  /* Main Card */
  .bvb-admin-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 26px 28px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 18px rgba(0,0,0,0.03);
  }
  .bvb-card-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 20px;
  }
  .bvb-card-heading {
    font-size: 19px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
  }
  .bvb-top-actions {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .btn-delete-all {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13.5px;
    padding: 8px 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-delete-all:hover {
    background: #fee2e2;
    color: #b91c1c;
  }
  .btn-upload-new {
    background: var(--bvb-primary-btn);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13.5px;
    padding: 9px 20px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: background 0.2s;
  }
  .btn-upload-new:hover {
    background: #092543;
    color: #ffffff;
  }

  /* Rules Callout Box */
  .bvb-rules-box {
    background: var(--bvb-light-blue);
    border: 1px solid var(--bvb-border-blue);
    border-left: 5px solid #2563eb;
    border-radius: 8px;
    padding: 16px 20px;
    margin-bottom: 24px;
  }
  .bvb-rules-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #1e3a8a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
  }
  .bvb-rules-list {
    list-style: none;
    padding-left: 0;
    margin: 0;
    font-size: 13px;
    color: #374151;
    line-height: 1.6;
  }
  .bvb-rules-list li {
    margin-bottom: 4px;
    position: relative;
    padding-left: 14px;
  }
  .bvb-rules-list li::before {
    content: "•";
    position: absolute;
    left: 0;
    color: #2563eb;
    font-weight: bold;
  }

  /* Search & Filter Bar */
  .bvb-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 20px;
  }
  .btn-pill-filter {
    background: var(--bvb-primary-btn);
    color: #ffffff;
    border: none;
    border-radius: 6px;
    padding: 7px 18px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
  }
  .bvb-search-input-wrap {
    position: relative;
    width: 380px;
    max-width: 100%;
  }
  .bvb-search-input {
    width: 100%;
    padding: 8px 16px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13.5px;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
  }
  .bvb-search-input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }

  /* Table */
  .bvb-table-wrap {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
  }
  .bvb-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
  }
  .bvb-table thead tr {
    background-color: var(--bvb-navy);
    color: #ffffff;
  }
  .bvb-table th {
    padding: 14px 16px;
    font-size: 13.5px;
    font-weight: 600;
    letter-spacing: 0.3px;
    border: none;
    white-space: nowrap;
  }
  .bvb-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
  }
  .bvb-table tbody tr:hover {
    background-color: #f8fafc;
  }
  .bvb-table td {
    padding: 14px 16px;
    vertical-align: middle;
    font-size: 13.5px;
  }

  /* Table Specific Badges */
  .order-cell {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .order-input {
    width: 44px;
    padding: 4px 6px;
    text-align: center;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
  }
  .btn-order-arrow {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 1px 4px;
    font-size: 11px;
    line-height: 1;
    display: block;
  }
  .btn-order-arrow:hover {
    color: #111827;
  }
  .table-thumb {
    width: 68px;
    height: 48px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    background: #f1f5f9;
  }
  .event-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 14.5px;
    margin-bottom: 3px;
  }
  .event-details {
    color: #64748b;
    font-size: 12.5px;
    line-height: 1.4;
  }
  .badge-date {
    background: var(--bvb-badge-green);
    color: #166534;
    font-size: 11.5px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
  }
  .badge-subimages {
    background: var(--bvb-badge-green);
    color: var(--bvb-badge-green-text);
    font-size: 11px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: inline-block;
    white-space: nowrap;
  }
  .badge-target-section {
    background: var(--bvb-badge-blue);
    color: var(--bvb-badge-blue-text);
    font-size: 10.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-right: 4px;
    margin-bottom: 4px;
    display: inline-block;
    white-space: nowrap;
  }
  .btn-action-edit {
    color: #0284c7;
    font-weight: 600;
    text-decoration: none;
    margin-right: 12px;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
  }
  .btn-action-edit:hover {
    color: #0369a1;
    text-decoration: underline;
  }
  .btn-action-delete {
    color: #ef4444;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
  }
  .btn-action-delete:hover {
    color: #dc2626;
    text-decoration: underline;
  }

  /* Modal Dialog Styling (Matching BVB Image 2) */
  .modal-dialog-bvb {
    max-width: 760px;
  }
  .modal-header-bvb {
    background: var(--bvb-navy);
    color: #ffffff;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    padding: 16px 24px;
  }
  .modal-header-bvb .modal-title {
    font-size: 16.5px;
    font-weight: 700;
    color: #ffffff;
  }
  .modal-header-bvb .btn-close {
    filter: invert(1);
    opacity: 0.85;
  }
  .bvb-modal-body {
    padding: 24px 28px;
    background: #ffffff;
  }
  .bvb-field-label {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #1f2937;
    margin-bottom: 6px;
    display: block;
  }
  .bvb-input {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 13.5px;
    outline: none;
  }
  .bvb-input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
  }
  .bvb-checkbox-group {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    display: flex;
    flex-wrap: wrap;
    gap: 14px 20px;
  }
  .bvb-checkbox-label {
    font-size: 12.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 0;
  }
  .bvb-upload-panel {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 16px 20px;
    margin-bottom: 20px;
    background: #fafafa;
  }
  .bvb-upload-panel-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
  }
  .sub-images-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
  }
  @media (max-width: 768px) {
    .sub-images-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  .sub-image-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    position: relative;
  }
  .sub-image-card .slot-label {
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .sub-image-thumb-preview {
    width: 100%;
    height: 72px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 6px;
    border: 1px solid #e2e8f0;
  }
  .slot-controls {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-top: 4px;
  }
  .slot-btn {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    padding: 2px 6px;
    font-size: 11px;
    cursor: pointer;
  }
  .slot-btn:hover {
    background: #e2e8f0;
  }
</style>

<!-- Admin Page Header -->
<div class="admin-page-header">
  <h1 class="admin-page-title">Gallery & Image Package Management</h1>
  <a href="<?= url('/gallery/') ?>" target="_blank" class="btn-view-public">
    <i class="fa-solid fa-arrow-up-right-from-square"></i> VIEW PUBLIC WEBSITE
  </a>
</div>

<!-- Main Admin Card -->
<div class="bvb-admin-card">
  
  <div class="bvb-card-topbar">
    <h2 class="bvb-card-heading">Gallery & Image Package Management</h2>
    <div class="bvb-top-actions">
      <form method="POST" action="<?= ADMIN_URL ?>/gallery.php" onsubmit="return confirm('WARNING: Are you sure you want to delete ALL gallery packages? This cannot be undone.');" style="margin:0;">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="action" value="delete_all">
        <button type="submit" class="btn-delete-all">
          <i class="fa-solid fa-trash-can"></i> Delete All Packages
        </button>
      </form>
      <button type="button" class="btn-upload-new" data-bs-toggle="modal" data-bs-target="#uploadEventModal" onclick="resetUploadModal();">
        <i class="fa-solid fa-plus"></i> Upload New Gallery Event
      </button>
    </div>
  </div>

  <!-- Rules Callout Box -->
  <div class="bvb-rules-box">
    <div class="bvb-rules-title">
      <i class="fa-solid fa-camera-retro"></i> Gallery Event & Image Package Rules:
    </div>
    <ul class="bvb-rules-list">
      <li><strong>Event Images:</strong> Upload 1 Main Highlight Image + up to 10 Sub-Images per gallery event.</li>
      <li><strong>Automatic Upload Date Identification:</strong> Uploaded dates are automatically identified and recorded when images are uploaded.</li>
      <li><strong>Automatic Newest-First & Manual Ordering:</strong> Newly uploaded events automatically become #1 (First) on the public Gallery page. Use the ▲ / ▼ buttons or Order # box below to reorder any event manually.</li>
    </ul>
  </div>

  <!-- Filter Pill and Search Bar -->
  <div class="bvb-filter-bar">
    <button type="button" class="btn-pill-filter" id="filterPillAll">
      All Gallery Events (<span id="eventCountDisplay"><?= count($galleryEvents) ?></span>)
    </button>
    <div class="bvb-search-input-wrap">
      <input type="text" id="adminEventSearch" class="bvb-search-input" placeholder="Search events by title, subtitle, or uploaded date.">
    </div>
  </div>

  <!-- Events Data Table -->
  <div class="bvb-table-wrap">
    <table class="bvb-table" id="adminEventsTable">
      <thead>
        <tr>
          <th style="width: 100px; text-align: center;">Order (#)</th>
          <th style="width: 90px; text-align: center;">Main Image</th>
          <th style="width: 30%;">Event Title & Details</th>
          <th style="width: 160px;">Uploaded Date</th>
          <th style="width: 130px; text-align: center;">Sub-Images</th>
          <th style="width: 20%;">Active Target Sections</th>
          <th style="width: 110px; text-align: center;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($galleryEvents)): ?>
          <tr>
            <td colspan="7" class="text-center py-5 text-muted">
              No gallery events found. Click <strong>+ Upload New Gallery Event</strong> above to add your first event.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($galleryEvents as $ev): 
            $subImgs = !empty($ev['sub_images']) ? json_decode($ev['sub_images'], true) : [];
            $subCount = is_array($subImgs) ? count($subImgs) : 0;
            $sections = !empty($ev['target_sections']) ? json_decode($ev['target_sections'], true) : ['MOMENTS (GALLERY)'];
            $eventDateFormatted = !empty($ev['event_date']) ? strtoupper($ev['event_date']) : strtoupper(date('F d, Y', strtotime($ev['created_at'])));
          ?>
            <tr class="event-row" 
                data-id="<?= $ev['id'] ?>"
                data-title="<?= e(strtolower($ev['title'])) ?>"
                data-subtitle="<?= e(strtolower($ev['subtitle'] ?? '')) ?>"
                data-date="<?= e(strtolower($eventDateFormatted)) ?>">
              
              <!-- Order (#) -->
              <td class="text-center">
                <div class="order-cell justify-content-center">
                  <form method="POST" action="<?= ADMIN_URL ?>/gallery.php" style="display:inline-flex; align-items:center; gap:4px; margin:0;">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="action" value="reorder">
                    <input type="hidden" name="id" value="<?= $ev['id'] ?>">
                    <input type="text" name="new_order" class="order-input" value="<?= $ev['sort_order'] ?>" onchange="this.form.submit()">
                    <div style="display:flex; flex-direction:column;">
                      <button type="submit" name="direction" value="up" class="btn-order-arrow" title="Move Up">▲</button>
                      <button type="submit" name="direction" value="down" class="btn-order-arrow" title="Move Down">▼</button>
                    </div>
                  </form>
                </div>
              </td>

              <!-- Main Image -->
              <td class="text-center">
                <img src="<?= asset_url($ev['image_path']) ?>" alt="<?= e($ev['title']) ?>" class="table-thumb" loading="lazy">
              </td>

              <!-- Title & Details -->
              <td>
                <div class="event-title"><?= e($ev['title']) ?></div>
                <div class="event-details"><?= e($ev['subtitle'] ?? $ev['caption'] ?? '') ?></div>
              </td>

              <!-- Uploaded Date -->
              <td>
                <span class="badge-date">
                  <i class="fa-regular fa-calendar"></i> <?= $eventDateFormatted ?>
                </span>
              </td>

              <!-- Sub-Images -->
              <td class="text-center">
                <span class="badge-subimages">
                  <?= $subCount ?> SUB IMAGES
                </span>
              </td>

              <!-- Active Target Sections -->
              <td>
                <?php if (is_array($sections)): ?>
                  <?php foreach ($sections as $sec): ?>
                    <span class="badge-target-section"><?= strtoupper(e($sec)) ?></span>
                  <?php endforeach; ?>
                <?php endif; ?>
              </td>

              <!-- Actions -->
              <td class="text-center">
                <button type="button" class="btn-action-edit" onclick='openEditModal(<?= json_encode($ev, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>);'>
                  Edit
                </button>
                <form method="POST" action="<?= ADMIN_URL ?>/gallery.php" style="display:inline;" onsubmit="return confirm('Delete this gallery event?');">
                  <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $ev['id'] ?>">
                  <button type="submit" class="btn-action-delete">Delete</button>
                </form>
              </td>

            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Upload / Edit Modal Dialog (Exact BVB Image 2 Layout) -->
<div class="modal fade" id="uploadEventModal" tabindex="-1" aria-labelledby="modalEventTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-bvb modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
      
      <!-- Modal Header -->
      <div class="modal-header modal-header-bvb">
        <h5 class="modal-title" id="modalEventTitle">Upload New Gallery Event (Appears #1 Automatically)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Form -->
      <form method="POST" action="<?= ADMIN_URL ?>/gallery.php" enctype="multipart/form-data" id="eventForm">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="action" id="formAction" value="add">
        <input type="hidden" name="id" id="eventId" value="">
        <input type="hidden" name="clear_all_sub_images" id="clearAllSubImagesInput" value="0">

        <div class="modal-body bvb-modal-body">
          
          <!-- Row 1: Title & Subtitle -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="bvb-field-label">EVENT / PACKAGE TITLE *</label>
              <input type="text" name="title" id="fieldTitle" class="bvb-input" required placeholder="e.g. Samskrithi / Annual Sports & Cultural Meet">
            </div>
            <div class="col-md-6">
              <label class="bvb-field-label">SUBTITLE / EVENT LABEL</label>
              <input type="text" name="subtitle" id="fieldSubtitle" class="bvb-input" placeholder="e.g. Celebrated at Campus Grounds">
            </div>
          </div>

          <!-- Row 2: Date & Order -->
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="bvb-field-label">UPLOADED DATE (AUTO-IDENTIFIED)</label>
              <input type="text" name="event_date" id="fieldEventDate" class="bvb-input" value="<?= date('F d, Y') ?>">
            </div>
            <div class="col-md-6">
              <label class="bvb-field-label">DISPLAY ORDER (# POSITION)</label>
              <input type="number" name="display_order" id="fieldDisplayOrder" class="bvb-input" value="1" min="1">
            </div>
          </div>

          <!-- Row 3: Public Gallery Filter Tags (Optional) -->
          <div class="mb-3">
            <label class="bvb-field-label">PUBLIC GALLERY FILTER TAGS (OPTIONAL):</label>
            <div class="bvb-checkbox-group">
              <?php 
                $standardTags = ['EVENTS', 'ACADEMICS', 'SPORTS', 'CULTURE', 'STUDENT LIFE', 'ACHIEVEMENTS', 'COMMUNITY'];
                foreach ($standardTags as $tg):
              ?>
                <label class="bvb-checkbox-label">
                  <input type="checkbox" name="filter_tags[]" value="<?= $tg ?>" class="tag-checkbox" <?= $tg === 'EVENTS' ? 'checked' : '' ?>>
                  <?= $tg ?>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Row 4: Select Public Site Sections For Main Image Highlight -->
          <div class="mb-4">
            <label class="bvb-field-label">SELECT PUBLIC SITE SECTIONS FOR MAIN IMAGE HIGHLIGHT:</label>
            <div class="bvb-checkbox-group">
              <label class="bvb-checkbox-label">
                <input type="checkbox" name="target_sections[]" value="WELCOME TO MGM MODEL SCHOOL" class="section-checkbox">
                WELCOME TO MGM MODEL SCHOOL
              </label>
              <label class="bvb-checkbox-label">
                <input type="checkbox" name="target_sections[]" value="MOMENTS AT SCHOOL (gallery)" class="section-checkbox" checked>
                MOMENTS AT SCHOOL (gallery)
              </label>
              <label class="bvb-checkbox-label">
                <input type="checkbox" name="target_sections[]" value="WHAT'S HAPPENING" class="section-checkbox">
                WHAT'S HAPPENING
              </label>
              <label class="bvb-checkbox-label">
                <input type="checkbox" name="target_sections[]" value="LIFE AT SCHOOL" class="section-checkbox">
                LIFE AT SCHOOL
              </label>
              <label class="bvb-checkbox-label">
                <input type="checkbox" name="target_sections[]" value="A CAMPUS FOR DISCOVERY" class="section-checkbox">
                A CAMPUS FOR DISCOVERY
              </label>
              <label class="bvb-checkbox-label">
                <input type="checkbox" name="target_sections[]" value="ACADEMIC ENVIRONMENT" class="section-checkbox">
                ACADEMIC ENVIRONMENT
              </label>
            </div>
          </div>

          <!-- Section 5: Main Highlight Image -->
          <div class="bvb-upload-panel">
            <div class="bvb-upload-panel-title">
              <span><i class="fa-solid fa-camera"></i> 1. MAIN HIGHLIGHT IMAGE (UPLOAD JPG, PNG, WEBP VIA FILE EXPLORER)</span>
            </div>
            <div class="d-flex align-items-center gap-3">
              <input type="file" name="main_image" id="fieldMainImage" class="form-control" accept="image/jpeg,image/png,image/webp">
              <div id="mainImagePreviewWrap" style="display:none;">
                <img src="" id="mainImagePreview" class="table-thumb" alt="Preview">
              </div>
            </div>
          </div>

          <!-- Section 6: Sub Images (Up to 10) -->
          <div class="bvb-upload-panel">
            <div class="bvb-upload-panel-title">
              <span><i class="fa-solid fa-images"></i> 2. SUB IMAGES (UP TO 10 GALLERY SUB-IMAGES — UPLOAD & REORDER VIA ◀ ▶)</span>
              <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" id="btnClearAllSubImages" onclick="clearAllSubImages();">
                <i class="fa-solid fa-trash-can"></i> Clear All Sub-Images
              </button>
            </div>

            <!-- Batch Upload Input -->
            <div class="p-3 mb-3" style="background:#eff6ff; border:1px dashed #60a5fa; border-radius:8px;">
              <label class="d-flex align-items-center gap-2 mb-2 fw-semibold text-primary" style="font-size:13px;">
                <i class="fa-solid fa-bolt"></i> Quick Batch Upload: Select multiple sub-images at once (up to 10 files):
              </label>
              <input type="file" name="batch_sub_images[]" id="batchSubImagesInput" class="form-control" multiple accept="image/jpeg,image/png,image/webp">
            </div>

            <!-- Grid of 10 Sub-Image Slots -->
            <div class="sub-images-grid" id="subImagesSlotsContainer">
              <?php for ($s = 1; $s <= 10; $s++): ?>
                <div class="sub-image-card" id="subSlot_<?= $s ?>" data-slot="<?= $s ?>">
                  <div class="slot-label">
                    <span>Sub Image <?= $s ?></span>
                    <div class="slot-arrows">
                      <button type="button" class="slot-btn" onclick="moveSubImageSlot(<?= $s ?>, -1);" title="Move left">◀</button>
                      <button type="button" class="slot-btn" onclick="moveSubImageSlot(<?= $s ?>, 1);" title="Move right">▶</button>
                    </div>
                  </div>
                  <img src="" class="sub-image-thumb-preview" id="subThumb_<?= $s ?>" style="display:none;" alt="Sub <?= $s ?>">
                  <input type="hidden" name="existing_sub_images[]" id="existingSubVal_<?= $s ?>" value="">
                  <input type="file" name="sub_image_<?= $s ?>" id="subFileInput_<?= $s ?>" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp" onchange="previewSubFile(this, <?= $s ?>);">
                </div>
              <?php endfor; ?>
            </div>

          </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 14px 24px;">
          <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4" style="background: var(--bvb-primary-btn); border-color: var(--bvb-primary-btn);" id="btnSubmitModal">
            Save Gallery Event
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
// Filter & Search Table
document.getElementById('adminEventSearch').addEventListener('input', function() {
  const query = this.value.toLowerCase().trim();
  const rows = document.querySelectorAll('#adminEventsTable tbody .event-row');
  let visible = 0;
  rows.forEach(r => {
    const title = r.getAttribute('data-title') || '';
    const sub = r.getAttribute('data-subtitle') || '';
    const dt = r.getAttribute('data-date') || '';
    if (!query || title.includes(query) || sub.includes(query) || dt.includes(query)) {
      r.style.display = '';
      visible++;
    } else {
      r.style.display = 'none';
    }
  });
  document.getElementById('eventCountDisplay').textContent = visible;
});

// Modal Logic
function resetUploadModal() {
  document.getElementById('eventForm').reset();
  document.getElementById('formAction').value = 'add';
  document.getElementById('eventId').value = '';
  document.getElementById('modalEventTitle').textContent = 'Upload New Gallery Event (Appears #1 Automatically)';
  document.getElementById('fieldDisplayOrder').value = '1';
  document.getElementById('fieldEventDate').value = '<?= date('F d, Y') ?>';
  document.getElementById('mainImagePreviewWrap').style.display = 'none';
  document.getElementById('mainImagePreview').src = '';
  document.getElementById('fieldMainImage').required = true;
  document.getElementById('clearAllSubImagesInput').value = '0';

  // Clear slot previews and hidden fields
  for (let s = 1; s <= 10; s++) {
    const thumb = document.getElementById('subThumb_' + s);
    const hid = document.getElementById('existingSubVal_' + s);
    const inp = document.getElementById('subFileInput_' + s);
    if (thumb) { thumb.src = ''; thumb.style.display = 'none'; }
    if (hid) hid.value = '';
    if (inp) inp.value = '';
  }
}

function openEditModal(eventData) {
  resetUploadModal();
  document.getElementById('formAction').value = 'edit';
  document.getElementById('eventId').value = eventData.id;
  document.getElementById('modalEventTitle').textContent = 'Edit Gallery Event: ' + eventData.title;
  document.getElementById('fieldTitle').value = eventData.title || '';
  document.getElementById('fieldSubtitle').value = eventData.subtitle || eventData.caption || '';
  document.getElementById('fieldEventDate').value = eventData.event_date || '';
  document.getElementById('fieldDisplayOrder').value = eventData.sort_order || '1';
  document.getElementById('fieldMainImage').required = false;

  // Main Image preview
  if (eventData.image_path) {
    const preview = document.getElementById('mainImagePreview');
    const wrap = document.getElementById('mainImagePreviewWrap');
    preview.src = '<?= BASE_URL ?>/' + eventData.image_path;
    wrap.style.display = 'block';
  }

  // Tags checkboxes
  const rawTags = eventData.filter_tags ? JSON.parse(eventData.filter_tags) : [eventData.category || 'EVENTS'];
  const tagUpper = Array.isArray(rawTags) ? rawTags.map(t => t.toUpperCase()) : [];
  document.querySelectorAll('.tag-checkbox').forEach(cb => {
    cb.checked = tagUpper.includes(cb.value.toUpperCase());
  });

  // Target sections checkboxes
  const rawSec = eventData.target_sections ? JSON.parse(eventData.target_sections) : ['MOMENTS (GALLERY)'];
  const secUpper = Array.isArray(rawSec) ? rawSec.map(s => s.toUpperCase()) : [];
  document.querySelectorAll('.section-checkbox').forEach(cb => {
    cb.checked = secUpper.some(s => s.includes(cb.value.toUpperCase()) || cb.value.toUpperCase().includes(s));
  });

  // Populate sub-images
  if (eventData.sub_images) {
    let subImgs = [];
    try {
      subImgs = JSON.parse(eventData.sub_images);
    } catch(e) {}
    if (Array.isArray(subImgs)) {
      subImgs.forEach((img, idx) => {
        const slotNum = idx + 1;
        if (slotNum <= 10) {
          const thumb = document.getElementById('subThumb_' + slotNum);
          const hid = document.getElementById('existingSubVal_' + slotNum);
          if (thumb) {
            thumb.src = '<?= BASE_URL ?>/' + img;
            thumb.style.display = 'block';
          }
          if (hid) hid.value = img;
        }
      });
    }
  }

  const modal = new bootstrap.Modal(document.getElementById('uploadEventModal'));
  modal.show();
}

function previewSubFile(input, slot) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const thumb = document.getElementById('subThumb_' + slot);
      if (thumb) {
        thumb.src = e.target.result;
        thumb.style.display = 'block';
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function clearAllSubImages() {
  if (confirm('Clear all sub-images for this event?')) {
    document.getElementById('clearAllSubImagesInput').value = '1';
    for (let s = 1; s <= 10; s++) {
      const thumb = document.getElementById('subThumb_' + s);
      const hid = document.getElementById('existingSubVal_' + s);
      const inp = document.getElementById('subFileInput_' + s);
      if (thumb) { thumb.src = ''; thumb.style.display = 'none'; }
      if (hid) hid.value = '';
      if (inp) inp.value = '';
    }
  }
}

function moveSubImageSlot(currentSlot, direction) {
  const targetSlot = currentSlot + direction;
  if (targetSlot < 1 || targetSlot > 10) return;

  const curThumb = document.getElementById('subThumb_' + currentSlot);
  const tgtThumb = document.getElementById('subThumb_' + targetSlot);
  const curHid = document.getElementById('existingSubVal_' + currentSlot);
  const tgtHid = document.getElementById('existingSubVal_' + targetSlot);

  // Swap preview src and display
  const tempSrc = curThumb.src;
  const tempDisp = curThumb.style.display;
  curThumb.src = tgtThumb.src;
  curThumb.style.display = tgtThumb.style.display;
  tgtThumb.src = tempSrc;
  tgtThumb.style.display = tempDisp;

  // Swap hidden value
  const tempVal = curHid.value;
  curHid.value = tgtHid.value;
  tgtHid.value = tempVal;
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
