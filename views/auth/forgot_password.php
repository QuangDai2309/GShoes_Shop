<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$title = 'Quên mật khẩu';
require_once __DIR__ . '/../layouts/header.php';
?>

<div id="main-content" class="container py-5" style="max-width: 450px;">
    <h1 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h1>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            Link đặt lại mật khẩu đã được gửi nếu email tồn tại.
        </div>
    <?php else: ?>
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
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Gửi link đặt lại mật khẩu</button>
        </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
