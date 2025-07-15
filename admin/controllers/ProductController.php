<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ProductController
{
    private $model;
    private $categoryModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $this->model = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $products = $this->model->getAll();
        require __DIR__ . '/../views/product/index.php';
    }

    public function create()
    {
        $cats  = $this->categoryModel->getAll();
        $errs  = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /*==== 1. Lấy dữ liệu form ====*/
            $data = [
                'category_id' => $_POST['category_id'] ?? null,
                'name'        => trim($_POST['name'] ?? ''),
                'sku'         => trim($_POST['sku'] ?? ''),
                'price'       => (float)($_POST['price'] ?? 0),
                'description' => trim($_POST['description'] ?? ''),
                'thumbnail'   => '',
            ];

            /*==== 2. Validate cơ bản ====*/
            if (!$data['category_id'])      $errs[] = 'Chọn danh mục.';
            if ($data['name'] === '')       $errs[] = 'Nhập tên.';
            if ($data['sku'] === '')        $errs[] = 'Nhập SKU.';
            if ($this->model->skuExists($data['sku'])) $errs[] = 'SKU đã tồn tại.';
            if ($data['price'] <= 0)        $errs[] = 'Giá > 0.';

            /*==== 3. Upload thumbnail ====*/
            if (!empty($_FILES['thumbnail']['name'])) {
                $thumbPath = $this->uploadFile($_FILES['thumbnail']);
                if ($thumbPath) $data['thumbnail'] = $thumbPath;
                else $errs[] = 'Upload thumbnail lỗi.';
            } else {
                $errs[] = 'Chọn thumbnail.';
            }

            /*==== 4. Build array tồn kho ====*/
            $stockSizes = $_POST['size_qty'] ?? []; // [size => qty]

            /*==== 5. Upload ảnh phụ ====*/
            $extraImgs = [];
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
                    if ($_FILES['images']['error'][$k] === 0) {
                        $path = $this->uploadFile([
                            'name'     => $_FILES['images']['name'][$k],
                            'type'     => $_FILES['images']['type'][$k],
                            'tmp_name' => $tmp,
                            'error'    => 0,
                            'size'     => $_FILES['images']['size'][$k],
                        ]);
                        if ($path) $extraImgs[] = $path;
                    }
                }
            }

            /*==== 6. Nếu ok -> insert ====*/
            if (empty($errs)) {
                try {
                    $this->model->createFull($data, $stockSizes, $extraImgs);
                    $_SESSION['success'] = 'Thêm sản phẩm thành công.';
                    header("Location: index.php?controller=product&action=index");
                    exit;
                } catch (Exception $e) {
                    $errs[] = 'Lỗi DB: ' . $e->getMessage();
                }
            }
        }

        require __DIR__ . '/../views/product/create.php';
    }

    /* Helper upload file, trả về relative path hoặc false */
    function uploadFile($file, $targetDir = '/uploads/products/')
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileName = basename($file['name']);
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $base = pathinfo($fileName, PATHINFO_FILENAME);

        $targetPath = $targetDir . $fileName;
        $absolutePath = __DIR__ . '/..' . $targetPath;

        // Tạo thư mục nếu chưa có
        $folder = dirname($absolutePath);
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Nếu file tồn tại thì tự động thêm hậu tố _1, _2,...
        $counter = 1;
        while (file_exists($absolutePath)) {
            $newFileName = $base . '_' . $counter . '.' . $ext;
            $targetPath = $targetDir . $newFileName;
            $absolutePath = __DIR__ . '/..' . $targetPath;
            $counter++;
        }

        if (move_uploaded_file($file['tmp_name'], $absolutePath)) {
            return $targetPath; // Trả về đường dẫn tương đối để lưu DB
        }

        return null;
    }



    public function edit()
    {
        $id       = $_GET['id'] ?? 0;
        $product  = $this->model->getById($id);
        if (!$product) {
            echo "SP k tồn tại";
            exit;
        }

        $cats     = $this->categoryModel->getAll();
        $stockOld = $this->model->getStock($id);        // [size=>qty]
        $imgOld   = $this->model->getImages($id);       // [{id,img_path},...]

        $errs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /* === lấy dữ liệu === */
            $data = [
                'category_id' => $_POST['category_id'] ?? null,
                'name'        => trim($_POST['name'] ?? ''),
                'sku'         => trim($_POST['sku'] ?? ''),
                'price'       => (float)($_POST['price'] ?? 0),
                'description' => trim($_POST['description'] ?? ''),
                'thumbnail'   => $product['thumbnail'],   // default giữ nguyên
            ];

            /* Upload thumbnail mới nếu chọn */
            if (!empty($_FILES['thumbnail']['name'])) {
                $thumb = $this->uploadFile($_FILES['thumbnail']);
                if ($thumb) $data['thumbnail'] = $thumb;
                else $errs[] = 'Upload thumbnail lỗi.';
            }

            /* Validate sơ bộ */
            if (!$data['category_id']) $errs[] = 'Chọn danh mục.';
            if ($data['name'] === '')  $errs[] = 'Nhập tên.';
            if ($data['sku'] === '')   $errs[] = 'Nhập SKU.';
            if ($this->model->skuExists($data['sku'], $id)) $errs[] = 'SKU trùng.';
            if ($data['price'] <= 0)   $errs[] = 'Giá > 0.';

            /* Stocks */
            $stocks = $_POST['size_qty'] ?? [];

            /* Xử lý ảnh phụ */
            $imgsDelete = $_POST['del_img'] ?? [];   // id ảnh tick xóa
            $newImgs    = [];
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['name'] as $k => $n) {
                    if ($_FILES['images']['error'][$k] === 0) {
                        $p = $this->uploadFile([
                            'name' => $n,
                            'tmp_name' => $_FILES['images']['tmp_name'][$k],
                            'type' => $_FILES['images']['type'][$k],
                            'error' => 0,
                            'size' => $_FILES['images']['size'][$k]
                        ]);
                        if ($p) $newImgs[] = $p;
                    }
                }
            }

            if (empty($errs)) {
                try {
                    $this->model->updateFull($id, $data, $stocks, $newImgs, $imgsDelete);
                    $_SESSION['success'] = 'Cập nhật OK';
                    header("Location: index.php?controller=product&action=index");
                    exit;
                } catch (Exception $e) {
                    $errs[] = $e->getMessage();
                }
            }
        }

        require __DIR__ . '/../views/product/edit.php';
    }


    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['delete_error'] = "ID sản phẩm không hợp lệ.";
            header("Location: index.php?controller=product&action=index");
            exit;
        }

        $result = $this->model->delete($id);

        if ($result['status']) {
            $_SESSION['delete_success'] = $result['message'];
        } else {
            $_SESSION['delete_error'] = $result['message'];
        }

        header("Location: index.php?controller=product&action=index");
        exit;
    }
}
