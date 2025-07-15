<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Đổi mật khẩu';
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5" style="max-width: 450px;">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">Đổi mật khẩu thành công!</div>
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
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Đổi mật khẩu</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
