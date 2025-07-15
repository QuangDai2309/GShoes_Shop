<?php
require_once __DIR__ . '/../../includes/db.php';

class CategoryModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($name, $slug)
    {
        $stmt = $this->pdo->prepare("INSERT INTO categories (name, slug, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$name, $slug]);
    }

    public function update($id, $name, $slug)
    {
        $stmt = $this->pdo->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
        return $stmt->execute([$name, $slug, $id]);
    }

    public function isSlugExists($slug, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM categories WHERE slug = ? AND id != ?");
            $stmt->execute([$slug, $excludeId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM categories WHERE slug = ?");
            $stmt->execute([$slug]);
        }
        return $stmt->fetchColumn() > 0;
    }

    public function delete($id)
    {
        // Kiểm tra danh mục có đang được dùng không
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Danh mục đang được dùng, không cho xóa
            return ['status' => false, 'message' => "Không thể xóa vì danh mục đang có sản phẩm."];
        } else {
            // An toàn để xóa
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            return ['status' => true, 'message' => "Đã xóa danh mục thành công."];
        }
    }
}
