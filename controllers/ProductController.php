<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController
{
    public function list()
    {
        $filters = [
            'keyword'      => $_GET['keyword'] ?? '',
            'min_price'    => $_GET['min_price'] ?? '',
            'max_price'    => $_GET['max_price'] ?? '',
            'size'         => $_GET['size'] ?? '',
            'category_id'  => $_GET['category_id'] ?? '',
        ];

        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $pageSize = 6;

        $products   = Product::getAll($filters, $currentPage, $pageSize);
        $totalItems = Product::countAll($filters);
        $totalPages = ceil($totalItems / $pageSize);

        $sizes = Product::getSizes();
        $categories = Product::getCategories(); // 🆕

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
