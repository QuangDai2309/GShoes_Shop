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
        if (empty($_SESSION['user'])) {
            header("Location: ?controller=auth&action=login");
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            echo "Giỏ hàng trống.";
            return;
        }

        $pdo = getPDO();
        $pdo->beginTransaction();

        try {
            $user_id = $_SESSION['user']['id'];
            $total = 0;

            foreach ($cart as $key => $item) {
                $price = $this->orderModel->checkStock($item['product_id'], $item['size'], $item['qty']);
                $cart[$key]['price'] = $price;
                $total += $price * $item['qty'];
            }

            $order_id = $this->orderModel->createOrder($user_id, $total);

            foreach ($cart as $item) {
                $this->orderModel->addOrderItem($order_id, $item['product_id'], $item['size'], $item['price'], $item['qty']);
                $this->orderModel->reduceStock($item['product_id'], $item['size'], $item['qty']);
            }

            $pdo->commit();
            unset($_SESSION['cart']);
            header("Location: ?controller=order&action=success&id=" . $order_id);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(400);
            echo "Lỗi khi đặt hàng: " . $e->getMessage();
        }
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
