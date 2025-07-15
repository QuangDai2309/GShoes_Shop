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
                            <!-- Bỏ nút xem chi tiết bên này -->
                            <!-- <a href="?controller=product&action=detail&id=<?= $product['id'] ?>" class="btn btn-outline-warning rounded-pill">Xem chi tiết</a> -->
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
</div>

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
        /* ẩn mặc định */
        align-items: center;
        justify-content: center;
        flex-direction: column;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
    }

    .product-card:hover .product-overlay {
        display: flex;
        /* hiện khi hover */
        opacity: 1;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>