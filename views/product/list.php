<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../layouts/header.php';
$title = 'Danh Sách Sản Phẩm - GShoes Shop';
?>

<div class="container my-5">

    <!-- Header -->
    <div class="header-section mb-4">
        <h1 class="page-title">
            <i class="bi bi-collection me-2"></i>
            Danh Sách Sản Phẩm
        </h1>
    </div>

    <!-- Filter Form -->
    <div class="filter-section mb-4">
        <form method="get" action="?controller=product&action=list" class="filter-form">
            <input type="hidden" name="controller" value="product" />
            <input type="hidden" name="action" value="list" />

            <div class="row g-3">
                <div class="col-md-3">
                    <label for="keyword" class="form-label">
                        <i class="bi bi-search me-1"></i>Tìm kiếm
                    </label>
                    <input type="text" id="keyword" name="keyword" class="form-control"
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                        placeholder="Nhập tên sản phẩm...">
                </div>

                <div class="col-md-3">
                    <label for="category" class="form-label">
                        <i class="bi bi-tags me-1"></i>Danh mục
                    </label>
                    <select id="category" name="category_id" class="form-select">
                        <option value="">Tất cả</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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

                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-warning me-2">
                        <i class="bi bi-funnel me-1"></i>Lọc
                    </button>
                    <a href="?controller=product&action=list" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Product List -->
    <?php if (empty($products)): ?>
        <div class="empty-state text-center p-5 border rounded">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h3 class="text-muted mt-3">Không tìm thấy sản phẩm</h3>
            <p class="text-muted">Vui lòng thử lại với từ khóa khác</p>
            <a href="?controller=product&action=list" class="btn btn-warning mt-3">
                <i class="bi bi-arrow-left me-1"></i>Xem tất cả sản phẩm
            </a>
        </div>
    <?php else: ?>
        <div class="products-grid row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card border rounded shadow-sm p-3 h-100 d-flex flex-column">
                        <div class="product-image mb-3 position-relative" style="height: 220px; overflow: hidden;">
                            <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="w-100 h-100 object-fit-cover">
                            <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                <a href="?controller=product&action=detail&id=<?= $product['id'] ?>"
                                    class="btn btn-warning btn-sm">Xem chi tiết</a>
                            </div>
                        </div>

                        <div class="product-info flex-grow-1">
                            <h5 class="product-name fw-bold mb-2"><?= htmlspecialchars($product['name']) ?></h5>
                            <div class="product-price mb-3">
                                <span class="price-current text-danger fw-bold fs-5"><?= number_format($product['price']) ?>₫</span>
                                <span class="price-old text-muted text-decoration-line-through ms-2"><?= number_format($product['price'] * 1.2) ?>₫</span>
                            </div>
                        </div>

                        <div class="product-actions d-flex gap-2">
                            <a href="?controller=wishlist&action=add&product_id=<?= $product['id'] ?>"
                                class="btn btn-outline-danger flex-grow-1 btn-sm">
                                <i class="bi bi-heart me-1"></i>Yêu thích
                            </a>

                            <form method="post" action="?controller=cart&action=add" class="flex-grow-1 m-0">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="size" value="38"> <!-- Mặc định size 38, bạn sửa sau nếu muốn chọn size -->
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" name="action_type" value="buy_now" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-cart-plus me-1"></i>Mua ngay
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="pagination-nav mt-5 d-flex justify-content-center">
                <div class="pagination-wrapper d-flex gap-2 align-items-center">
                    <?php
                    $currentPage = $currentPage ?? 1;
                    $queryParams = $_GET;
                    unset($queryParams['page']);

                    if ($currentPage > 1):
                        $queryParams['page'] = $currentPage - 1;
                    ?>
                        <a class="page-btn btn btn-outline-secondary" href="?<?= http_build_query($queryParams) ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php
                    $start = max(1, $currentPage - 2);
                    $end = min($totalPages, $currentPage + 2);

                    for ($i = $start; $i <= $end; $i++):
                        $queryParams['page'] = $i;
                        $url = '?' . http_build_query($queryParams);
                    ?>
                        <a class="page-btn btn <?= $i == $currentPage ? 'btn-warning' : 'btn-outline-secondary' ?>"
                            href="<?= $url ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages):
                        $queryParams['page'] = $currentPage + 1;
                    ?>
                        <a class="page-btn btn btn-outline-secondary" href="?<?= http_build_query($queryParams) ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0;
    }

    .filter-form .form-label {
        font-weight: 600;
        margin-bottom: 0.3rem;
    }

    .product-card {
        transition: box-shadow 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .pagination-wrapper a.page-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
    }

    .product-image {
        position: relative;
    }

    .image-overlay {
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-image:hover .image-overlay {
        opacity: 1;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>