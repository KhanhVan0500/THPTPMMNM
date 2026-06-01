<?php include 'app/views/shares/header.php'; ?>

<style>
    .image-carousel {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background: #f8f9fa;
        min-height: 350px;
    }

    .carousel-image-main {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 8px;
        display: block;
    }

    .carousel-thumbnails {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .carousel-thumbnail {
        width: 70px;
        height: 70px;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .carousel-thumbnail:hover,
    .carousel-thumbnail.active {
        border-color: #007bff;
        transform: scale(1.05);
    }

    .carousel-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .carousel-arrow:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .carousel-arrow.prev {
        left: 10px;
    }

    .carousel-arrow.next {
        right: 10px;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Chi tiết sản phẩm</h3>
            </div>
            <div class="card-body">
                <?php if ($product): ?>
                    <div class="row">
                        <div class="col-md-5">
                            <?php 
                            $images = $productModel->getProductImages($product->id);
                            $hasImages = !empty($images) && count($images) > 0;
                            ?>
                            
                            <?php if ($hasImages): ?>
                                <!-- Image Carousel -->
                                <div class="image-carousel" id="imageCarousel">
                                    <img id="mainImage" src="/<?php echo htmlspecialchars($images[0]->image_path, ENT_QUOTES, 'UTF-8'); ?>" 
                                         alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                         class="carousel-image-main">
                                    
                                    <?php if (count($images) > 1): ?>
                                        <button class="carousel-arrow prev" onclick="changeImage(-1)">❮</button>
                                        <button class="carousel-arrow next" onclick="changeImage(1)">❯</button>
                                    <?php endif; ?>
                                </div>

                                <?php if (count($images) > 1): ?>
                                    <!-- Thumbnails -->
                                    <div class="carousel-thumbnails" id="thumbnails">
                                        <?php foreach ($images as $index => $img): ?>
                                            <img class="carousel-thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                 src="/<?php echo htmlspecialchars($img->image_path, ENT_QUOTES, 'UTF-8'); ?>" 
                                                 alt="Ảnh <?php echo $index + 1; ?>" 
                                                 onclick="setImage(<?php echo $index; ?>)">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <script>
                                    const images = <?php echo json_encode(array_map(fn($img) => $img->image_path, $images)); ?>;
                                    let currentImageIndex = 0;

                                    function setImage(index) {
                                        if (index >= 0 && index < images.length) {
                                            currentImageIndex = index;
                                            document.getElementById('mainImage').src = '/' + images[index];
                                            
                                            document.querySelectorAll('.carousel-thumbnail').forEach((thumb, i) => {
                                                thumb.classList.toggle('active', i === index);
                                            });
                                        }
                                    }

                                    function changeImage(direction) {
                                        currentImageIndex = (currentImageIndex + direction + images.length) % images.length;
                                        setImage(currentImageIndex);
                                    }
                                </script>
                            <?php elseif (!empty($product->image)): ?>
                                <!-- Fallback to main image -->
                                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                     class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     style="max-height:350px; object-fit:cover; width:100%;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                     style="height:350px;">
                                    <span class="text-muted" style="font-size:4rem;">🖼️</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-7">
                            <h3 class="font-weight-bold text-dark">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <hr>
                            <p class="text-secondary">
                                <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                            <p class="h4 text-danger font-weight-bold">
                                💰 <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                            </p>
                            <p>
                                <strong>Danh mục:</strong>
                                <span class="badge badge-info px-2 py-1">
                                    <?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại', ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </p>
                            <div class="mt-4 d-flex flex-wrap" style="gap:8px; align-items:center;">
                                <form method="post" action="/Product/addToCart/<?php echo $product->id; ?>" class="d-flex align-items-center" style="gap:10px;">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width:100px;">
                                    <button type="submit" class="btn btn-success btn-lg">🛒 Thêm vào giỏ hàng</button>
                                </form>
                                <?php if (SessionHelper::isAdmin()) : ?>
                                    <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">✏️ Sửa</a>
                                <?php endif; ?>
                                <a href="/Product" class="btn btn-secondary">← Danh sách</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger text-center">
                        <h5>Không tìm thấy sản phẩm!</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h4 class="mb-0">Đánh giá sản phẩm</h4>
                        <p class="text-muted mb-0">Xem đánh giá từ khách hàng và góp ý cho sản phẩm.</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="mr-3" style="font-size:1.4rem; color:#f5b301;">★★★★★</div>
                                <div>
                                    <strong>4.8/5</strong> · 12 đánh giá
                                </div>
                            </div>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <?php if (SessionHelper::isLoggedIn()) : ?>
                            <form method="post" action="#" class="mb-4">
                                <div class="form-group">
                                    <label for="reviewText">Viết đánh giá của bạn</label>
                                    <textarea id="reviewText" class="form-control" rows="4" placeholder="Chia sẻ cảm nhận về sản phẩm..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-info mb-4">
                                Bạn cần <a href="/account/login">đăng nhập</a> để gửi đánh giá.
                            </div>
                        <?php endif; ?>

                        <div class="review-item border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Nguyễn Văn A</strong>
                                <span class="text-warning">★★★★☆</span>
                            </div>
                            <p class="mb-1">Sản phẩm chất lượng, giao nhanh và đúng như mô tả. Rất hài lòng!</p>
                            <small class="text-muted">03/05/2026</small>
                        </div>
                        <div class="review-item border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Trần Thị B</strong>
                                <span class="text-warning">★★★★★</span>
                            </div>
                            <p class="mb-1">Thiết kế đẹp, pin tốt và sử dụng mượt. Sẽ mua tiếp.</p>
                            <small class="text-muted">25/04/2026</small>
                        </div>
                        <div class="review-item border rounded p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Phạm C</strong>
                                <span class="text-warning">★★★★☆</span>
                            </div>
                            <p class="mb-1">Tốt trong tầm giá, chỉ tiếc chưa có thêm màu tùy chọn.</p>
                            <small class="text-muted">18/04/2026</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
