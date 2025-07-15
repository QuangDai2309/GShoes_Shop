<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<h1 class="mb-4">Dashboard Admin</h1>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm</h5>
                <p class="card-text fs-3"><?= $totalProducts ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Danh mục</h5>
                <p class="card-text fs-3"><?= $totalCategories ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Đơn hàng</h5>
                <p class="card-text fs-3"><?= $totalOrders ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Người dùng</h5>
                <p class="card-text fs-3"><?= $totalUsers ?></p>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-5">Thống kê đơn hàng theo trạng thái</h3>
<ul class="list-group w-50">
    <?php
    $statuses = ['pending' => 'Chờ xử lý', 'paid' => 'Đã thanh toán', 'shipping' => 'Đang giao', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy'];
    foreach ($statuses as $key => $label):
        $count = $orderStats[$key] ?? 0;
    ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= $label ?>
            <span class="badge bg-primary rounded-pill"><?= $count ?></span>
        </li>
    <?php endforeach; ?>
</ul>
<h3 class="mt-5">Doanh thu 6 tháng gần đây</h3>
<canvas id="revenueChart" width="600" height="300"></canvas>

<h3 class="mt-5">Đơn hàng mới nhất</h3>
<table class="table table-bordered w-75">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($latestOrders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td><?= number_format($order['total']) ?>₫</td>
                <td><?= htmlspecialchars($order['status']) ?></td>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($monthlyRevenue['months']) ?>,
            datasets: [{
                label: 'Doanh thu (₫)',
                data: <?= json_encode($monthlyRevenue['revenues']) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + '₫';
                        }
                    }
                }
            }
        }
    });
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>