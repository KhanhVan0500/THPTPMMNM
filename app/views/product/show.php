<?php
$seoTitle = ($product['name'] ?? 'Sản phẩm') . ' — KZANN';
$seoDescription = textExcerpt($product['description'] ?? '', 150);
$seoImage = getImageSrc($product['image'] ?? '', $product['name'] ?? '', $product['category_id'] ?? null);
?>
<?php include BASE_PATH . '/app/views/shares/header.php'; ?>
<?= breadcrumb([['label'=>'Sản phẩm','url'=>'index.php?url=product'],['label'=>$product['name'] ?? 'Chi tiết']]) ?>

<?php $imgSrc = getImageSrc($product['image'], $product['name'], $product['category_id'] ?? null); ?>

<style>
    /* Ensure the primary color for icons in feature pills is consistent */
    .feature-pill i { background: var(--primary); color: #fff; }
</style>

<style>
    /* General page header styling */
    .page-header h2 {
        font-weight: 700;
        letter-spacing: -0.03em;
        color: var(--text-main);
    }
    .page-header p {
        color: var(--text-muted);
        font-size: 1rem;
    }

    /* Hero Chip for Product Detail */
    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-main);
        border-radius: 999px;
        padding: 8px 14px;
        font-size: .85rem;
        font-weight: 600;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }
    .hero-chip i {
        color: var(--primary);
    }
    .hero-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .page-header .hero-chip.mb-3 {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    }
    .page-header .hero-chip.mb-3 i {
        color: #fff;
    }

    /* Card styling */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }
    .card-header {
        background: #fafafa;
        border-bottom: 1px solid var(--border);
        padding: 15px 20px;
        font-weight: 600;
        color: var(--text-main); /* Ensure header text color is main */
    }
    .card-header i {
        color: var(--primary); /* Default icon color for card headers */
    }

    /* Product Image Card */
    .product-image-card .card-body {
        padding: 20px; /* Adjust padding */
    }
    .product-hero-img {
        width: 100%;
        height: auto; /* Allow natural height */
        max-height: 500px; /* Max height for large images */
        object-fit: contain;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        background-color: #f8fafc; /* Light background for image area */
        padding: 20px; /* Padding inside image container */
    }
    .img-placeholder {
        height: 400px; /* Adjust placeholder height */
        border-radius: var(--radius);
        border: 1px solid var(--border);
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--text-muted);
    }

    /* Product Info Card */
    .product-info-card .card-body {
        padding: 20px;
    }
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e0f2fe; /* Light blue background */
        color: var(--primary);
        padding: 6px 10px;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
        border: 1px solid #bfdbfe; /* Lighter blue border */
    }
    .mini-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9; /* Light gray background */
        color: var(--text-muted);
        padding: 6px 10px;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 500;
        border: 1px solid #e2e8f0;
        margin-left: 8px; /* Spacing between chips */
    }
    .product-name-h1 {
        font-size: 1.75rem;
        line-height: 1.2;
        color: var(--text-main);
        margin-top: 10px;
        margin-bottom: 15px;
    }
    .price {
        font-size: 1.8rem; /* Larger price */
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 20px;
    }
    .checkout-summary {
        background: #f8fafc; /* Light background for summary */
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 15px;
        margin-bottom: 25px;
    }
    .checkout-summary span {
        color: var(--text-muted);
    }
    .checkout-summary strong {
        color: var(--text-main);
    }
    .description-heading {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 10px;
    }
    .description-heading i {
        color: var(--primary); /* Icon color for description heading */
    }
    .product-description-text {
        color: var(--text-muted);
        line-height: 1.7;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.6rem 1.25rem;
        transition: var(--transition);
    }
    .btn-primary {
        background: var(--primary);
        border: 1px solid var(--primary);
        color: #fff;
    }
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }
    .btn-secondary {
        background: #e2e8f0;
        border: 1px solid #cbd5e1;
        color: var(--text-main);
    }
    .btn-secondary:hover {
        background: #cbd5e1;
        transform: translateY(-1px);
    }
    .btn-outline-danger {
        border: 1px solid #fca5a5;
        color: #ef4444;
        background: #fef2f2;
    }
    .btn-outline-danger:hover {
        background: #ef4444;
        color: #fff;
    }
    .btn-outline-secondary {
        border: 1px solid var(--border);
        color: var(--text-muted);
        background: var(--surface);
    }
    .btn-outline-secondary:hover {
        background: #f8fafc;
        color: var(--text-main);
    }
    .btn-warning {
        background: #fcd34d;
        border: 1px solid #fbbf24;
        color: #78350f;
    }
    .btn-warning:hover {
        background: #fbbf24;
        transform: translateY(-1px);
    }
    .btn-danger {
        background: #ef4444;
        border: 1px solid #dc2626;
        color: #fff;
    }
    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* Feature Strip */
    .feature-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 40px;
        margin-bottom: 40px;
    }
    .feature-pill {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }
    .feature-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .feature-pill i {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .feature-pill span {
        font-weight: 600;
        color: var(--text-main);
        line-height: 1.3;
    }
    .feature-pill small {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 400;
    }

    /* Reviews Section */
    .rating-stars {
        color: #fbbf24; /* Warning color for stars */
        letter-spacing: 1px;
    }
    .progress-line {
        height: 8px;
        background: #e2e8f0; /* Light gray background for progress bar */
        border-radius: 999px;
        overflow: hidden;
    }
    .progress-line span {
        display: block;
        height: 100%;
        background: var(--primary); /* Primary color for progress fill */
        border-radius: inherit;
    }
    .float-group {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .float-group .form-control {
        padding-top: 1.5rem;
        padding-bottom: 0.75rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: var(--surface);
        color: var(--text-main);
    }
    .float-group .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.25);
    }
    .float-group label {
        position: absolute;
        top: 0.75rem;
        left: 1rem;
        color: var(--text-muted);
        pointer-events: none;
        transition: all 0.2s ease-out;
        font-size: 1rem;
    }
    .float-group .form-control:focus + label,
    .float-group .form-control:not(:placeholder-shown) + label {
        top: 0.25rem;
        left: 0.75rem;
        font-size: 0.75rem;
        color: var(--primary);
    }
    textarea.form-control {
        min-height: 100px; /* Ensure textarea has enough height */
    }
    .form-row .mb-3 {
        margin-bottom: 1rem !important;
    }
    .form-group label {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }
    .form-group label i {
        color: var(--primary);
    }

    /* Related Products */
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
    .related-grid .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
    }
    .related-grid .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .related-grid .product-card .img-wrapper { /* Re-using img-wrapper for simplicity, but could be product-media */
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background-color: #f8fafc;
        border-bottom: 1px solid var(--border);
    }
    .related-grid .product-card .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 15px;
    }
    .related-grid .product-card .img-placeholder {
        height: 100%;
        font-size: 2rem;
        color: var(--text-muted);
    }
    .related-grid .product-card .product-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 10;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        background: var(--primary);
        color: #fff;
    }
    .related-grid .product-card .card-body {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .related-grid .product-card .category-badge {
        margin-bottom: 8px;
    }
    .related-grid .product-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-main);
        line-height: 1.3;
        margin-bottom: 10px;
    }
    .related-grid .product-card .price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-top: auto;
        margin-bottom: 15px;
    }
    .related-grid .product-card .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }
    .related-grid .product-card .btn-cart {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .related-grid .product-card .btn-cart:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }
