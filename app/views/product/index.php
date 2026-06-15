<?php
$seoTitle = 'Sản phẩm công nghệ — KZANN';
$seoDescription = 'Khám phá catalogue sản phẩm công nghệ chính hãng tại KZANN.';
?>
<?php include BASE_PATH . '/app/views/shares/header.php'; ?>

<?php
$baseParams = [
    'url' => 'product',
    'q' => $keyword,
    'category_id' => $categoryId > 0 ? $categoryId : '',
    'sort' => $sort !== 'newest' ? $sort : '',
    'min_price' => $minPrice !== null ? $minPrice : '',
    'max_price' => $maxPrice !== null ? $maxPrice : '',
];
$buildProductUrl = function ($overrides = []) use ($baseParams) {
    $params = array_merge($baseParams, $overrides);
    foreach ($params as $k => $v) {
        if ($v === '' || $v === null) unset($params[$k]);
    }
    return 'index.php?' . http_build_query($params);
};
?>

<style>
    .storefront-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
    }
    .storefront-hero::before,
    .storefront-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        filter: blur(8px);
        pointer-events: none;
        z-index: 0;
    }
    .storefront-hero::before {
        width: 360px;
        height: 360px;
        right: -110px;
        top: -130px;
        background: radial-gradient(circle, rgba(0,245,200,.28), transparent 62%);
        animation: productAuroraA 8s ease-in-out infinite alternate;
    }
    .storefront-hero::after {
        width: 280px;
        height: 280px;
        left: 16%;
        bottom: -160px;
        background: radial-gradient(circle, rgba(124,60,255,.30), transparent 64%);
        animation: productAuroraB 10s ease-in-out infinite alternate;
    }
    .storefront-hero > * { position: relative; z-index: 1; }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
        color: var(--primary); /* Icon color for hero chips */
    }
    .hero-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .page-header .hero-chip.mb-3 { /* Specific style for the main "Premium Selection" chip */
        background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 4px 12px rgba(215,0,24,0.2); }
    .page-header .hero-chip.mb-3 i { color: #fff; }

    .luxury-filter-card {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 20px;
    }
    .luxury-filter-card label {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--text-main);
        margin-bottom: 5px;
    }
    .filter-summary strong { color: var(--heading-color); font-family: var(--font-mono); }

    .product-grid-luxury {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); /* Thẻ nhỏ hơn, gọn hơn */
        gap: 15px;
        align-items: stretch;
    }
    .product-tile { min-width: 0; }
    .product-card.luxury-product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: #ffffff;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        will-change: transform;
        box-shadow: none;
    }
    .product-card.luxury-product-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }

    .product-media {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden; 
        border-radius: 0;
        margin: 0;
        background: #ffffff;
        border-bottom: 1px solid var(--border);
    }
    .product-media .card-img-top,
    .product-media .img-placeholder {
        width: 100%;
        height: 100% !important;
        object-fit: contain;
        padding: 15px;
        filter: drop-shadow(0 5px 10px rgba(0,0,0,0.08));
        transition: var(--transition);
    }
    .product-card:hover .product-media .card-img-top { transform: scale(1.05); }
    .product-badge-stack {
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 4;
        display: flex;
        flex-direction: column;
        gap: 7px;
    }
    .product-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: max-content;
        padding: 7px 10px;
        border-radius: 999px;
        font-family: var(--font-mono);
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .08em;
        color: #fff;
        border: 1px solid rgba(255,255,255,.28);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .product-status-badge.hot { background: linear-gradient(135deg, #fbbf24, #fb7185); box-shadow: var(--color-warning-glow); }
    .product-status-badge.new { background: linear-gradient(135deg, #00f5c8, #22d3ee); box-shadow: var(--color-success-glow); }
    .product-status-badge.sale { background: linear-gradient(135deg, #ff3b6b, #7c3cff); color: #fff; }

    .quick-info-strip {
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 12px;
        z-index: 4;
        transform: translateY(125%);
        opacity: 0;
        transition: .26s cubic-bezier(.2,.8,.2,1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        color: var(--text-main);
        background: var(--surface);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        font-size: .8rem;
        font-weight: 800;
    }
    .product-card:hover .quick-info-strip { transform: translateY(0); opacity: 1; }
    .rating-stars { color: #fbbf24; letter-spacing: 1px; white-space: nowrap; }

    .product-overlay-actions {
        position: absolute;
        right: 14px;
        top: 14px;
        z-index: 5;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transform: translateX(8px);
        transition: .22s ease;
    }
    .product-card:hover .product-overlay-actions { opacity: 1; transform: translateX(0); }
    .product-overlay-actions .btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 8px;
    }

    .product-card .card-body {
        position: relative;
        z-index: 3;
        padding: 24px;
        transform: translateZ(28px);
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .product-kicker {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        min-height: 28px;
        margin-bottom: 11px;
    }
    .category-badge.luxury-category {
        max-width: 75%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border: 1px solid var(--border);
        background: #f0f9ff; /* Light blue background */
        color: #0284c7; /* Blue text */
    }
    .product-chip-mini {
        color: var(--muted);
        font-size: .72rem;
        white-space: nowrap;
    }
    .product-card .card-title {
        font-size: 1rem;
        min-height: 2.25em;
        margin: 0;
        color: var(--heading-color);
        line-height: 1.4;
    }
    .product-desc-line {
        color: var(--text-muted);
        font-size: .84rem;
        line-height: 1.5;
        margin: 10px 0 15px;
    }
    .price.price-luxury {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 20px;
        margin-top: auto;
    }
    .product-primary-actions { 
        display: grid; 
        grid-template-columns: 1fr auto; 
        gap: 10px;
    }
    .product-action-icons {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--border);
    }
    .product-action-icons .btn {
        flex: 1;
        height: 38px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 0.85rem;
        background: #f8fafc;
        border: 1px solid var(--border);
        color: var(--text-muted);
    }
    .product-action-icons .btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .product-admin-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 12px; }

    @media (max-width: 575px) {
        .product-grid-luxury { grid-template-columns: 1fr; gap: 16px; }
        .product-primary-actions { grid-template-columns: 1fr 42px 42px 42px; }
        .quick-info-strip { transform: translateY(0); opacity: 1; }
        .product-overlay-actions { opacity: 1; transform: none; }
    }
    @media (prefers-reduced-motion: reduce) {
        .product-card.luxury-product-card { transform: none !important; transition: none !important; }
        .storefront-hero::before, .storefront-hero::after { animation: none !important; }
    }

    .product-grid-luxury.product-list-mode{grid-template-columns:1fr}.product-list-mode .luxury-product-card{display:grid;grid-template-columns:minmax(180px,260px) 1fr}.product-list-mode .product-media{height:100%;min-height:180px}.product-list-mode .card-body{padding:22px}@media(max-width:576px){.product-list-mode .luxury-product-card{display:block}}
</style>

<div class="page-header storefront-hero">
    <?= breadcrumb([['label'=>'Sản phẩm']]) ?>
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <span class="hero-chip mb-3"><i class="fas fa-gem"></i> Premium Selection</span>
            <h2>KZANN Product Gallery</h2>
            <p class="mb-0"></p>
            <?php if ($categoryId > 0 && !empty($currentCategoryName)): ?><p class="mb-0 mt-2">Đang xem: <strong style="color:var(--accent);"><?= e($currentCategoryName) ?></strong> — <a href="index.php?url=product" style="color:var(--muted);">Xóa lọc</a></p><?php endif; ?>
            <div class="hero-chips">
                <span class="hero-chip"><i class="fas fa-shipping-fast"></i> Giao nhanh</span>
                <span class="hero-chip"><i class="fas fa-shield-alt"></i> Bảo hành chính hãng</span>
                <span class="hero-chip"><i class="fas fa-heart"></i> Wishlist</span>
                <span class="hero-chip"><i class="fas fa-balance-scale"></i> So sánh</span>
            </div>
        </div>
        <?php if (isAdminLoggedIn()): ?><a href="index.php?url=product/create" class="btn btn-outline-light mt-2 mt-md-0"><i class="fas fa-plus mr-1"></i> Thêm sản phẩm</a><?php endif; ?>
    </div>
</div>

<div class="card animate-in mb-4">
    <div class="card-body">
        <div class="feature-strip">
            <div class="feature-pill"><i class="fas fa-bolt"></i><span>Mua nhanh<small>Thanh toán siêu tốc</small></span></div>
            <div class="feature-pill"><i class="fas fa-shield-alt"></i><span>Bảo hành chính hãng<small>An tâm sử dụng</small></span></div>
            <div class="feature-pill"><i class="fas fa-heart"></i><span>Wishlist<small>Lưu sản phẩm yêu thích</small></span></div>
            <div class="feature-pill"><i class="fas fa-balance-scale"></i><span>So sánh<small>Chọn sản phẩm tốt nhất</small></span></div>
        </div>
    </div>
</div>
<div class="stats-grid mb-4">
    <div class="stat-card animate-in"><div class="stat-icon"><i class="fas fa-box"></i></div><div class="stat-content"><h6>Tổng sản phẩm</h6><div class="stat-value"><?= number_format((int) ($productStats['total_products'] ?? 0)) ?></div></div></div>
    <div class="stat-card animate-in"><div class="stat-icon" style="background:var(--gradient-accent);"><i class="fas fa-sitemap"></i></div><div class="stat-content"><h6>Danh mục dùng</h6><div class="stat-value"><?= number_format((int) ($productStats['used_categories'] ?? 0)) ?></div></div></div>
    <div class="stat-card animate-in"><div class="stat-icon" style="background:var(--gradient-warm);"><i class="fas fa-tags"></i></div><div class="stat-content"><h6>Giá trung bình</h6><div class="stat-value"><?= moneyVnd($productStats['avg_price'] ?? 0) ?></div></div></div>
    <div class="stat-card animate-in"><div class="stat-icon" style="background:var(--gradient-rose);"><i class="fas fa-filter"></i></div><div class="stat-content"><h6>Filter đang bật</h6><div class="stat-value"><?= (int) $activeFilterCount ?></div></div></div>
</div>

<div class="card luxury-filter-card animate-in mb-4">
    <div class="card-body">
        <form method="GET" action="index.php" class="filter-panel">
            <input type="hidden" name="url" value="product">
            <div class="form-row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="q"><i class="fas fa-search mr-1"></i>Tìm kiếm</label>
                    <input type="text" id="q" name="q" value="<?= e($keyword) ?>" class="form-control" placeholder="Tên sản phẩm, mô tả...">
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="category_id"><i class="fas fa-layer-group mr-1"></i>Danh mục</label>
                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">Tất cả</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= (int) $cat['id'] ?>" <?= $categoryId == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="min_price">Giá từ</label>
                    <input type="number" id="min_price" name="min_price" min="0" class="form-control" value="<?= $minPrice !== null ? e($minPrice) : '' ?>" placeholder="0">
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="max_price">Đến giá</label>
                    <input type="number" id="max_price" name="max_price" min="0" class="form-control" value="<?= $maxPrice !== null ? e($maxPrice) : '' ?>" placeholder="<?= number_format((float) ($priceBounds['max_price'] ?? 0), 0, '', '') ?>">
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="sort"><i class="fas fa-sort mr-1"></i>Sắp xếp</label>
                    <select id="sort" name="sort" class="form-control">
                        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                        <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                        <option value="name_desc" <?= $sort === 'name_desc' ? 'selected' : '' ?>>Tên Z-A</option>
                    </select>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap:10px;">
                <div class="filter-summary" style="color:var(--text-muted);font-size:0.9rem;">
                    Hiển thị <strong><?= count($products) ?></strong> / <strong><?= number_format($totalProducts) ?></strong> sản phẩm
                    <?php if ($activeFilterCount > 0): ?><span class="ml-2 mini-chip"><i class="fas fa-sliders-h"></i><?= (int) $activeFilterCount ?> bộ lọc</span><?php endif; ?>
                </div>
                <div class="d-flex align-items-center" style="gap:6px;">
                    <button type="button" class="btn btn-sm btn-secondary" id="viewGrid" title="Lưới"><i class="fas fa-th-large"></i></button>
                    <button type="button" class="btn btn-sm btn-secondary" id="viewList" title="Danh sách"><i class="fas fa-list"></i></button>
                </div>
                <div class="d-flex flex-wrap" style="gap:8px;">
                    <a href="index.php?url=product" class="btn btn-outline-secondary"><i class="fas fa-undo mr-1"></i> Reset</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search mr-1"></i> Áp dụng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (empty($products)): ?>
    <div class="empty-state">
        <i class="fas fa-search"></i>
        <h4>Không tìm thấy sản phẩm phù hợp</h4>
        <p>Thử nới rộng bộ lọc hoặc xóa từ khóa tìm kiếm để xem thêm kết quả.</p>
        <a href="index.php?url=product" class="btn btn-primary mt-3"><i class="fas fa-list mr-1"></i> Xem tất cả sản phẩm</a>
    </div>
<?php else: ?>
    <div id="productContainer" class="product-grid-luxury">
        <?php foreach ($products as $index => $product): ?>
            <?php
                $imgSrc = getImageSrc($product['image'], $product['name'], $product['category_id'] ?? null);
                $description = trim(strip_tags($product['description'] ?? ''));
                $tag = getProductTag($product);
                $badgeType = $index % 3 === 0 ? 'hot' : ($index % 3 === 1 ? 'new' : 'sale');
                $badgeLabel = $badgeType === 'hot' ? 'HOT' : ($badgeType === 'new' ? 'NEW' : 'SALE');
                $rating = 4 + (($index % 2) * 0.5);
            ?>
            <div class="product-tile animate-in" style="animation-delay: <?= $index * 0.05 ?>s">
                <article class="product-card luxury-product-card h-100" data-tilt-card>
                    <div class="product-media">
                        <div class="product-badge-stack">
                            <?php if ($tag): ?><span class="product-tag" style="color:<?= e($tag['color']) ?>;background:<?= e($tag['bg']) ?>;"><?= e($tag['label']) ?></span><?php else: ?><span class="product-status-badge <?= $badgeType ?>"><i class="fas fa-bolt"></i><?= $badgeLabel ?></span><?php endif; ?>
                        </div>
                        <div class="product-overlay-actions">
                            <button type="button" class="btn btn-outline-light btn-sm" data-quick-view title="Xem nhanh"
                                data-id="<?= (int) $product['id'] ?>"
                                data-name="<?= e($product['name']) ?>"
                                data-price="<?= e(moneyVnd($product['price'])) ?>"
                                data-category="<?= e($product['category_name'] ?? 'Công nghệ') ?>"
                                data-image="<?= e($imgSrc) ?>"
                                data-description="<?= e(textExcerpt($description, 220)) ?>">
                                <i class="fas fa-bolt"></i>
                            </button>
                            <a href="index.php?url=cart/add/<?= (int) $product['id'] ?>" class="btn btn-success btn-sm js-add-cart" title="Mua nhanh"><i class="fas fa-cart-plus"></i></a>
                        </div>
                        <?php if ($imgSrc): ?>
                            <img src="uploads/product-placeholder.svg" data-src="<?= e($imgSrc) ?>" class="card-img-top img-lazy" alt="<?= e($product['name']) ?>" loading="lazy" decoding="async">
                        <?php else: ?>
                            <div class="img-placeholder"><i class="fas fa-camera"></i></div>
                        <?php endif; ?>
                        <div class="quick-info-strip">
                            <span><i class="fas fa-check-circle mr-1" style="color:var(--accent);"></i>Còn hàng</span>
                            <span class="rating-stars" aria-label="Đánh giá <?= $rating ?>/5">★★★★★</span>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="product-kicker">
                            <?php if (!empty($product['category_name'])): ?><span class="category-badge luxury-category"><i class="fas fa-microchip"></i><?= e($product['category_name']) ?></span><?php endif; ?>
                            <span class="product-chip-mini">ID #<?= (int) $product['id'] ?></span>
                        </div>
                        <h5 class="card-title"><?= e($product['name']) ?></h5>
                        <p class="product-desc-line"><?= e(textExcerpt($description ?: 'Trải nghiệm công nghệ đỉnh cao cùng sản phẩm chính hãng tại KZANN.', 60)) ?></p>
                        <div class="price price-luxury"><?= moneyVnd($product['price']) ?></div>
                        <div class="product-primary-actions">
                            <a href="index.php?url=cart/add/<?= (int) $product['id'] ?>" class="btn btn-primary btn-block js-add-cart"><i class="fas fa-cart-plus mr-2"></i>Thêm vào giỏ</a>
                        </div>
                        <div class="product-action-icons">
                            <a href="index.php?url=product/show/<?= (int) $product['id'] ?>" class="btn" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                            <a href="index.php?url=wishlist/add/<?= (int) $product['id'] ?>" class="btn" title="Yêu thích"><i class="fas fa-heart"></i></a>
                            <a href="index.php?url=compare/add/<?= (int) $product['id'] ?>" class="btn" title="So sánh"><i class="fas fa-balance-scale"></i></a>
                        </div>
                        <?php if (isAdminLoggedIn()): ?>
                        <div class="product-admin-actions">
                            <a href="index.php?url=product/edit/<?= (int) $product['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-pen mr-1"></i>Sửa</a>
                            <form method="POST" action="index.php?url=product/delete/<?= (int) $product['id'] ?>" class="m-0">
                                <?= csrf_input() ?>
                                <button type="submit" class="btn btn-danger btn-sm btn-block" onclick="event.preventDefault(); showConfirm('Xác nhận xóa', 'Hành động này không thể hoàn tác.', () => this.form.submit());"><i class="fas fa-trash-alt mr-1"></i>Xóa</button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav aria-label="Product pagination" class="mt-4">
            <ul class="pagination justify-content-center modern-pagination">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>"><a class="page-link" href="<?= e($buildProductUrl(['page' => $page - 1])) ?>">&laquo;</a></li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="<?= e($buildProductUrl(['page' => $i])) ?>"><?= $i ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="<?= e($buildProductUrl(['page' => $page + 1])) ?>">&raquo;</a></li>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<script>
(function () {
    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }
    ready(function () {
        var allowMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: no-preference)').matches;

        if (allowMotion) {
            // Removed 3D Tilt effect as per request.
            // document.querySelectorAll('[data-tilt-card]').forEach(function (card) {
            //     card.addEventListener('mousemove', function (event) {
            //         var rect = card.getBoundingClientRect();
            //         var x = event.clientX - rect.left;
            //         var y = event.clientY - rect.top;
            //         var rotateY = ((x / rect.width) - .5) * 9;
            //         var rotateX = -((y / rect.height) - .5) * 9;
            //         card.style.setProperty('--mx', x + 'px');
            //         card.style.setProperty('--my', y + 'px');
            //         card.style.transform = 'rotateX(' + rotateX.toFixed(2) + 'deg) rotateY(' + rotateY.toFixed(2) + 'deg) translateY(-4px)';
            //     });
            //     card.addEventListener('mouseleave', function () {
            //         card.style.transform = '';
            //         card.style.setProperty('--mx', '50%');
            //         card.style.setProperty('--my', '0%');
            //     });
            // });
        }

        document.querySelectorAll('.js-add-cart, .btn-cart').forEach(function (button) {
            button.addEventListener('click', function (event) {
                var rect = button.getBoundingClientRect();
                var ripple = document.createElement('span');
                ripple.className = 'ripple-dot';
                ripple.style.left = (event.clientX - rect.left) + 'px';
                ripple.style.top = (event.clientY - rect.top) + 'px';
                button.appendChild(ripple);
                button.classList.add('is-bouncing');
                setTimeout(function () { ripple.remove(); button.classList.remove('is-bouncing'); }, 640);
            });
        });
    });
})();

        var mode = localStorage.getItem('novatech-view') || 'grid';
        function applyView(m) {
            localStorage.setItem('novatech-view', m);
            var c = document.getElementById('productContainer'); if (!c) return;
            c.classList.toggle('product-list-mode', m === 'list');
            $('#viewGrid').toggleClass('active', m === 'grid');
            $('#viewList').toggleClass('active', m === 'list');
        }
        $('#viewGrid').on('click', function(){ applyView('grid'); });
        $('#viewList').on('click', function(){ applyView('list'); });
        applyView(mode);
</script>

<?php include BASE_PATH . '/app/views/shares/footer.php'; ?>
