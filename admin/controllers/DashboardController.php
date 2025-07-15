<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class DashboardController
{
    private $productModel;
    private $categoryModel;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Load tổng quan
        $data = [
            'totalProducts' => count($this->productModel->getAll()),
            'totalCategories' => count($this->categoryModel->getAll()),
            'totalOrders' => count($this->orderModel->getAll()),
            'totalUsers' => count($this->userModel->getAll()),
            'orderStats' => $this->orderModel->getStatsByStatus(),

            // Thống kê doanh thu theo tháng (giả sử có hàm này)
            'monthlyRevenue' => $this->orderModel->getMonthlyRevenueLast6Months(),

            // Đơn hàng mới (chờ xử lý, limit 5)
            'latestOrders' => $this->orderModel->getLatestOrders(5),
        ];

        extract($data);
        require __DIR__ . '/../views/dashboard/index.php';
    }
}