</style>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <span class="hero-chip mb-3"><i class="fas fa-microchip"></i> Product Detail</span>
            <h2><?= e($product['name']) ?></h2>
            <p><?= e($product['category_name'] ?? 'Công nghệ') ?> • Mã sản phẩm #<?= (int) $product['id'] ?></p>
        </div>
        <a href="index.php?url=product" class="btn btn-outline-light mt-2 mt-md-0"><i class="fas fa-arrow-left mr-1"></i> Quay lại</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card product-image-card animate-in h-100">
            <div class="card-body position-relative">
                <?php $heroTag = getProductTag($product); ?>
                <?php if ($heroTag): ?><span class="product-tag" style="color:<?= e($heroTag['color']) ?>;background:<?= e($heroTag['bg']) ?>;z-index:10;"><?= e($heroTag['label']) ?></span><?php endif; ?>
                <?php if ($imgSrc): ?>
                    <img src="uploads/product-placeholder.svg" data-src="<?= e($imgSrc) ?>" alt="<?= e($product['name']) ?>" class="product-hero-img img-lazy" loading="lazy">
                <?php else: ?>
                    <div class="img-placeholder" style="height:400px;"><i class="fas fa-camera"></i></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card product-info-card animate-in h-100" style="animation-delay:.08s;">
            <div class="card-body d-flex flex-column">
                <div class="mb-3">
                    <span class="category-badge"><i class="fas fa-layer-group"></i><?= e($product['category_name'] ?? 'Chưa phân loại') ?></span>
                    <span class="mini-chip"><i class="fas fa-shield-alt"></i>Bảo hành chính hãng</span>
                    <span class="mini-chip"><i class="fas fa-truck"></i>Giao nhanh</span>
                </div>

                <h1 class="product-name-h1"><?= e($product['name']) ?></h1>
                <div class="price"><?= moneyVnd($product['price']) ?></div>

                <div class="checkout-summary mb-4">
                    <div class="d-flex justify-content-between mb-2"><span style="color:var(--text-secondary);">Trả góp 0%</span><strong>Có hỗ trợ</strong></div>
                    <div class="d-flex justify-content-between mb-2"><span style="color:var(--text-secondary);">Đổi trả</span><strong>7 ngày</strong></div>
                    <div class="d-flex justify-content-between"><span style="color:var(--text-secondary);">Tình trạng</span><strong style="color:var(--accent);">Sẵn hàng</strong></div>
                </div>

                <div class="mb-4">
                    <h5 class="description-heading"><i class="fas fa-align-left mr-2"></i>Mô tả</h5>
                    <p class="product-description-text">
                        <?= !empty($product['description']) ? nl2br(e($product['description'])) : '<em style="color:var(--text-muted);">Trải nghiệm công nghệ đỉnh cao tại KZANN.</em>' ?>
                    </p>
                </div>

                <form action="index.php?url=cart/add/<?= (int) $product['id'] ?>" method="POST" class="mt-auto" id="detailCartForm">
                    <?= csrf_input() ?>
                    <div class="form-row align-items-end mb-3">
                        <div class="col-sm-4">
                            <label>Số lượng</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="99">
                        </div>
                        <div class="col-sm-8 mt-3 mt-sm-0 d-flex align-items-end">
                            <button type="submit" class="btn btn-cart btn-block" style="padding:12px 28px;"><i class="fas fa-cart-plus mr-2"></i>Thêm vào giỏ</button>
                        </div>
                    </div>
                    <button type="submit" formaction="index.php?url=cart/buyNow/<?= (int) $product['id'] ?>" class="btn btn-primary btn-block mb-3" style="padding:13px 28px;"><i class="fas fa-bolt mr-2"></i>Mua ngay / Thanh toán</button>
                </form>

                <div class="d-flex flex-wrap" style="gap:8px;">
                    <a href="index.php?url=wishlist/add/<?= (int) $product['id'] ?>" class="btn btn-outline-danger"><i class="fas fa-heart mr-1"></i>Yêu thích</a>
                    <a href="index.php?url=compare/add/<?= (int) $product['id'] ?>" class="btn btn-outline-secondary"><i class="fas fa-balance-scale mr-1"></i>So sánh</a>
                    <?php if (isAdminLoggedIn()): /* Admin actions */ ?>
                    <a href="index.php?url=product/edit/<?= (int) $product['id'] ?>" class="btn btn-warning"><i class="fas fa-pen mr-1"></i>Sửa</a>
                    <form method="POST" action="index.php?url=product/delete/<?= (int) $product['id'] ?>" class="d-inline m-0">
                        <?= csrf_input() ?>
                        <button type="submit" class="btn btn-danger" onclick="event.preventDefault(); showConfirm('Xác nhận xóa', 'Hành động này không thể hoàn tác.', () => this.form.submit());"><i class="fas fa-trash-alt mr-1"></i>Xóa</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="feature-strip">
    <div class="feature-pill"><i class="fas fa-shipping-fast"></i><span>Giao nhanh 2H<small>Nội thành hỗ trợ siêu tốc</small></span></div>
    <div class="feature-pill"><i class="fas fa-medal"></i><span>Hàng chính hãng<small>Cam kết nguồn gốc rõ ràng</small></span></div>
    <div class="feature-pill"><i class="fas fa-sync-alt"></i><span>Đổi trả 7 ngày<small>Hỗ trợ lỗi kỹ thuật</small></span></div>
    <div class="feature-pill"><i class="fas fa-tools"></i><span>Bảo hành tận tâm<small>Đội kỹ thuật chuyên nghiệp</small></span></div>
