<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <h1>Sửa sản phẩm</h1>

    <?php if ($errs): ?>
        <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errs as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <!-- row info -->
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tên sản phẩm</label>
                <input class="form-control" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">SKU</label>
                <input class="form-control" name="sku" value="<?= htmlspecialchars($_POST['sku'] ?? $product['sku']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá (₫)</label>
                <input type="number" min="0" step="0.01" class="form-control" name="price"
                       value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Danh mục</label>
                <select class="form-select" name="category_id">
                    <?php foreach ($cats as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= (($product['category_id']==$c['id'])|| (($_POST['category_id']??'')==$c['id']))? 'selected':'' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Thumbnail (nếu muốn đổi)</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control">
                <small class="text-muted">Thumbnail hiện tại:</small><br>
                <img src="/GShoes_Shop<?= $product['thumbnail'] ?>" alt="" height="80">
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Mô tả</label>
            <textarea rows="4" name="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
        </div>

        <!-- ảnh phụ hiện có -->
        <div class="mt-3">
            <label class="form-label d-block">Ảnh phụ hiện có</label>
            <div class="d-flex flex-wrap gap-3">
                <?php foreach ($imgOld as $img): ?>
                    <div class="text-center">
                        <img src="/GShoes_Shop<?= $img['img_path'] ?>" alt="" style="height:80px;width:80px;object-fit:cover" class="rounded mb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="del_img[]" value="<?= $img['id'] ?>" id="del<?= $img['id'] ?>">
                            <label class="form-check-label small" for="del<?= $img['id'] ?>">Xóa</label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- thêm ảnh phụ mới -->
        <div class="mt-3">
            <label class="form-label">Thêm ảnh phụ mới</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        </div>

        <!-- tồn kho -->
        <div class="mt-4">
            <label class="form-label d-block">Cập nhật tồn kho size EU</label>
            <div class="row g-2">
                <?php for ($size=35;$size<=45;$size++): ?>
                    <div class="col-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><?= $size ?></span>
                            <input type="number" min="0" name="size_qty[<?= $size ?>]" class="form-control"
                                   value="<?= htmlspecialchars($_POST['size_qty'][$size] ?? ($stockOld[$size] ?? 0)) ?>">
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <button class="btn btn-success mt-4">Lưu thay đổi</button>
        <a href="index.php?controller=product&action=index" class="btn btn-secondary mt-4">Hủy</a>
    </form>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
