<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController
{
    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Kiểm tra đăng nhập admin
        if (empty($_SESSION['admin_user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        $this->model = new OrderModel();
    }

    public function index()
    {
        $orders = $this->model->getAll();
        require __DIR__ . '/../views/order/index.php';
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 0;
        $order = $this->model->getById($id);
        if (!$order) {
            echo "Đơn hàng không tồn tại";
            return;
        }
        require __DIR__ . '/../views/order/detail.php';
    }

    // Nếu muốn thêm chức năng update trạng thái
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;

            if ($id && $status) {
                if ($this->model->updateStatus($id, $status)) {
                    $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công.";
                } else {
                    $_SESSION['error'] = "Cập nhật trạng thái thất bại.";
                }
            } else {
                $_SESSION['error'] = "Dữ liệu gửi lên không hợp lệ.";
            }

            header("Location: index.php?controller=order&action=detail&id=" . $id);
            exit;
        }
    }
}
