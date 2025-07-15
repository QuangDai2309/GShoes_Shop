<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($title ?? 'GShoes Shop') ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons (nếu dùng icon bootstrap) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        /* Cho layout flex dọc, footer luôn dưới cùng */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #main-content {
            flex: 1 0 auto;
            /* phần nội dung chính mở rộng */
        }

        footer {
            flex-shrink: 0;
            /* footer không bị co lại */
        }
    </style>

    <!-- Bootstrap JS (kèm Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-warning fw-bold" href="?controller=home&action=index">GShoes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="?controller=product&action=list">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="?controller=order&action=history">Đơn hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="?controller=wishlist&action=view">Yêu thích</a></li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <?php if (!empty($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <span class="nav-link">Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></span>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="?controller=auth&action=profile">Trang cá nhân</a></li>
                        <li class="nav-item"><a class="nav-link" href="?controller=auth&action=logout" onclick="return confirm('Bạn muốn đăng xuất?')">Đăng xuất</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="?controller=auth&action=login">Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link" href="?controller=auth&action=register">Đăng ký</a></li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="btn btn-warning ms-3" href="?controller=cart&action=view">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>