<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<h1>Chi tiết Đơn hàng #<?= $order['id'] ?></h1>

<p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
<p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
<p><strong>Địa chỉ:</strong> <?= nl2br(htmlspecialchars($order['customer_address'])) ?></p>
<p><strong>Tổng tiền:</strong> <?= number_format($order['total'], 0, ',', '.') ?>₫</p>
<p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
<form method="post" action="index.php?controller=order&action=updateStatus" class="mb-3">
    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
    <label for="status">Cập nhật trạng thái:</label>
    <select name="status" id="status" class="form-select w-auto d-inline-block">
        <?php
        $statuses = ['pending', 'paid', 'shipping', 'completed', 'cancelled'];
        foreach ($statuses as $st):
        ?>
            <option value="<?= $st ?>" <?= $order['status'] === $st ? 'selected' : '' ?>>
                <?= ucfirst($st) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
</form>
<p><strong>Ngày tạo:</strong> <?= htmlspecialchars($order['created_at']) ?></p>

<h3>Danh sách sản phẩm</h3>

<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th>Sản phẩm</th>
            <th>Ảnh</th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order['items'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><img src="/Gshoes_Shop<?= htmlspecialchars($item['thumbnail']) ?>" alt="" style="height: 60px;"></td>
                <td><?= htmlspecialchars($item['size_eu']) ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                <td><?= $item['qty'] ?></td>
                <td><?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?>₫</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php?controller=order&action=index" class="btn btn-secondary">Quay lại</a>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>