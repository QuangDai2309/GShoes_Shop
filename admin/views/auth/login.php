<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đăng nhập Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            background: #fff;
            padding: 30px 35px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
        }
        h2 {
            font-weight: 700;
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }
        .form-control:focus {
            box-shadow: 0 0 5px #764ba2;
            border-color: #764ba2;
        }
        button.btn-primary {
            background: #764ba2;
            border: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button.btn-primary:hover {
            background: #5a3683;
        }
        .alert-danger {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Đăng nhập Admin</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Nhập email admin" />
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu" />
            </div>
            <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
