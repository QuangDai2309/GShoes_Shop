<?php
$title = 'Trang Chủ - GShoes Shop';
require_once __DIR__ . '/../layouts/header.php';

// Giả sử $featuredProducts lấy từ database
?>

<div class="container-fluid px-0">
    <!-- Hero Section with Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=1920&q=80" class="d-block w-100" alt="Banner 1" style="object-fit: cover; height: 600px;">
                <div class="carousel-caption">
                    <h1 class="display-4 fw-bold text-warning">Ưu đãi mùa hè</h1>
                    <p class="lead">Giảm giá đến 30% cho các mẫu giày mới!</p>
                    <a href="#products" class="btn btn-warning btn-lg mt-3">Mua ngay</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1920&q=80" class="d-block w-100" alt="Banner 2" style="object-fit: cover; height: 600px;">
                <div class="carousel-caption">
                    <h1 class="display-4 fw-bold text-warning">Giày thể thao chính hãng</h1>
                    <p class="lead">Thoải mái vận động với phong cách thời thượng</p>
                    <a href="#products" class="btn btn-warning btn-lg mt-3">Khám phá</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1509475826633-fed577a2c71b?auto=format&fit=crop&w=1920&q=80" class="d-block w-100" alt="Banner 3" style="object-fit: cover; height: 600px;">
                <div class="carousel-caption">
                    <h1 class="display-4 fw-bold text-warning">Phong cách sành điệu</h1>
                    <p class="lead">Khám phá bộ sưu tập mới nhất của chúng tôi</p>
                    <a href="#products" class="btn btn-warning btn-lg mt-3">Xem ngay</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Tiếp</span>
        </button>
    </div>

    <!-- Why Choose Us Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 text-warning fw-bold">Tại Sao Chọn GShoes Shop?</h2>
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="text-center feature-item">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">Miễn Phí Vận Chuyển</h5>
                        <p class="text-muted">Miễn phí ship cho đơn hàng trên 500.000₫</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center feature-item">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">Bảo Hành Chính Hãng</h5>
                        <p class="text-muted">Bảo hành 12 tháng cho tất cả sản phẩm</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center feature-item">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-undo text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">Đổi Trả Dễ Dàng</h5>
                        <p class="text-muted">Đổi trả trong 30 ngày nếu không hài lòng</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center feature-item">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold">Hỗ Trợ 24/7</h5>
                        <p class="text-muted">Tư vấn và hỗ trợ khách hàng 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="container my-5">
        <h2 class="text-center mb-5 text-warning fw-bold">Sản Phẩm Mới nhất</h2>
        <div class="row g-4">
            <?php foreach ($latest as $product): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative product-card">
                        <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: cover; height: 250px;">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text fw-bold text-danger"><?= number_format($product['price']) ?>₫</p>
                        </div>
                        <div class="product-overlay d-flex flex-column gap-2">
                            <a href="?controller=cart&action=add&id=<?= $product['id'] ?>" class="btn btn-warning rounded-pill">Mua ngay</a>
                            <a href="?controller=product&action=detail&id=<?= $product['id'] ?>" class="btn btn-outline-warning rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="container my-5">
        <h2 class="text-center mb-5 text-warning fw-bold">Sản Phẩm Nổi Bật</h2>
        <div class="row g-4">
            <?php foreach ($featured as $product): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative product-card">
                        <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: cover; height: 250px;">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text fw-bold text-danger"><?= number_format($product['price']) ?>₫</p>
                        </div>
                        <div class="product-overlay d-flex flex-column gap-2">
                            <a href="?controller=cart&action=add&id=<?= $product['id'] ?>" class="btn btn-warning rounded-pill">Mua ngay</a>
                            <a href="?controller=product&action=detail&id=<?= $product['id'] ?>" class="btn btn-outline-warning rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products" class="container my-5">
        <h2 class="text-center mb-5 text-warning fw-bold">Sản Phẩm Yêu Thích</h2>
        <div class="row g-4">
            <?php foreach ($favorite as $product): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card h-100 border-0 shadow-lg overflow-hidden position-relative product-card">
                        <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: cover; height: 250px;">
                        <div class="card-body text-center">
                            <h5 class="card-title text-warning"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text fw-bold text-danger"><?= number_format($product['price']) ?>₫</p>
                        </div>
                        <div class="product-overlay d-flex flex-column gap-2">
                            <a href="?controller=cart&action=add&id=<?= $product['id'] ?>" class="btn btn-warning rounded-pill">Mua ngay</a>
                            <a href="?controller=product&action=detail&id=<?= $product['id'] ?>" class="btn btn-outline-warning rounded-pill">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Brand Partners Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 text-warning fw-bold">Thương Hiệu Đối Tác</h2>
            <div class="row align-items-center justify-content-center g-4">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-item text-center">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Nike-Logo.png" alt="Nike" class="img-fluid brand-logo">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-item text-center">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Adidas-Logo.png" alt="Adidas" class="img-fluid brand-logo">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-item text-center">
                        <img src="https://www.logo.wine/a/logo/Puma_(brand)/Puma_(brand)-Logo.wine.svg" alt="Puma" class="img-fluid brand-logo">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-item text-center">
                        <img src="https://logos-world.net/wp-content/uploads/2020/06/Converse-Logo.png" alt="Converse" class="img-fluid brand-logo">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-item text-center">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Vans-Logo.png" alt="Vans" class="img-fluid brand-logo">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-item text-center">
                        <img src="https://logos-world.net/wp-content/uploads/2020/09/New-Balance-Logo.png" alt="New Balance" class="img-fluid brand-logo">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 text-warning fw-bold">Danh Mục Sản Phẩm</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="category-card position-relative overflow-hidden rounded-3 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Giày thể thao" style="height: 300px; object-fit: cover;">
                        <div class="category-overlay">
                            <h3 class="text-white fw-bold">Giày Thể Thao</h3>
                            <p class="text-white mb-3">Thoải mái cho mọi hoạt động</p>
                            <a href="?controller=product&action=category&type=sport" class="btn btn-warning rounded-pill">Khám phá</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card position-relative overflow-hidden rounded-3 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Giày công sở" style="height: 300px; object-fit: cover;">
                        <div class="category-overlay">
                            <h3 class="text-white fw-bold">Giày Công Sở</h3>
                            <p class="text-white mb-3">Lịch lãm và chuyên nghiệp</p>
                            <a href="?controller=product&action=category&type=office" class="btn btn-warning rounded-pill">Khám phá</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card position-relative overflow-hidden rounded-3 shadow-lg">
                        <img src="https://images.unsplash.com/photo-1515955656352-a1fa3ffcd111?auto=format&fit=crop&w=500&q=80" class="w-100" alt="Giày thời trang" style="height: 300px; object-fit: cover;">
                        <div class="category-overlay">
                            <h3 class="text-white fw-bold">Giày Thời Trang</h3>
                            <p class="text-white mb-3">Phong cách và cá tính</p>
                            <a href="?controller=product&action=category&type=fashion" class="btn btn-warning rounded-pill">Khám phá</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 text-warning fw-bold">Khách Hàng Nói Gì</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card bg-white p-4 rounded-3 shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" class="rounded-circle me-3" alt="Khách hàng" style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">Nguyễn Văn A</h6>
                                <small class="text-muted">Đã mua 3 đôi giày</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="text-muted mb-0">"Chất lượng giày rất tốt, giao hàng nhanh chóng. Tôi sẽ tiếp tục mua sắm tại GShoes Shop!"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card bg-white p-4 rounded-3 shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" class="rounded-circle me-3" alt="Khách hàng" style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">Trần Thị B</h6>
                                <small class="text-muted">Khách hàng thân thiết</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="text-muted mb-0">"Dịch vụ khách hàng xuất sắc, nhân viên tư vấn nhiệt tình. Giày đúng size và chất lượng tuyệt vời!"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card bg-white p-4 rounded-3 shadow-sm h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=150&q=80" class="rounded-circle me-3" alt="Khách hàng" style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0 fw-bold">Lê Văn C</h6>
                                <small class="text-muted">Mua lần đầu</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="text-muted mb-0">"Lần đầu mua online nhưng rất hài lòng. Giày chính hãng, giá cả hợp lý. Sẽ giới thiệu cho bạn bè!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-warning">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="fw-bold text-dark mb-3">Đăng Ký Nhận Tin Khuyến Mãi</h3>
                    <p class="text-dark mb-0">Nhận ngay thông tin về các sản phẩm mới và ưu đãi đặc biệt</p>
                </div>
                <div class="col-md-6">
                    <form class="d-flex gap-2 mt-3 mt-md-0">
                        <input type="email" class="form-control" placeholder="Nhập email của bạn" required>
                        <button type="submit" class="btn btn-dark px-4">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <h2 class="text-warning fw-bold mb-0 counter" data-target="1000">0</h2>
                        <p class="text-muted mb-0">Sản phẩm</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <h2 class="text-warning fw-bold mb-0 counter" data-target="5000">0</h2>
                        <p class="text-muted mb-0">Khách hàng hài lòng</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <h2 class="text-warning fw-bold mb-0 counter" data-target="50">0</h2>
                        <p class="text-muted mb-0">Thương hiệu</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-item">
                        <h2 class="text-warning fw-bold mb-0 counter" data-target="3">0</h2>
                        <p class="text-muted mb-0">Năm kinh nghiệm</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Back to Top Button -->
