<?php
require_once __DIR__ . '/../includes/db.php';

class Product
{
    public static function getAll($filters = [], $page = 1, $pageSize = 5)
    {
        $pdo = getPDO();
        $sql = "SELECT DISTINCT p.* FROM products p 
            JOIN product_stock ps ON p.id = ps.product_id 
            WHERE 1";
        $params = [];

        // --- Lọc theo keyword
        if (!empty($filters['keyword'])) {
            $sql .= " AND p.name LIKE ?";
            $params[] = '%' . $filters['keyword'] . '%';
        }

        // --- Lọc theo giá
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = (float)$filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = (float)$filters['max_price'];
        }

        // --- Lọc theo size
        if (!empty($filters['size']) && is_numeric($filters['size'])) {
            $sql .= " AND ps.size_eu = ?";
            $params[] = (int)$filters['size'];
        }

        // --- Phân trang
        $page = max(1, (int)$page);
        $pageSize = max(1, (int)$pageSize);
        $offset = ($page - 1) * $pageSize;

        $sql .= " ORDER BY p.created_at DESC LIMIT $pageSize OFFSET $offset";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public static function countAll($filters = [])
    {
        $pdo = getPDO();
        $sql = "SELECT COUNT(DISTINCT p.id) FROM products p
            JOIN product_stock ps ON p.id = ps.product_id
            WHERE 1";
        $params = [];

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

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    public static function find($id)
    {
        $pdo = getPDO();

        // Lấy sản phẩm và tên danh mục
        $stmt = $pdo->prepare("
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            return null;
        }

        // Lấy hình ảnh
        $stmt = $pdo->prepare("SELECT img_path, alt_text FROM product_images WHERE product_id = ?");
        $stmt->execute([$id]);
        $product['images'] = $stmt->fetchAll();

        // Lấy tồn kho từng size
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
        $stmt = $pdo->query("SELECT DISTINCT size_eu FROM product_stock ORDER BY size_eu ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
