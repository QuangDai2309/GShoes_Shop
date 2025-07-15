<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Thêm sản phẩm mới</h1>

    <?php if (!empty($errs)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
            <?php foreach ($errs as $er) echo "<li>".htmlspecialchars($er)."</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <!-- 1. Thông tin cơ bản -->
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tên sản phẩm</label>
                <input name="name" class="form-control" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">SKU</label>
                <input name="sku" class="form-control" required value="<?= htmlspecialchars($_POST['sku'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá (₫)</label>
                <input name="price" type="number" min="0" step="0.01" class="form-control" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-select" required>
                    <option value="">--Chọn--</option>
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (($_POST['category_id'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Thumbnail (ảnh chính)</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control" required>
            </div>
        </div>

        <!-- 2. Mô tả -->
        <div class="mt-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <!-- 3. Ảnh phụ -->
        <div class="mt-3">
            <label class="form-label">Ảnh phụ (có thể chọn nhiều)</label>
            <input type="file" name="images[]" accept="image/*" multiple class="form-control">
        </div>

        <!-- 4. Tồn kho size EU -->
        <div class="mt-4">
            <label class="form-label d-block">Tồn kho theo size (EU)</label>
            <div class="row g-2">
            <?php for ($size = 35; $size <= 45; $size++): ?>
                <div class="col-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><?= $size ?></span>
                        <input type="number" min="0" name="size_qty[<?= $size ?>]" class="form-control"
                               value="<?= htmlspecialchars($_POST['size_qty'][$size] ?? 0) ?>">
                    </div>
                </div>
            <?php endfor; ?>
            </div>
        </div>

        <button class="btn btn-success mt-4" type="submit">Lưu sản phẩm</button>
        <a href="index.php?controller=product&action=index" class="btn btn-secondary mt-4">Hủy</a>
    </form>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
