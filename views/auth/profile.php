<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Trang cá nhân';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5" style="max-width: 500px;">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">Cập nhật thông tin thành công!</div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                required
                value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                autofocus
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                required
                value="<?= htmlspecialchars($user['email'] ?? '') ?>"
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
    </form>

    <div class="mt-4 d-flex justify-content-between">
        <a href="?controller=auth&action=changePassword" class="btn btn-outline-secondary">Đổi mật khẩu</a>
        <a href="?controller=auth&action=logout" class="btn btn-outline-danger" onclick="return confirm('Bạn muốn đăng xuất?')">Đăng xuất</a>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