</div>


<section id="reviews" class="mb-4">
  <div class="card animate-in mb-4">
    <div class="card-header"><i class="fas fa-star mr-2" style="color:var(--warning);"></i>Đánh giá sản phẩm</div>
    <div class="card-body">
      <div class="d-flex align-items-center flex-wrap" style="gap:24px;">
        <div class="text-center"><div style="font-size:3rem;font-weight:900;color:var(--warning);"><?= number_format($reviewStats['avg'] ?? 0,1) ?></div><div><?= renderStars($reviewStats['avg'] ?? 0) ?></div><small style="color:var(--muted);"><?= (int)($reviewStats['count'] ?? 0) ?> đánh giá</small></div>
        <div style="flex:1;min-width:220px;">
          <?php for($s=5;$s>=1;$s--): $cnt=(int)($reviewStats['dist'][$s]??0); $pct=($reviewStats['count']??0)>0?round($cnt/($reviewStats['count'])*100):0; ?>
          <div class="d-flex align-items-center mb-1" style="gap:8px;"><span style="width:14px;font-size:.78rem;"><?=$s?></span><i class="fas fa-star" style="color:var(--warning);font-size:.72rem;"></i><div class="progress-line" style="flex:1;height:8px;"><span style="width:<?= $pct ?>%;"></span></div><span style="font-size:.78rem;color:var(--muted);width:20px;"><?= $cnt ?></span></div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="card animate-in mb-4">
    <div class="card-header"><i class="fas fa-pen-nib mr-2" style="color:var(--accent);"></i>Gửi đánh giá của bạn</div>
    <div class="card-body">
      <form method="POST" action="index.php?url=review/store/<?= (int)$product['id'] ?>" class="mb-4">
        <?= csrf_input() ?>
        <div class="form-row"><div class="col-md-5"><div class="float-group"><input class="form-control" name="reviewer_name" placeholder=" " required><label>Tên của bạn *</label></div></div><div class="col-md-7"><div class="mb-3" style="font-weight:800;">Chọn sao: <?php for($i=5;$i>=1;$i--): ?><label class="mr-2"><input type="radio" name="rating" value="<?=$i?>" <?= $i==5?'checked':'' ?>> <?=$i?>★</label><?php endfor; ?></div></div></div>
        <div class="float-group"><textarea class="form-control" name="comment" rows="4" maxlength="500" placeholder=" "></textarea><label>Bình luận</label></div>
        <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane mr-1"></i>Gửi đánh giá</button>
      </form>
      <hr style="border-color:var(--line);">
      <?php if (empty($reviews)): ?><p class="mb-0" style="color:var(--muted);">Chưa có đánh giá nào.</p><?php else: ?><?php foreach($reviews as $rv): ?><div class="mb-3 pb-3" style="border-bottom:1px solid var(--line);"><strong><?= e($rv['reviewer_name']) ?></strong> <span><?= renderStars($rv['rating']) ?></span><br><small style="color:var(--muted);"><?= e($rv['created_at']) ?></small><p class="mb-0 mt-2"><?= nl2br(e($rv['comment'])) ?></p></div><?php endforeach; ?><?php endif; ?>
    </div>
  </div>
