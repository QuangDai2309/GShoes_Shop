<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../layouts/header.php';
$title = 'Thanh Toán Đơn Hàng - GShoes Shop';
?>

<div class="container py-5">
    <!-- Header -->
    <div class="header-section mb-5">
        <h1 class="page-title fw-bold">
            <i class="bi bi-cart-check me-2"></i>Thanh Toán Đơn Hàng
        </h1>
    </div>

    <!-- Success Message -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>
                    <strong>Đặt hàng thành công!</strong> Cảm ơn bạn đã mua hàng tại GShoes Shop.
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="text-center">
            <a href="?controller=product&action=list" class="btn btn-warning btn-lg shadow-sm">
                <i class="bi bi-shop me-2"></i>Tiếp tục mua hàng
            </a>
        </div>
    <?php else: ?>
        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <strong>Lỗi:</strong>
                        <ul class="mb-0">
                            <?php foreach ($errors as $e): ?>
                                <li><?= htmlspecialchars($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Cart Items -->
        <?php if (!empty($cart) && !empty($products_info)): ?>
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-light">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-cart3 me-2"></i>Sản phẩm bạn chọn
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Size (EU)</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Thành tiền</th>
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
                                        <td class="align-middle"><?= htmlspecialchars($product['name']) ?></td>
                                        <td class="align-middle"><?= htmlspecialchars($item['size']) ?></td>
                                        <td class="align-middle"><?= htmlspecialchars($item['qty']) ?></td>
                                        <td class="align-middle text-danger fw-bold"><?= number_format($product['price']) ?>₫</td>
                                        <td class="align-middle text-danger fw-bold"><?= number_format($subtotal) ?>₫</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold align-middle">Tổng cộng:</td>
                                    <td class="text-danger fw-bold align-middle"><?= number_format($total) ?>₫</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Checkout Form -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-person-fill me-2"></i>Thông tin thanh toán
                </h4>
            </div>
            <div class="card-body">
                <form method="post" novalidate>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                required
                                placeholder="Nhập họ tên của bạn" />
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                required
                                placeholder="Nhập email của bạn" />
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone"
                                class="form-control"
                                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                                required
                                placeholder="Nhập số điện thoại của bạn" />
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label fw-semibold">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                            <textarea id="address" name="address"
                                class="form-control"
                                rows="4"
                                required
                                placeholder="Nhập địa chỉ nhận hàng"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Đặt hàng
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .page-title {
        font-size: 2rem;
        color: #333;
    }

    .card {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control,
    .form-control:focus {
        border-radius: 6px;
        border: 1px solid #ced4da;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #ffc107;
    }

    .btn-success,
    .btn-warning {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .alert {
        border-radius: 6px;
        padding: 1rem;
    }

    .alert i {
        font-size: 1.2rem;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>