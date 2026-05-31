<?php include 'app/views/shares/header.php'; ?>

</div>
</div>

<div class="hero-banner">
    <div class="hero-content">
        <h1>KhanhzannShop - Mua sắm tiện lợi, phong cách hiện đại</h1>
        <p>Những sản phẩm công nghệ mới nhất được chọn lọc kỹ càng, giá tốt và giao hàng nhanh.</p>
        <a href="/Product/add" class="btn btn-hero">Đăng sản phẩm mới</a>
    </div>
</div>

<?php if (SessionHelper::isAdmin()) : ?>
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h5 class="card-title">Quản lý đơn hàng</h5>
                        <p class="card-text">Xem và cập nhật trạng thái đơn hàng ngay từ trang chủ.</p>
                        <a href="/Product/orders" class="btn btn-primary">Quản lý đơn hàng</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h5 class="card-title">Quản lý danh mục</h5>
                        <p class="card-text">Tạo, sửa, xoá danh mục sản phẩm cho cửa hàng.</p>
                        <a href="/Category" class="btn btn-success">Quản lý danh mục</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<form class="mb-4" method="get" action="/Product">
    <div class="input-group" style="max-width:760px; margin:0 auto;">
        <input type="text" name="search" class="form-control" placeholder="Tìm sản phẩm theo tên hoặc mô tả"
               value="<?php echo isset($searchQuery) ? htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8') : ''; ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </div>
</form>

<div class="container">
<div class="main-box">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <div>
        <h1 style="font-weight:700">✨ Xu hướng hôm nay</h1>
        <p class="text-muted">Bộ sưu tập công nghệ và phụ kiện hiện đại</p>
    </div>
    <a href="/Product/add" class="btn btn-success">+ Thêm sản phẩm</a>
</div>

<div class="row">
<?php foreach ($products as $product): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <?php if (!empty($product->image)): ?>
                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                style="height:240px;object-fit:cover;">
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center" style="height:240px;background:#f1f5f9">
                    <h2>📦</h2>
                </div>
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
                <span class="badge badge-info mb-3"><?php echo htmlspecialchars($product->category_name ?? 'Danh mục', ENT_QUOTES, 'UTF-8'); ?></span>

                <h4 style="font-weight:700">
                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                </h4>

                <p class="text-muted" style="flex-grow:1">
                    <?php echo htmlspecialchars(mb_substr($product->description, 0, 90), ENT_QUOTES, 'UTF-8'); ?>...
                </p>

                <div class="price-tag mb-3">
                    <?php echo number_format($product->price, 0, ',', '.'); ?>đ
                </div>

                <div class="d-flex flex-wrap" style="gap:10px; align-items:flex-end;">
                    <form method="post" action="/Product/addToCart/<?php echo $product->id; ?>" class="d-flex" style="gap:10px; align-items:center; width:100%; max-width:260px;">
                        <input type="number" name="quantity" value="1" min="1" class="form-control form-control-sm" style="width:90px;">
                        <button type="submit" class="btn btn-primary flex-fill">Thêm vào giỏ hàng</button>
                    </form>
                    <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">Sửa</a>
                    <a href="/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger" onclick="return confirm('Xóa sản phẩm?')">X</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
