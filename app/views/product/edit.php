<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">✏️ Sửa sản phẩm</h4>
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

                <form method="POST" action="/Product/update"
                      enctype="multipart/form-data"
                      onsubmit="return validateForm()">

                    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="form-group">
                        <label for="name"><strong>Tên sản phẩm:</strong></label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description"><strong>Mô tả:</strong></label>
                        <textarea id="description" name="description" class="form-control" rows="3" required><?php
                            echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                        ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price"><strong>Giá (VND):</strong></label>
                        <input type="number" id="price" name="price" class="form-control"
                               step="1000" min="0"
                               value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="category_id"><strong>Danh mục:</strong></label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category->id; ?>"
                                    <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image"><strong>Hình ảnh chính:</strong></label>
                        <?php if (!empty($product->image)): ?>
                            <div class="mb-2">
                                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                     alt="Ảnh hiện tại" class="img-thumbnail" style="max-height:120px;">
                                <small class="text-muted d-block">Ảnh hiện tại — tải lên ảnh mới để thay đổi</small>
                            </div>
                        <?php endif; ?>
                        <input type="file" id="image" name="image" class="form-control-file"
                               accept="image/jpg,image/jpeg,image/png,image/gif">
                        <small class="text-muted">Định dạng: JPG, JPEG, PNG, GIF. Tối đa 10MB.</small>
                    </div>

                    <div class="form-group">
                        <label><strong>Hình ảnh bổ sung:</strong></label>
                        
                        <?php 
                        $images = $productModel->getProductImages($product->id);
                        if (!empty($images)): 
                        ?>
                            <div class="mb-3">
                                <p class="text-muted">Hình ảnh hiện tại:</p>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <?php foreach ($images as $img): ?>
                                        <div style="position: relative; width: 100px;">
                                            <img src="/<?php echo htmlspecialchars($img->image_path, ENT_QUOTES, 'UTF-8'); ?>" 
                                                 alt="Ảnh sản phẩm" 
                                                 style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                            <a href="/Product/deleteImage/<?php echo $img->id; ?>" 
                                               onclick="return confirm('Xóa ảnh này?')"
                                               style="position: absolute; top: 2px; right: 2px; background: red; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 16px; text-decoration: none;">×</a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <label for="images" style="margin-top: 15px;"><strong>Thêm hình ảnh mới (tối đa 5):</strong></label>
                        <input type="file" id="images" name="images[]" class="form-control-file" multiple
                               accept="image/jpg,image/jpeg,image/png,image/gif">
                        <small class="text-muted">Bạn có thể chọn nhiều ảnh cùng lúc. Mỗi ảnh tối đa 10MB.</small>
                        <div id="imagePreview" class="mt-2" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                    </div>

                    <script>
                        document.getElementById('images').addEventListener('change', function(e) {
                            const preview = document.getElementById('imagePreview');
                            preview.innerHTML = '';
                            
                            for (let file of this.files) {
                                if (file.type.match('image.*')) {
                                    const reader = new FileReader();
                                    reader.onload = function(event) {
                                        const img = document.createElement('img');
                                        img.src = event.target.result;
                                        img.style.width = '80px';
                                        img.style.height = '80px';
                                        img.style.objectFit = 'cover';
                                        img.style.borderRadius = '4px';
                                        img.style.border = '1px solid #ddd';
                                        preview.appendChild(img);
                                    }
                                    reader.readAsDataURL(file);
                                }
                            }
                        });
                    </script>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
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