<button id="backToTop" class="btn btn-warning position-fixed bottom-0 end-0 m-4 rounded-circle" style="display: none; width: 50px; height: 50px; z-index: 1000;">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Custom CSS -->
<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
    }

    .product-card:hover .product-overlay {
        display: flex;
        opacity: 1;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
    }

    .feature-item {
        transition: transform 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-5px);
    }

    .brand-logo {
        height: 60px;
        filter: grayscale(100%);
        transition: filter 0.3s ease;
    }

    .brand-logo:hover {
        filter: grayscale(0%);
    }

    .category-card {
        transition: transform 0.3s ease;
    }

    .category-card:hover {
        transform: scale(1.05);
    }

    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }

    .testimonial-card {
        transition: transform 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
    }

    .counter {
        font-size: 3rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .carousel-inner {
            height: 400px;
        }

        .carousel-caption h1 {
            font-size: 1.5rem;
        }

        .counter {
            font-size: 2rem;
        }

        .feature-icon i {
            font-size: 2rem !important;
        }
    }
</style>

<!-- Custom JavaScript -->
<script>
    // Back to top button
    window.addEventListener('scroll', function() {
        const backToTop = document.getElementById('backToTop');
        if (window.pageYOffset > 300) {
            backToTop.style.display = 'block';
        } else {
            backToTop.style.display = 'none';
        }
    });

    document.getElementById('backToTop').addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Counter animation
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            element.textContent = Math.floor(current);

            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            }
        }, 20);
    }

    // Trigger counter animation when section is visible
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => {
                    if (!counter.classList.contains('animated')) {
                        animateCounter(counter);
                        counter.classList.add('animated');
                    }
                });
            }
        });
    });

    document.querySelectorAll('.stat-item').forEach(item => {
        observer.observe(item.parentElement);
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>