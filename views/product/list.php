<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../layouts/header.php';
$title = 'Danh Sách Sản Phẩm - GShoes Shop';
?>

<div class="container my-5">
    <!-- Header -->
    <div class="header-section mb-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="page-title">
                    <i class="bi bi-collection me-2"></i>
                    Danh Sách Sản Phẩm
                </h1>
            </div>
            <div class="col-lg-6">
                <div class="user-actions text-end">
                    <?php if (!empty($_SESSION['user'])): ?>
                        <div class="user-info mb-2">
                            <span class="welcome-text">Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></span>
                        </div>
                        <div class="action-buttons">
                            <a href="?controller=auth&action=profile" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-person me-1"></i>Tài khoản
                            </a>
                            <a href="?controller=order&action=history" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-clock-history me-1"></i>Đơn hàng
                            </a>
                            <a href="?controller=wishlist&action=view" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-heart me-1"></i>Yêu thích
                            </a>
                            <a href="?controller=auth&action=logout" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Bạn muốn đăng xuất?')">
                                <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="action-buttons">
                            <a href="?controller=auth&action=register" class="btn btn-outline-warning">
                                <i class="bi bi-person-plus me-1"></i>Đăng ký
                            </a>
                            <a href="?controller=auth&action=login" class="btn btn-warning">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="filter-section mb-4">
        <form method="get" action="?controller=product&action=list" class="filter-form">
            <input type="hidden" name="controller" value="product" />
            <input type="hidden" name="action" value="list" />

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="keyword" class="form-label">
                        <i class="bi bi-search me-1"></i>Tìm kiếm
                    </label>
                    <input type="text" id="keyword" name="keyword" class="form-control"
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                        placeholder="Nhập tên sản phẩm...">
                </div>

                <div class="col-md-2">
                    <label for="min_price" class="form-label">
                        <i class="bi bi-currency-dollar me-1"></i>Giá từ
                    </label>
                    <input type="number" id="min_price" name="min_price" min="0" class="form-control"
                        value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>"
                        placeholder="0">
                </div>

                <div class="col-md-2">
                    <label for="max_price" class="form-label">Đến</label>
                    <input type="number" id="max_price" name="max_price" min="0" class="form-control"
                        value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>"
                        placeholder="Không giới hạn">
                </div>

                <div class="col-md-2">
                    <label for="size" class="form-label">
                        <i class="bi bi-rulers me-1"></i>Size
                    </label>
                    <select id="size" name="size" class="form-select">
                        <option value="">Tất cả size</option>
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?= $size ?>" <?= (isset($_GET['size']) && $_GET['size'] == $size) ? 'selected' : '' ?>>
                                EU <?= $size ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-funnel me-1"></i>Lọc
                        </button>
                        <a href="?controller=product&action=list" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Product List -->
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="text-muted mt-3">Không tìm thấy sản phẩm</h3>
                <p class="text-muted">Vui lòng thử lại với từ khóa khác</p>
                <a href="?controller=product&action=list" class="btn btn-warning">
                    <i class="bi bi-arrow-left me-1"></i>Xem tất cả sản phẩm
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <div class="row g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>">
                                <div class="product-overlay">
                                    <a href="?controller=product&action=detail&id=<?= $product['id'] ?>"
                                        class="btn btn-light btn-sm">
                                        <i class="bi bi-eye me-1"></i>Xem chi tiết
                                    </a>
                                </div>
                            </div>

                            <div class="product-info">
                                <h5 class="product-name"><?= htmlspecialchars($product['name']) ?></h5>
                                <div class="product-price">
                                    <span class="price-current"><?= number_format($product['price']) ?>₫</span>
                                    <span class="price-old"><?= number_format($product['price'] * 1.2) ?>₫</span>
                                </div>

                                <div class="product-actions">
                                    <a href="?controller=wishlist&action=add&product_id=<?= $product['id'] ?>"
                                        class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-heart me-1"></i>Yêu thích
                                    </a>
                                    <a href="?controller=product&action=detail&id=<?= $product['id'] ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-cart-plus me-1"></i>Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="pagination-nav mt-5">
                <div class="pagination-wrapper">
                    <?php
                    $currentPage = $currentPage ?? 1;
                    $queryParams = $_GET;
                    unset($queryParams['page']);

                    // Trang trước
                    if ($currentPage > 1):
                        $queryParams['page'] = $currentPage - 1;
                    ?>
                        <a class="page-btn prev-btn" href="?<?= http_build_query($queryParams) ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <!-- Các số trang -->
                    <?php
                    $start = max(1, $currentPage - 2);
                    $end = min($totalPages, $currentPage + 2);

                    for ($i = $start; $i <= $end; $i++):
                        $queryParams['page'] = $i;
                        $url = '?' . http_build_query($queryParams);
                    ?>
                        <a class="page-btn <?= $i == $currentPage ? 'active' : '' ?>"
                            href="<?= $url ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <!-- Trang tiếp -->
                    <?php if ($currentPage < $totalPages):
                        $queryParams['page'] = $currentPage + 1;
                    ?>
                        <a class="page-btn next-btn" href="?<?= http_build_query($queryParams) ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, #fff3cd, #f8f9fa);
        border-radius: 12px;
        padding: 2rem;
        border: 1px solid #e9ecef;
    }

    .page-title {
        color: #2c3e50;
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
    }

    .welcome-text {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .action-buttons .btn {
        margin: 0 0.25rem;
        border-radius: 6px;
    }

    /* Filter Section */
    .filter-form {
        background: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filter-form .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .filter-form .form-control,
    .filter-form .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
    }

    .filter-form .form-control:focus,
    .filter-form .form-select:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
    }

    /* Product Cards */
    .products-grid {
        margin-top: 2rem;
    }

    .product-card {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .product-price {
        margin-bottom: 1rem;
    }

    .price-current {
        font-size: 1.3rem;
        font-weight: 700;
        color: #dc3545;
    }

    .price-old {
        font-size: 0.9rem;
        color: #6c757d;
        text-decoration: line-through;
        margin-left: 0.5rem;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
    }

    .product-actions .btn {
        flex: 1;
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }

    /* Empty State */
    .empty-state {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 3rem;
        text-align: center;
        border: 1px solid #e9ecef;
    }

    /* Pagination */
    .pagination-nav {
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .page-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .page-btn:hover {
        background: #ffc107;
        color: white;
        border-color: #ffc107;
    }

    .page-btn.active {
        background: #ffc107;
        color: white;
        border-color: #ffc107;
    }

    .prev-btn,
    .next-btn {
        background: #f8f9fa;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.8rem;
        }

        .user-actions {
            text-align: left !important;
            margin-top: 1rem;
        }

        .filter-form {
            padding: 1.5rem;
        }

        .product-info {
            padding: 1rem;
        }
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>