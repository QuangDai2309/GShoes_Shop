<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Chỉ admin mới được truy cập
        if (empty($_SESSION['admin_user']) || $_SESSION['admin_user']['role'] !== 'admin') {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $this->model = new UserModel();
    }

    public function index()
    {
        $users = $this->model->getAll();
        require __DIR__ . '/../views/user/index.php';
    }

    public function create()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $role = $_POST['role'] ?? 'customer';
            $is_verified = isset($_POST['is_verified']) ? 1 : 0;

            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } elseif (!$password || strlen($password) < 6) {
                $error = 'Mật khẩu phải từ 6 ký tự trở lên.';
            } elseif ($this->model->emailExists($email)) {
                $error = 'Email đã tồn tại.';
            } elseif (!$name) {
                $error = 'Tên không được để trống.';
            } else {
                $this->model->create($email, $password, $name, $role);
                header("Location: index.php?controller=user&action=index");
                exit;
            }
        }

        require __DIR__ . '/../views/user/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $user = $this->model->getById($id);
        $error = '';

        if (!$user) {
            echo "Người dùng không tồn tại.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $role = $_POST['role'] ?? 'customer';
            $is_verified = isset($_POST['is_verified']) ? 1 : 0;
            $newPassword = $_POST['password'] ?? '';

            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } elseif ($this->model->emailExists($email, $id)) {
                $error = 'Email đã tồn tại.';
            } elseif (!$name) {
                $error = 'Tên không được để trống.';
            } else {
                $this->model->update($id, $email, $name, $role, $is_verified);
                if ($newPassword && strlen($newPassword) >= 6) {
                    $this->model->updatePassword($id, $newPassword);
                }
                header("Location: index.php?controller=user&action=index");
                exit;
            }
        }

        require __DIR__ . '/../views/user/edit.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->delete($id);
        }
        header("Location: index.php?controller=user&action=index");
        exit;
    }
}
