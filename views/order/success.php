<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đặt hàng thành công</title>
    <!-- Link Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08-.02L11.477 7.5 10.385 6.408 7.5 9.293 6.515 8.307 5.515 9.307l1.455 1.455z"/>
                            </svg>
                        </div>

                        <h1 class="card-title mb-3 text-success">Đặt hàng thành công!</h1>
                        <p class="lead text-muted mb-4">Cảm ơn bạn đã mua hàng tại cửa hàng chúng tôi.</p>

                        <ul class="list-group mb-4 text-start">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Mã đơn hàng:</strong>
                                <span>#<?= htmlspecialchars($order['id']) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Thời gian:</strong>
                                <span><?= htmlspecialchars($order['created_at']) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Tổng tiền:</strong>
                                <span class="text-danger fw-bold"><?= number_format($order['total']) ?>₫</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>Trạng thái:</strong>
                                <span><?= htmlspecialchars($order['status']) ?></span>
                            </li>
                        </ul>

                        <h5 class="text-start mb-3">Chi tiết đơn hàng:</h5>
                        <ul class="list-group mb-4 text-start">
                            <?php foreach ($items as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= htmlspecialchars($item['name']) ?></strong><br />
                                    Size <?= htmlspecialchars($item['size_eu']) ?> - SL: <?= (int)$item['qty'] ?>
                                </div>
                                <span class="text-danger fw-bold"><?= number_format($item['price']) ?>₫</span>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <a href="?controller=product&action=list" class="btn btn-primary btn-lg w-100">
                            Tiếp tục mua hàng
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS (tùy chọn) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
