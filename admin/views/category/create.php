<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Thêm danh mục mới</h1>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?controller=category&action=create" method="post" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" id="name" name="name" class="form-control" required
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control" required
                value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>">
            <div class="form-text">Slug dùng để tạo URL thân thiện, ví dụ: danh-muc-san-pham</div>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="index.php?controller=category&action=index" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<script>
    // Hàm chuyển tiếng Việt có dấu sang không dấu, viết thường, thay khoảng trắng thành dấu '-'
    function toSlug(str) {
        str = str.toLowerCase();

        // Bỏ dấu tiếng Việt
        str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, "");

        // Thay khoảng trắng và kí tự đặc biệt thành '-'
        str = str.replace(/[^a-z0-9]+/g, '-');

        // Xóa dấu '-' thừa ở đầu cuối
        str = str.replace(/^-+|-+$/g, '');

        return str;
    }

    // Lấy 2 input name và slug
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    // Khi nhập tên, tự động cập nhật slug nếu slug đang rỗng hoặc trùng với slug tự tạo trước đó
    nameInput.addEventListener('input', () => {
        const newSlug = toSlug(nameInput.value);

        // Chỉ tự điền slug khi slug hiện tại trống hoặc trùng slug trước đó
        if (!slugInput.value || slugInput.value === toSlug(slugInput.value)) {
            slugInput.value = newSlug;
        }
    });
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
