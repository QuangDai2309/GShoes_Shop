<?php
class CartController
{
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $product_id = (int)($_POST['product_id'] ?? 0);
        $size       = (int)($_POST['size'] ?? 0);
        $qty        = (int)($_POST['qty'] ?? 1);
        $action     = $_POST['action_type'] ?? 'add_to_cart';

        if ($product_id <= 0 || $size <= 0 || $qty <= 0) {
            http_response_code(400);
            echo "Dữ liệu không hợp lệ.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $key = $product_id . '_' . $size;

        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$key] = [
                'product_id' => $product_id,
                'size'       => $size,
                'qty'        => $qty,
            ];
        }

        if ($action === 'buy_now') {
            // Nếu bạn đã có trang thanh toán, chuyển đến đó luôn
            header("Location: ?controller=order&action=checkout");
            exit;
        } else {
            // Quay về xem giỏ hàng
            header("Location: ?controller=cart&action=view");
            exit;
        }
    }

    public function view()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $cart = $_SESSION['cart'] ?? [];

        require_once __DIR__ . '/../models/ProductModel.php';
        $products_info = [];

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $products_info[$item['product_id']] = $product;
            }
        }

        require __DIR__ . '/../views/cart/view.php';
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $qtys = $_POST['qty'] ?? [];

            if (!empty($_SESSION['cart']) && is_array($qtys)) {
                foreach ($qtys as $key => $qty) {
                    $qty = intval($qty);
                    if ($qty > 0 && isset($_SESSION['cart'][$key])) {
                        $_SESSION['cart'][$key]['qty'] = $qty;
                    }
                }
            }
        }

        header("Location: ?controller=cart&action=view");
        exit;
    }

    public function remove()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $key = $_GET['key'] ?? '';
        if ($key && isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
        header("Location: ?controller=cart&action=view");
        exit;
    }
}
