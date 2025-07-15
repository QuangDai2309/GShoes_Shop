<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Quản lý Người dùng</h1>
    <a href="index.php?controller=user&action=create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Thêm người dùng
    </a>
</div>

<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Tên</th>
            <th>Vai trò</th>
            <th>Đã xác thực</th>
            <th>Ngày tạo</th>
            <th class="text-center" style="width: 140px;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['id']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td><?= $u['is_verified'] ? 'Có' : 'Chưa' ?></td>
                    <td><?= $u['created_at'] ?></td>
                    <td class="text-center">
                        <a href="index.php?controller=user&action=edit&id=<?= $u['id'] ?>" class="btn btn-sm btn-warning me-1" title="Sửa">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="index.php?controller=user&action=delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-danger" title="Xóa"
                            onclick="return confirm('Bạn có chắc muốn xóa người dùng này không?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">Chưa có người dùng nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