</section>

<?php if (!empty($relatedProducts)): ?>
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <div>
            <span class="mini-chip"><i class="fas fa-magic"></i> Gợi ý thông minh</span>
            <h3 class="font-display mt-2 mb-0">Sản phẩm liên quan</h3>
        </div>
        <a href="index.php?url=product" class="btn btn-secondary mt-2 mt-md-0"><i class="fas fa-th-large mr-1"></i>Xem tất cả</a>
    </div>
    <div class="related-grid">
        <?php foreach ($relatedProducts as $rel): ?>
            <?php $relImg = getImageSrc($rel['image'], $rel['name'], $rel['category_id'] ?? null); ?>
            <div class="product-card related-product-card animate-in">
                <?php $relTag = getProductTag($rel); ?>
                <div class="img-wrapper"> <!-- Re-using img-wrapper for simplicity -->
                    <?php if ($relTag): ?><span class="product-tag" style="color:<?= e($relTag['color']) ?>;background:<?= e($relTag['bg']) ?>;"><?= e($relTag['label']) ?></span><?php endif; ?>
                    <?php if ($relImg): ?><img src="<?= e($relImg) ?>" class="card-img-top" alt="<?= e($rel['name']) ?>" loading="lazy"><?php else: ?><div class="img-placeholder"><i class="fas fa-camera"></i></div><?php endif; ?>
                </div>
                <div class="card-body d-flex flex-column">
                    <span class="category-badge"><i class="fas fa-microchip"></i><?= e($rel['category_name'] ?? 'Công nghệ') ?></span>
                    <h5 class="card-title" style="font-size:1.1rem;font-weight:600;"><?= e($rel['name']) ?></h5>
                    <div class="price mt-2 mb-3"><?= moneyVnd($rel['price']) ?></div>
                    <div class="d-flex flex-wrap mt-auto" style="gap:6px;">
                        <a href="index.php?url=product/show/<?= (int) $rel['id'] ?>" class="btn btn-secondary btn-sm flex-fill"><i class="fas fa-eye mr-1"></i>Chi tiết</a>
                        <a href="index.php?url=cart/add/<?= (int) $rel['id'] ?>" class="btn btn-cart btn-sm"><i class="fas fa-cart-plus"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include BASE_PATH . '/app/views/shares/footer.php'; ?>
