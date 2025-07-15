<?php
require_once __DIR__ . '/../../includes/db.php';

class OrderModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    // Lấy danh sách đơn hàng, mới nhất trước
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // Lấy chi tiết đơn hàng theo id
    public function getById($id)
    {
        // Lấy order info
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();

        if (!$order) return null;

        // Lấy các item của đơn hàng kèm info product
        $stmtItems = $this->pdo->prepare("
            SELECT oi.*, p.name AS product_name, p.thumbnail
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmtItems->execute([$id]);
        $order['items'] = $stmtItems->fetchAll();

        return $order;
    }

    // Update trạng thái đơn hàng (nếu cần)
    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getStatsByStatus()
    {
        $stmt = $this->pdo->query("
        SELECT status, COUNT(*) as count 
        FROM orders 
        GROUP BY status
    ");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    // Thống kê doanh thu 6 tháng gần nhất
    public function getMonthlyRevenueLast6Months()
    {
        $stmt = $this->pdo->query("
        SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(total) AS revenue
        FROM orders
        WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY month
        ORDER BY month ASC
    ");
        $result = $stmt->fetchAll();
        // Chuẩn hóa dữ liệu để dễ dùng JS
        $months = [];
        $revenues = [];
        $now = new DateTime();
        for ($i = 5; $i >= 0; $i--) {
            $m = $now->modify("-$i month")->format('Y-m');
            $found = false;
            foreach ($result as $row) {
                if ($row['month'] === $m) {
                    $months[] = $m;
                    $revenues[] = (float)$row['revenue'];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $months[] = $m;
                $revenues[] = 0;
            }
            $now->modify("+$i month"); // reset lại thời gian
        }
        return ['months' => $months, 'revenues' => $revenues];
    }

    // Lấy đơn hàng mới nhất, limit $limit
    public function getLatestOrders($limit = 5)
    {
        $stmt = $this->pdo->prepare("
        SELECT o.id, o.customer_name, o.total, o.status, o.created_at
        FROM orders o
        ORDER BY o.created_at DESC
        LIMIT :limit
    ");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
