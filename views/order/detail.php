<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Chi tiết đơn hàng #' . htmlspecialchars($order['id']);
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <h2 class="mb-4 fw-bold"><?= $title ?></h2>

    <div class="card shadow-sm rounded mb-4">
        <div class="card-body">
            <p><strong>Ngày đặt:</strong> <?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['created_at']))) ?></p>
            <p>
                <strong>Trạng thái:</strong>
                <?php
                    $status = strtolower($order['status']);
                    $badgeClass = match($status) {
                        'đang xử lý' => 'badge bg-warning text-dark',
                        'đã giao' => 'badge bg-success',
                        'đã hủy' => 'badge bg-danger',
                        default => 'badge bg-secondary',
                    };

                    $icon = match($status) {
                        'đang xử lý' => '<i class="bi bi-hourglass-split me-1"></i>',
                        'đã giao' => '<i class="bi bi-check-circle-fill me-1"></i>',
                        'đã hủy' => '<i class="bi bi-x-circle-fill me-1"></i>',
                        default => '<i class="bi bi-info-circle-fill me-1"></i>',
                    };
                ?>
                <span class="<?= $badgeClass ?> d-inline-flex align-items-center gap-1 px-2 py-1 rounded">
                    <?= $icon ?>
                    <?= htmlspecialchars($order['status']) ?>
                </span>
            </p>
            <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?= number_format($order['total']) ?>₫</span></p>
        </div>
    </div>

    <h3 class="mb-3">Sản phẩm:</h3>
    <ul class="list-group mb-4">
        <?php foreach ($items as $item): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong><?= htmlspecialchars($item['name']) ?></strong><br />
                    Size <?= htmlspecialchars($item['size_eu']) ?> - Số lượng: <?= (int)$item['qty'] ?>
                </div>
                <span class="text-danger fw-bold"><?= number_format($item['price']) ?>₫</span>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="?controller=order&action=history" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Quay lại lịch sử đơn hàng
    </a>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
