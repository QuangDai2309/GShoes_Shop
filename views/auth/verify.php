<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Xác minh tài khoản';
require_once __DIR__ . '/../layouts/header.php';
?>

<div id="main-content" class="container py-5" style="max-width: 420px;">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <p class="mb-1"><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Email đăng ký</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required class="form-control" autofocus>
        </div>
        <div class="mb-3">
            <label for="otp" class="form-label">Mã OTP (6 số)</label>
            <input type="text" id="otp" name="otp" maxlength="6" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Xác minh</button>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
