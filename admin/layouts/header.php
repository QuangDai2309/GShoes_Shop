<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['admin_user'] ?? null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
        }
        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: #fff;
            flex-shrink: 0;
            position: fixed;
            top: 0; bottom: 0;
            overflow-y: auto;
        }
        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 12px 16px;
            font-weight: 500;
        }
        .sidebar a.active, .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .logo {
            font-size: 22px;
            font-weight: 700;
            padding: 20px 16px;
            background-color: #212529;
            text-align: center;
        }
        .main-wrapper {
            margin-left: 220px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header.admin-header {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 15px;
            font-weight: 500;
            font-size: 14px;
        }
        header.admin-header .user-info i {
            margin-right: 6px;
            color: #495057;
        }
        main.admin-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
        footer.admin-footer {
            background-color: #fff;
            padding: 10px 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <nav class="sidebar">
        <div class="logo">👑 Admin</div>
        <a href="index.php?controller=dashboard&action=index" class="<?= ($_GET['controller'] ?? '') === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
        <a href="index.php?controller=order&action=index" class="<?= ($_GET['controller'] ?? '') === 'order' ? 'active' : '' ?>">Đơn hàng</a>
        <a href="index.php?controller=product&action=index" class="<?= ($_GET['controller'] ?? '') === 'product' ? 'active' : '' ?>">Sản phẩm</a>
        <a href="index.php?controller=category&action=index" class="<?= ($_GET['controller'] ?? '') === 'category' ? 'active' : '' ?>">Danh mục</a>
        <a href="index.php?controller=user&action=index" class="<?= ($_GET['controller'] ?? '') === 'user' ? 'active' : '' ?>">Người dùng</a>
        <a href="index.php?controller=auth&action=logout">Đăng xuất</a>
    </nav>
    <div class="main-wrapper">
        <header class="admin-header">
            <div class="user-info">
                <i class="bi bi-person-circle"></i>
                <?= htmlspecialchars($user['name'] ?? 'Admin') ?>
            </div>
        </header>
        <main class="admin-content">
