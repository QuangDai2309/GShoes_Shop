<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Giỏ hàng của bạn';
require_once __DIR__ . '/../layouts/header.php';
?>

<div id="main-content" class="container py-5">
    <h1 class="mb-4">Giỏ hàng</h1>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info">
            Giỏ hàng đang trống.
        </div>
        <a href="?controller=product&action=list" class="btn btn-warning">Tiếp tục mua hàng</a>
    <?php else: ?>
        <form method="post" action="?controller=cart&action=update">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Size</th>
                            <th>Đơn giá</th>
                            <th style="width: 120px;">Số lượng</th>
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
                                <td class="text-start"><?= htmlspecialchars($product['name']) ?></td>
                                <td>EU <?= htmlspecialchars($item['size']) ?></td>
                                <td class="text-danger fw-bold"><?= number_format($product['price']) ?>₫</td>
                                <td>
                                    <input type="number" class="form-control text-center" name="qty[<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars($item['qty']) ?>" min="1" required>
                                </td>
                                <td class="text-danger fw-bold"><?= number_format($subtotal) ?>₫</td>
                                <td>
                                    <a href="?controller=cart&action=remove&key=<?= urlencode($key) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        <i class="bi bi-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-end fw-bold fs-5">Tổng cộng:</td>
                            <td colspan="2" class="text-danger fw-bold fs-5"><?= number_format($total) ?>₫</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4 flex-wrap gap-3">
                <button type="submit" class="btn btn-primary btn-lg">Cập nhật giỏ hàng</button>

                <?php if (!empty($_SESSION['user'])): ?>
                    <a href="?controller=order&action=checkout" class="btn btn-success btn-lg" onclick="return confirm('Xác nhận đặt hàng?')">
                        <i class="bi bi-check-circle me-1"></i> Đặt hàng
                    </a>
                <?php else: ?>
                    <a href="?controller=auth&action=login" class="btn btn-warning btn-lg">
                        Đăng nhập để đặt hàng
                    </a>
                <?php endif; ?>

                <a href="?controller=product&action=list" class="btn btn-secondary btn-lg">
                    Tiếp tục mua hàng
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
