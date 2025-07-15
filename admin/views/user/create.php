<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<h1 class="h3 mb-4">Thêm người dùng mới</h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" required class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label>Mật khẩu</label>
        <input type="password" name="password" required minlength="6" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tên</label>
        <input type="text" name="name" required class="form-control" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label>Vai trò</label>
        <select name="role" class="form-select">
            <option value="customer" <?= (($_POST['role'] ?? '') === 'customer') ? 'selected' : '' ?>>Khách hàng</option>
            <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Quản trị viên</option>
        </select>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="is_verified" class="form-check-input" id="is_verified" <?= !empty($_POST['is_verified']) ? 'checked' : '' ?>>
        <label class="form-check-label" for="is_verified">Đã xác thực</label>
    </div>

    <button type="submit" class="btn btn-primary">Thêm người dùng</button>
    <a href="index.php?controller=user&action=index" class="btn btn-secondary">Hủy</a>
</form>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
