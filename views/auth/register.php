<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Đăng ký tài khoản';
require_once __DIR__ . '/../layouts/header.php';
?>

<div id="main-content" class="container py-5" style="max-width: 450px;">
    <h1 class="mb-4 text-center">Đăng ký tài khoản</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Họ tên:</label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                required
                value="<?= htmlspecialchars($data['name'] ?? '') ?>"
                autofocus
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required
                value="<?= htmlspecialchars($data['email'] ?? '') ?>"
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu:</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                required
            >
        </div>

        <div class="mb-3">
            <label for="confirm" class="form-label">Xác nhận mật khẩu:</label>
            <input
                type="password"
                class="form-control"
                id="confirm"
                name="confirm"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
    </form>

    <p class="mt-3 text-center">
        Đã có tài khoản? <a href="?controller=auth&action=login">Đăng nhập ngay</a>
    </p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
