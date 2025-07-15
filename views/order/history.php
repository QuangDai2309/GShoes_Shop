<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Lịch sử đơn hàng';
require_once __DIR__ . '/../layouts/header.php';
?>
<div id="main-content" class="container py-5">
    <h2 class="mb-4 text-center fw-bold"><?= htmlspecialchars($title) ?></h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center">
            Bạn chưa đặt đơn hàng nào.
        </div>
    <?php else: ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Tổng tiền</th>
                        <th class="text-center">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['id']) ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['created_at']))) ?></td>
                            <td>
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
                                <span class="<?= $badgeClass ?> d-flex align-items-center justify-content-center gap-1">
                                    <?= $icon ?>
                                    <?= htmlspecialchars($order['status']) ?>
                                </span>
                            </td>
                            <td class="text-danger fw-bold text-end"><?= number_format($order['total']) ?>₫</td>
                            <td class="text-center">
                                <a href="?controller=order&action=detail&id=<?= urlencode($order['id']) ?>" class="btn btn-sm btn-primary" title="Xem chi tiết đơn hàng">
                                    <i class="bi bi-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
