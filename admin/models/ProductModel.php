<?php
require_once __DIR__ . '/../../includes/db.php';

class ProductModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (category_id, name, sku, price, description, thumbnail, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['sku'],
            $data['price'],
            $data['description'],
            $data['thumbnail']
        ]);
    }

    public function createFull(array $product, array $stocks, array $images)
    {
        $this->pdo->beginTransaction();
        try {
            /* 1. Thêm product */
            $stmt = $this->pdo->prepare(
                "INSERT INTO products (category_id, name, sku, price, description, thumbnail, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([
                $product['category_id'],
                $product['name'],
                $product['sku'],
                $product['price'],
                $product['description'],
                $product['thumbnail']
            ]);
            $productId = $this->pdo->lastInsertId();

            /* 2. Thêm tồn kho theo size */
            if (!empty($stocks)) {
                $stmtStock = $this->pdo->prepare(
                    "INSERT INTO product_stock (product_id, size_eu, quantity)
                 VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE quantity = VALUES(quantity)"
                );
                foreach ($stocks as $size => $qty) {
                    $qty = (int)$qty;
                    if ($qty < 0) $qty = 0;
                    $stmtStock->execute([$productId, $size, $qty]);
                }
            }

            /* 3. Thêm ảnh phụ */
            if (!empty($images)) {
                $stmtImg = $this->pdo->prepare(
                    "INSERT INTO product_images (product_id, img_path, alt_text) VALUES (?, ?, ?)"
                );
                foreach ($images as $path) {
                    $stmtImg->execute([$productId, $path, $product['name']]);
                }
            }

            $this->pdo->commit();
            return $productId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE products SET category_id = ?, name = ?, sku = ?, price = ?, description = ?, thumbnail = ? WHERE id = ?");
        return $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['sku'],
            $data['price'],
            $data['description'],
            $data['thumbnail'],
            $id
        ]);
    }

    /** Lấy stock dạng [size => qty] */
    public function getStock($productId): array
    {
        $stmt = $this->pdo->prepare("SELECT size_eu, quantity FROM product_stock WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);  // [size => qty]
    }

    /** Lấy danh sách ảnh phụ */
    public function getImages($productId): array
    {
        $stmt = $this->pdo->prepare("SELECT id, img_path FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    /** Cập nhật toàn bộ product + stock + images */
    public function updateFull(int $id, array $product, array $stocks, array $newImages, array $imagesToDelete)
    {
        $this->pdo->beginTransaction();
        try {
            /* 1. update product */
            $stmt = $this->pdo->prepare(
                "UPDATE products SET category_id=?, name=?, sku=?, price=?, description=?, thumbnail=? WHERE id=?"
            );
            $stmt->execute([
                $product['category_id'],
                $product['name'],
                $product['sku'],
                $product['price'],
                $product['description'],
                $product['thumbnail'],
                $id
            ]);

            /* 2. update stock: xóa hết & insert lại đơn giản */
            $this->pdo->prepare("DELETE FROM product_stock WHERE product_id=?")->execute([$id]);
            if ($stocks) {
                $st = $this->pdo->prepare(
                    "INSERT INTO product_stock (product_id,size_eu,quantity) VALUES (?,?,?)"
                );
                foreach ($stocks as $size => $qty) {
                    $qty = (int)$qty;
                    $st->execute([$id, $size, $qty < 0 ? 0 : $qty]);
                }
            }

            /* 3. delete images ticked */
            if ($imagesToDelete) {
                $in = implode(',', array_fill(0, count($imagesToDelete), '?'));
                $this->pdo->prepare("DELETE FROM product_images WHERE id IN ($in)")->execute($imagesToDelete);
            }

            /* 4. insert new images */
            if ($newImages) {
                $st = $this->pdo->prepare(
                    "INSERT INTO product_images (product_id,img_path,alt_text) VALUES (?,?,?)"
                );
                foreach ($newImages as $path) {
                    $st->execute([$id, $path, $product['name']]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        $this->pdo->beginTransaction();

        try {
            // Xóa order_items liên quan
            $stmt = $this->pdo->prepare("DELETE FROM order_items WHERE product_id = ?");
            $stmt->execute([$id]);

            // Xóa product_images liên quan
            $stmt = $this->pdo->prepare("DELETE FROM product_images WHERE product_id = ?");
            $stmt->execute([$id]);

            // Xóa product_stock liên quan
            $stmt = $this->pdo->prepare("DELETE FROM product_stock WHERE product_id = ?");
            $stmt->execute([$id]);

            // Cuối cùng xóa sản phẩm
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);

            $this->pdo->commit();
            return ['status' => true, 'message' => 'Xóa sản phẩm thành công.'];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['status' => false, 'message' => 'Lỗi khi xóa sản phẩm: ' . $e->getMessage()];
        }
    }


    public function skuExists($sku, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE sku = ? AND id != ?");
            $stmt->execute([$sku, $excludeId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE sku = ?");
            $stmt->execute([$sku]);
        }
        return $stmt->fetchColumn() > 0;
    }
}
