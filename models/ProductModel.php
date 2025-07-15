<?php
require_once __DIR__ . '/../includes/db.php';

class Product
{
    // Hàm build phần WHERE và params cho filter
    private static function buildFilterSQL(array $filters): array
    {
        $sql = " FROM products p
                 JOIN product_stock ps ON p.id = ps.product_id
                 WHERE 1 ";
        $params = [];

        if (!empty($filters['category_id']) && is_numeric($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = (int)$filters['category_id'];
        }

        if (!empty($filters['keyword'])) {
            $sql .= " AND p.name LIKE ?";
            $params[] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = (float)$filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = (float)$filters['max_price'];
        }

        if (!empty($filters['size']) && is_numeric($filters['size'])) {
            $sql .= " AND ps.size_eu = ?";
            $params[] = (int)$filters['size'];
        }

        return ['sql' => $sql, 'params' => $params];
    }

    public static function getAll($filters = [], $page = 1, $pageSize = 5)
    {
        $pdo = getPDO();

        $filterData = self::buildFilterSQL($filters);
        $offset = max(0, ($page - 1) * $pageSize);

        // Câu SQL với dấu hỏi chấm cho LIMIT và OFFSET
        $sql = "SELECT DISTINCT p.* " . $filterData['sql'] . " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";

        $stmt = $pdo->prepare($sql);

        // Gán params filter
        $params = $filterData['params'];

        // Bind từng giá trị filter
        foreach ($params as $k => $v) {
            // 1-based index trong bindValue
            $stmt->bindValue($k + 1, $v);
        }

        // Bind LIMIT và OFFSET kiểu số nguyên
        $stmt->bindValue(count($params) + 1, (int)$pageSize, PDO::PARAM_INT);
        $stmt->bindValue(count($params) + 2, (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    public static function countAll($filters = [])
    {
        $pdo = getPDO();

        $filterData = self::buildFilterSQL($filters);

        $sql = "SELECT COUNT(DISTINCT p.id) " . $filterData['sql'];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($filterData['params']);

        return (int)$stmt->fetchColumn();
    }

    public static function find($id)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) return null;

        // Hình ảnh
        $stmt = $pdo->prepare("SELECT img_path, alt_text FROM product_images WHERE product_id = ?");
        $stmt->execute([$id]);
        $product['images'] = $stmt->fetchAll();

        // Tồn kho
        $stmt = $pdo->prepare("SELECT size_eu, quantity FROM product_stock WHERE product_id = ? ORDER BY size_eu ASC");
        $stmt->execute([$id]);
        $product['stock'] = $stmt->fetchAll();

        return $product;
    }

    public static function getFeatured($limit = 6)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getSizes()
    {
        $pdo = getPDO();
        return $pdo->query("SELECT DISTINCT size_eu FROM product_stock ORDER BY size_eu ASC")->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getCategories()
    {
        $pdo = getPDO();
        return $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
    }
}
