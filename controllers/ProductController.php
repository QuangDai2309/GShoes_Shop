<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController
{
    public function list()
    {
        // Lấy các filter từ URL (lọc giá, tên, size)
        $filters = [
            'keyword'    => $_GET['keyword'] ?? '',
            'min_price'  => $_GET['min_price'] ?? '',
            'max_price'  => $_GET['max_price'] ?? '',
            'size'       => $_GET['size'] ?? ''
        ];

        // Trang hiện tại (nếu sai hoặc <1 thì trả về 1)
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $pageSize = 6; // Số sản phẩm mỗi trang

        // Lấy dữ liệu sản phẩm & tổng số bản ghi để tính tổng trang
        $products    = Product::getAll($filters, $currentPage, $pageSize);
        $totalItems  = Product::countAll($filters);
        $totalPages  = ceil($totalItems / $pageSize);

        // Lấy danh sách size để đổ ra dropdown
        $sizes = Product::getSizes();

        // Truyền sang view
        require 'views/product/list.php';
    }

    public function detail()
    {
        $id = $_GET['id'] ?? 0;
        $product = Product::find($id);
        if (!$product) {
            echo "Sản phẩm không tồn tại.";
            return;
        }

        require 'views/product/detail.php';
    }
}
