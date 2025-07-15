<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Chi Tiết – ' . htmlspecialchars($product['name']);
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container my-5">
    <div class="row g-4">
        <!-- ẢNH SẢN PHẨM -->
        <div class="col-lg-6">
            <?php if (!empty($product['images'])): ?>
                <div id="productCarousel" class="carousel slide rounded-4 overflow-hidden shadow" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($product['images'] as $i => $img): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                <img src="/GShoes_Shop<?= htmlspecialchars($img['img_path']) ?>"
                                    alt="<?= htmlspecialchars($img['alt_text'] ?: $product['name']) ?>"
                                    class="d-block w-100"
                                    style="height:450px;object-fit:cover">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            <?php else: ?>
                <img src="/GShoes_Shop<?= htmlspecialchars($product['thumbnail']) ?>"
                    class="w-100 rounded-4 shadow"
                    style="height:450px;object-fit:cover" alt="<?= htmlspecialchars($product['name']) ?>">
            <?php endif; ?>
        </div>

        <!-- THÔNG TIN SẢN PHẨM -->
        <div class="col-lg-6">
            <div class="product-info p-4 bg-white rounded-4 shadow-sm">
                <h1 class="h2 fw-bold text-dark mb-2"><?= htmlspecialchars($product['name']) ?></h1>

                <div class="mb-3">
                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($product['category_name']) ?></span>
                    <span class="text-warning ms-2">★★★★★</span>
                </div>

                <div class="price mb-4">
                    <span class="h3 text-danger fw-bold"><?= number_format($product['price']) ?>₫</span>
                    <span class="text-muted text-decoration-line-through ms-2"><?= number_format($product['price'] * 1.2) ?>₫</span>
                </div>

                <!-- FORM MUA HÀNG -->
                <form method="post" action="?controller=cart&action=add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <!-- SIZE -->
                    <h6 class="fw-semibold mb-3">Chọn size EU</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php
                        $firstSize = null;
                        foreach ($product['stock'] as $st) {
                            if ($st['quantity'] > 0) {
                                $firstSize = $firstSize ?? $st['size_eu'];
                                $checked = $st['size_eu'] == $firstSize ? 'checked' : '';
                                echo '
                                <input class="btn-check" type="radio" name="size" id="size' . $st['size_eu'] . '" value="' . $st['size_eu'] . '" ' . $checked . ' required>
                                <label class="btn btn-outline-warning size-btn" for="size' . $st['size_eu'] . '">EU ' . $st['size_eu'] . '</label>
                                ';
                            }
                        }
                        ?>
                    </div>

                    <!-- SỐ LƯỢNG -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Số lượng</label>
                        <div class="d-flex align-items-center gap-2" style="width: 150px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQty(-1)">-</button>
                            <input type="number" class="form-control text-center" name="qty" id="qty" value="1" min="1" max="10">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <!-- NÚT HÀNH ĐỘNG -->
                    <div class="d-grid gap-2">
                        <button type="submit" name="action_type" value="add_to_cart" class="btn btn-warning btn-lg">
                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ
                        </button>
                        <button type="submit" name="action_type" value="buy_now" class="btn btn-success btn-lg">
                            <i class="bi bi-lightning-fill me-2"></i>Mua ngay
                        </button>
                    </div>
                </form>

                <!-- MÔ TẢ -->
                <hr class="my-4">
                <h6 class="fw-semibold mb-3">Mô tả sản phẩm</h6>
                <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'] ?: 'Đang cập nhật...')) ?></p>

                <!-- TÍNH NĂNG -->
                <div class="features mt-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <i class="bi bi-truck text-success"></i>
                                <small class="d-block">Free ship</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <i class="bi bi-arrow-clockwise text-info"></i>
                                <small class="d-block">Đổi trả 30 ngày</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-info {
        position: sticky;
        top: 100px;
    }

    .size-btn {
        min-width: 60px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-check:checked+.size-btn {
        background: #ffc107;
        border-color: #ffc107;
        color: white;
    }

    .btn-warning {
        background: linear-gradient(45deg, #ffc107, #ffb300);
        border: none;
        font-weight: 600;
    }

    .btn-success {
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        font-weight: 600;
    }

    .features .bg-light:hover {
        background: white !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        transition: all 0.3s;
    }

    @media (max-width: 768px) {
        .product-info {
            position: static;
        }
    }
</style>

<script>
    function changeQty(change) {
        const qtyInput = document.getElementById('qty');
        const currentValue = parseInt(qtyInput.value);
        const newValue = currentValue + change;

        if (newValue >= 1 && newValue <= 10) {
            qtyInput.value = newValue;
        }
    }
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>