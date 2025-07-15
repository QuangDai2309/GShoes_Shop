<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->orderModel = new OrderModel();
    }

    public function checkout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../models/ProductModel.php';

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header("Location: ?controller=cart&action=view");
            exit;
        }

        $errors = [];
        $success = false;
        $orderId = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra user đã đăng nhập chưa
            $user_id = $_SESSION['user']['id'] ?? null;
            if (!$user_id) {
                $errors[] = 'Bạn cần đăng nhập để đặt hàng.';
            }

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            if ($name === '') $errors[] = 'Tên không được để trống';
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ';
            if ($phone === '') $errors[] = 'Số điện thoại không được để trống';
            if ($address === '') $errors[] = 'Địa chỉ không được để trống';

            if (empty($errors)) {
                $orderId = $this->orderModel->createOrder($user_id, $name, $email, $phone, $address, $cart);

                if ($orderId) {
                    $success = true;
                    unset($_SESSION['cart']);
                    header("Location: ?controller=order&action=success&id=" . $orderId);
                    exit;
                } else {
                    $errors[] = 'Đặt hàng thất bại, vui lòng thử lại.';
                }
            }
        }

        // Load products info để hiển thị sản phẩm trong giỏ hàng (nếu bạn làm phần view hiển thị giỏ hàng trên trang checkout)
        $products_info = [];
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $products_info[$item['product_id']] = $product;
            }
        }

        require __DIR__ . '/../views/order/checkout.php';
    }



    public function success()
    {
        $id = $_GET['id'] ?? 0;
        $order = $this->orderModel->getOrderById($id);
        $items = $this->orderModel->getOrderItems($id);
        require __DIR__ . '/../views/order/success.php';
    }

    public function history()
    {
        if (empty($_SESSION['user'])) {
            header("Location: ?controller=auth&action=login");
            exit;
        }
        $user_id = $_SESSION['user']['id'];
        $orders = $this->orderModel->getUserOrders($user_id);
        require __DIR__ . '/../views/order/history.php';
    }

    public function detail()
    {
        if (empty($_SESSION['user'])) {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        $order_id = $_GET['id'] ?? 0;
        $user_id = $_SESSION['user']['id'];

        $order = $this->orderModel->getUserOrderById($order_id, $user_id);
        if (!$order) {
            echo "Không tìm thấy đơn hàng.";
            return;
        }

        $items = $this->orderModel->getOrderItems($order_id);
        require __DIR__ . '/../views/order/detail.php';
    }
}
