<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Vui lòng nhập email và mật khẩu.';
            } else {
                $userModel = new UserModel();
                $user      = $userModel->getByEmail($email);

                if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {
                    // Lưu vào session dưới 2 key để dùng chung mọi nơi
                    $_SESSION['admin_user'] = $user;   // cho khu vực /admin
                    $_SESSION['user']       = $user;   // cho code chung (client)

                    header('Location: index.php?controller=dashboard&action=index');
                    exit;
                } else {
                    $error = 'Email hoặc mật khẩu không đúng, hoặc bạn không có quyền admin.';
                }
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }


    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['admin_user'], $_SESSION['user']);
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
