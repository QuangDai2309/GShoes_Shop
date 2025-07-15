<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php if (!empty($_SESSION['delete_success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['delete_success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['delete_success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['delete_error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['delete_error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['delete_error']); ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý Sản phẩm</h1>
    <a href="index.php?controller=product&action=create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Thêm sản phẩm mới
    </a>
</div>

<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>SKU</th>
            <th>Giá</th>
            <th>Ngày tạo</th>
            <th class="text-center" style="width: 140px;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($product['sku']) ?></td>
                    <td><?= number_format($product['price']) ?>₫</td>
                    <td><?= htmlspecialchars($product['created_at']) ?></td>
                    <td class="text-center">
                        <a href="index.php?controller=product&action=edit&id=<?= $product['id'] ?>" class="btn btn-sm btn-warning me-1" title="Sửa">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="index.php?controller=product&action=delete&id=<?= $product['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           title="Xóa"
                           onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">Chưa có sản phẩm nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
