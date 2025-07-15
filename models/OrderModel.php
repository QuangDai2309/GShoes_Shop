<?php
require_once __DIR__ . '/../includes/db.php';

class OrderModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function checkStock($product_id, $size_eu, $qty)
    {
        $stmt = $this->pdo->prepare("SELECT p.price, ps.quantity
                                     FROM products p
                                     JOIN product_stock ps ON p.id = ps.product_id AND ps.size_eu = ?
                                     WHERE p.id = ?");
        $stmt->execute([$size_eu, $product_id]);
        $product = $stmt->fetch();

        if (!$product) {
            throw new Exception("Sản phẩm không tồn tại hoặc size không hợp lệ.");
        }

        if ($product['quantity'] < $qty) {
            throw new Exception("Không đủ tồn kho cho sản phẩm ID $product_id size $size_eu.");
        }

        return $product['price'];
    }

    public function createOrder($user_id, $total)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total, status, created_at)
                                     VALUES (?, ?, 'pending', NOW())");
        $stmt->execute([$user_id, $total]);
        return $this->pdo->lastInsertId();
    }

    public function addOrderItem($order_id, $product_id, $size_eu, $price, $qty)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, size_eu, price, qty)
                                     VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$order_id, $product_id, $size_eu, $price, $qty]);
    }

    public function reduceStock($product_id, $size_eu, $qty)
    {
        $stmt = $this->pdo->prepare("UPDATE product_stock
                                     SET quantity = quantity - ?
                                     WHERE product_id = ? AND size_eu = ? AND quantity >= ?");
        $stmt->execute([$qty, $product_id, $size_eu, $qty]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Tồn kho bị thay đổi. Không thể đặt hàng sản phẩm ID $product_id.");
        }
    }

    public function getOrderById($order_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch();
    }

    public function getOrderItems($order_id)
    {
        $stmt = $this->pdo->prepare("SELECT oi.*, p.name
                                     FROM order_items oi
                                     JOIN products p ON oi.product_id = p.id
                                     WHERE oi.order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll();
    }

    public function getUserOrders($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function getUserOrderById($order_id, $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
        $stmt->execute([$order_id, $user_id]);
        return $stmt->fetch();
    }
}
