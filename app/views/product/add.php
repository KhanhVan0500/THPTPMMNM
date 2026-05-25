<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">➕ Thêm sản phẩm mới</h4>
            </div>
            <div class="card-body">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/Product/save"
                      enctype="multipart/form-data"
                      onsubmit="return validateForm()">

                    <div class="form-group">
                        <label for="name"><strong>Tên sản phẩm:</strong></label>
                        <input type="text" id="name" name="name" class="form-control"
                               placeholder="Nhập tên sản phẩm (10-100 ký tự)"
                               value="<?php echo htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description"><strong>Mô tả:</strong></label>
                        <textarea id="description" name="description" class="form-control"
                                  rows="3" placeholder="Nhập mô tả sản phẩm" required><?php
                            echo htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8');
                        ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price"><strong>Giá (VND):</strong></label>
                        <input type="number" id="price" name="price" class="form-control"
                               step="1000" min="0"
                               placeholder="Nhập giá sản phẩm"
                               value="<?php echo htmlspecialchars($_POST['price'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="category_id"><strong>Danh mục:</strong></label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>"
                                    <?php echo (($_POST['category_id'] ?? '') == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image"><strong>Hình ảnh:</strong></label>
                        <input type="file" id="image" name="image" class="form-control-file"
                               accept="image/jpg,image/jpeg,image/png,image/gif">
                        <small class="text-muted">Định dạng: JPG, JPEG, PNG, GIF. Tối đa 10MB.</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">✅ Thêm sản phẩm</button>
                        <a href="/Product" class="btn btn-secondary">← Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm() {
    let name  = document.getElementById('name').value.trim();
    let price = parseFloat(document.getElementById('price').value);
    let errors = [];

    if (name.length < 10 || name.length > 100) {
        errors.push('Tên sản phẩm phải có từ 10 đến 100 ký tự.');
    }
    if (isNaN(price) || price <= 0) {
        errors.push('Giá phải là một số dương lớn hơn 0.');
    }
    if (errors.length > 0) {
        alert(errors.join('\n'));
        return false;
    }
    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
