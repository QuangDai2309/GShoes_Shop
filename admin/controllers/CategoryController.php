<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController
{
    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['admin_user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        $this->model = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->model->getAll();
        require __DIR__ . '/../views/category/index.php';
    }

    public function create()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            if ($name && $slug) {
                // Kiểm tra slug trùng
                if ($this->model->isSlugExists($slug)) {
                    $error = 'Slug đã tồn tại, vui lòng chọn slug khác.';
                } else {
                    $this->model->create($name, $slug);
                    header("Location: index.php?controller=category&action=index");
                    exit;
                }
            } else {
                $error = 'Vui lòng nhập đầy đủ tên và slug.';
            }
        }
        require __DIR__ . '/../views/category/create.php';
    }


    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $category = $this->model->getById($id);
        $error = '';

        if (!$category) {
            echo "Danh mục không tồn tại";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $slug = trim($_POST['slug']);
            if ($name && $slug) {
                // Kiểm tra slug trùng với các danh mục khác
                if ($this->model->isSlugExists($slug, $id)) {
                    $error = 'Slug đã tồn tại, vui lòng chọn slug khác.';
                } else {
                    $this->model->update($id, $name, $slug);
                    header("Location: index.php?controller=category&action=index");
                    exit;
                }
            } else {
                $error = 'Vui lòng nhập đầy đủ tên và slug.';
            }
        }

        require __DIR__ . '/../views/category/edit.php';
    }


    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['delete_error'] = "ID danh mục không hợp lệ.";
            header("Location: index.php?controller=category&action=index");
            exit;
        }

        $result = $this->model->delete($id);

        if ($result['status']) {
            $_SESSION['delete_success'] = $result['message'];
        } else {
            $_SESSION['delete_error'] = $result['message'];
        }

        header("Location: index.php?controller=category&action=index");
        exit;
    }
}
