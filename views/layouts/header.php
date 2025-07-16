<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($title ?? 'GShoes Shop') ?></title>
    <link rel="icon" href="https://kingshoes.vn/data/upload/media/cua-hang-giay-sneaker-chinh-giay-uy-tin-nhat-den-king-shoes-authenti-hcm-2.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Cho layout flex dọc, footer luôn dưới cùng */
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
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

        /* Header Styles */
        .top-bar {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            padding: 8px 0;
            font-size: 14px;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 500;
            padding: 10px 20px !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107 !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #ffc107;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }

        .user-greeting {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: #000 !important;
            padding: 8px 15px !important;
            border-radius: 20px;
            font-weight: 600;
            margin-right: 10px;
        }

        .btn-cart {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
            color: #000;
        }

        .btn-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .btn-cart:hover::before {
            left: 100%;
        }

        .search-container {
            position: relative;
            max-width: 400px;
            margin: 0 auto;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            color: #fff;
            border-radius: 25px;
            padding: 10px 50px 10px 20px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
            color: #fff;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #ffc107;
            border: none;
            color: #000;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: #ff8f00;
            transform: translateY(-50%) scale(1.1);
        }

        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        }

        .dropdown-item {
            color: #fff;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Animation for mobile menu */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(33, 37, 41, 0.98);
                border-radius: 15px;
                margin-top: 15px;
                padding: 20px;
            }
            
            .navbar-nav .nav-link {
                text-align: center;
                margin: 5px 0;
            }
            
            .search-container {
                margin: 15px 0;
            }
        }

        /* Top bar animations */
        .top-bar-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .social-icon {
            color: #000;
            font-size: 18px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            color: #000;
            transform: scale(1.2);
        }
    </style>

    <!-- Bootstrap JS (kèm Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar text-dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-4">
                        <span class="top-bar-item">
                            <i class="fas fa-phone"></i>
                            <span>Hotline: 1900 1234</span>
                        </span>
                        <span class="top-bar-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@gshoes.com</span>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        <span class="top-bar-item">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Miễn phí vận chuyển đơn > 500k</span>
                        </span>
                        <div class="social-links">
                            <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="?controller=home&action=index">
                <i class="fas fa-shoe-prints me-2"></i>
                GShoes
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Search Bar -->
                <div class="search-container mx-auto my-3 my-lg-0">
                    <form class="position-relative">
                        <input type="text" class="form-control search-input" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Navigation Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=product&action=list">
                            <i class="fas fa-shoe-prints me-1"></i>
                            Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=order&action=history">
                            <i class="fas fa-history me-1"></i>
                            Đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=wishlist&action=view">
                            <i class="fas fa-heart me-1"></i>
                            Yêu thích
                        </a>
                    </li>
                </ul>

                <!-- User Menu -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <?php if (!empty($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-greeting" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                <?= htmlspecialchars($_SESSION['user']['name']) ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="?controller=auth&action=profile">
                                        <i class="fas fa-user me-2"></i>
                                        Trang cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="?controller=order&action=history">
                                        <i class="fas fa-shopping-bag me-2"></i>
                                        Đơn hàng của tôi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="?controller=wishlist&action=view">
                                        <i class="fas fa-heart me-2"></i>
                                        Danh sách yêu thích
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="?controller=auth&action=logout" onclick="return confirm('Bạn muốn đăng xuất?')">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=auth&action=login">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=auth&action=register">
                                <i class="fas fa-user-plus me-1"></i>
                                Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <!-- Cart Button -->
                    <li class="nav-item">
                        <a class="btn btn-cart ms-3 position-relative" href="?controller=cart&action=view">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Giỏ hàng
                            <!-- Cart Badge (uncomment and add logic to show cart count) -->
                            <!-- <span class="cart-badge">3</span> -->
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- JavaScript for enhanced interactions -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Search functionality
        document.querySelector('.search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    window.location.href = `?controller=product&action=search&q=${encodeURIComponent(searchTerm)}`;
                }
            }
        });

        // Add loading animation to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('btn-cart')) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + this.innerHTML;
                }
            });
        });

        // Navbar animation on scroll
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });
    </script>