<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Giỏ hàng của bạn';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart4 me-2"></i>Giỏ hàng</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-1"></i> Giỏ hàng của bạn đang trống.
        </div>
        <div class="text-center">
            <a href="?controller=product&action=list" class="btn btn-warning">
                <i class="bi bi-arrow-left me-1"></i>Tiếp tục mua hàng
            </a>
        </div>
    <?php else: ?>
        <form method="post" action="?controller=cart&action=update">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Size</th>
                            <th>Đơn giá</th>
                            <th style="width: 100px;">Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        foreach ($cart as $key => $item):
                            $product = $products_info[$item['product_id']] ?? null;
                            if (!$product) continue;
                            $subtotal = $product['price'] * $item['qty'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td>
                                    <img src="/Gshoes_Shop<?= htmlspecialchars($product['thumbnail'] ?? '/assets/images/no-image.png') ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>" width="60" height="60" style="object-fit:cover;">
                                </td>
                                <td class="text-start"><?= htmlspecialchars($product['name']) ?></td>
                                <td>EU <?= htmlspecialchars($item['size']) ?></td>
                                <td class="text-danger fw-semibold"><?= number_format($product['price']) ?>₫</td>
                                <td>
                                    <input type="number" name="qty[<?= htmlspecialchars($key) ?>]"
                                        class="form-control text-center" value="<?= htmlspecialchars($item['qty']) ?>"
                                        min="1" required>
                                </td>
                                <td class="text-danger fw-semibold"><?= number_format($subtotal) ?>₫</td>
                                <td>
                                    <a href="?controller=cart&action=remove&key=<?= urlencode($key) ?>"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5" class="text-end fw-bold fs-5">Tổng cộng:</td>
                            <td colspan="2" class="text-danger fw-bold fs-5"><?= number_format($total) ?>₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between gap-3 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-repeat me-1"></i>Cập nhật giỏ hàng
                </button>

                <?php if (!empty($_SESSION['user'])): ?>
                    <a href="?controller=order&action=checkout" class="btn btn-success btn-lg">
                        <i class="bi bi-credit-card me-1"></i>Thanh toán
                    </a>
                <?php else: ?>
                    <a href="?controller=auth&action=login" class="btn btn-warning btn-lg">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập để thanh toán
                    </a>
                <?php endif; ?>

                <a href="?controller=product&action=list" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-arrow-left me-1"></i>Tiếp tục mua hàng
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>