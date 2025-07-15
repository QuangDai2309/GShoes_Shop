<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/ProductModel.php';

class OrderModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    /**
     * Tạo đơn hàng mới kèm kiểm tra tồn kho, giảm tồn kho, thêm chi tiết đơn
     * @param string $name, $email, $phone, $address - thông tin khách hàng
     * @param array $cart - mảng sản phẩm trong giỏ [ ['product_id'=>, 'size'=>, 'quantity'=>], ... ]
     * @return int|false - trả về order_id nếu thành công, false nếu thất bại
     */
    public function createOrder($user_id, $name, $email, $phone, $address, $cart)
    {
        try {
            $this->pdo->beginTransaction();

            // Tính tổng tiền đơn hàng
            $total = 0;
            foreach ($cart as $item) {
                $productId = $item['product_id'];
                $size = $item['size'] ?? null;
                $qty = $item['qty'];

                // Kiểm tra tồn kho và lấy giá
                $price = $this->checkStock($productId, $size, $qty);
                $total += $price * $qty;
            }

            // Thêm đơn hàng với user_id
            $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, customer_address, total, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
            $stmt->execute([$user_id, $name, $email, $phone, $address, $total]);
            $orderId = $this->pdo->lastInsertId();

            // Thêm chi tiết đơn và trừ kho
            $stmtInsert = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, size_eu, price, qty) VALUES (?, ?, ?, ?, ?)");
            $stmtUpdateStock = $this->pdo->prepare("UPDATE product_stock SET quantity = quantity - ? WHERE product_id = ? AND size_eu = ? AND quantity >= ?");

            foreach ($cart as $item) {
                $productId = $item['product_id'];
                $size = $item['size'] ?? null;
                $qty = $item['qty'];

                $price = $this->checkStock($productId, $size, $qty); // Lấy giá lại (an toàn)

                $stmtInsert->execute([$orderId, $productId, $size, $price, $qty]);

                // Giảm tồn kho
                $stmtUpdateStock->execute([$qty, $productId, $size, $qty]);
                if ($stmtUpdateStock->rowCount() == 0) {
                    throw new Exception("Tồn kho không đủ cho sản phẩm ID $productId size $size.");
                }
            }

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Lỗi tạo đơn hàng: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Kiểm tra tồn kho và trả về giá sản phẩm
     */
    private function checkStock($product_id, $size_eu, $qty)
    {
        $sql = "SELECT p.price, ps.quantity
                FROM products p
                JOIN product_stock ps ON p.id = ps.product_id AND ps.size_eu = ?
                WHERE p.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$size_eu, $product_id]);
        $product = $stmt->fetch();

        if (!$product) {
            throw new Exception("Sản phẩm ID $product_id hoặc size $size_eu không tồn tại.");
        }
        if ($product['quantity'] < $qty) {
            throw new Exception("Không đủ tồn kho cho sản phẩm ID $product_id size $size_eu.");
        }
        return $product['price'];
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
