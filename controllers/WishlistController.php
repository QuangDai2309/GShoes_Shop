<?php
require_once __DIR__ . '/../includes/db.php';
class WishlistController
{
    public function add()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $product_id = intval($_GET['product_id'] ?? 0);
        if ($product_id > 0) {
            if (!isset($_SESSION['wishlist'])) {
                $_SESSION['wishlist'] = [];
            }
            if (!in_array($product_id, $_SESSION['wishlist'])) {
                $_SESSION['wishlist'][] = $product_id;
            }
        }
        header("Location: ?controller=wishlist&action=view");
        exit;
    }

    public function remove()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $product_id = intval($_GET['product_id'] ?? 0);
        if ($product_id > 0 && !empty($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function($id) use ($product_id) {
                return $id !== $product_id;
            });
            // Re-index array
            $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
        }
        header("Location: ?controller=wishlist&action=view");
        exit;
    }

    public function view()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $pdo = getPDO();

        $wishlist = $_SESSION['wishlist'] ?? [];

        $products = [];
        if ($wishlist) {
            // Lấy chi tiết sản phẩm yêu thích
            $in = str_repeat('?,', count($wishlist) - 1) . '?';
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)");
            $stmt->execute($wishlist);
            $products = $stmt->fetchAll();
        }

        require __DIR__ . '/../views/wishlist/view.php';
    }
}
