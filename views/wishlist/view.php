<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Danh sách yêu thích';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h1>

    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center">
            Chưa có sản phẩm nào trong danh sách yêu thích.
        </div>
        <p class="text-center">
            <a href="?controller=product&action=list" class="btn btn-success">Tiếp tục mua hàng</a>
        </p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($product['thumbnail'])): ?>
                            <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit: cover; height: 200px;">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span>Không có ảnh</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-danger fw-bold fs-5"><?= number_format($product['price']) ?>₫</p>
                            <div class="mt-auto">
                                <a href="?controller=product&action=detail&id=<?= urlencode($product['id']) ?>" class="btn btn-primary me-2">Xem chi tiết</a>
                                <a href="?controller=wishlist&action=remove&product_id=<?= urlencode($product['id']) ?>"
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
