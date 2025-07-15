<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Đăng nhập';
require_once __DIR__ . '/../layouts/header.php';
?>

<div id="main-content" class="container py-5" style="max-width: 400px;">
    <h1 class="mb-4 text-center">Đăng nhập</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($_GET['verified'])): ?>
        <div class="alert alert-success">Xác minh thành công! Hãy đăng nhập.</div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                required
                autofocus
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

        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
    </form>

    <div class="mt-3 d-flex justify-content-between">
        <a href="?controller=auth&action=forgotPassword">Quên mật khẩu?</a>
        <a href="?controller=auth&action=register">Đăng ký</a>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
