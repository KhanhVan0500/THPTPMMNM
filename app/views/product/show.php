<?php include 'app/views/shares/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Chi tiết sản phẩm</h3>
            </div>
            <div class="card-body">
                <?php if ($product): ?>
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <?php if (!empty($product->image)): ?>
                                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                     class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     style="max-height:350px; object-fit:cover; width:100%;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                     style="height:250px;">
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
                                <a href="/Product/edit/<?php echo $product->id; ?>"
                                   class="btn btn-warning">✏️ Sửa</a>
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
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
