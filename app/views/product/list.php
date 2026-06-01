<?php include 'app/views/shares/header.php'; ?>

<!-- Image Carousel Banner -->
<style>
    .carousel-container {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        background: #000;
    }

    .carousel-slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .carousel-slide.active {
        opacity: 1;
    }

    .carousel-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }

    .carousel-content {
        text-align: center;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.8s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .carousel-content h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .carousel-content p {
        font-size: 20px;
        margin-bottom: 20px;
        font-weight: 300;
    }

    .carousel-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .carousel-btn {
        padding: 12px 30px;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .carousel-btn-primary {
        background: #ff6b6b;
        color: white;
    }

    .carousel-btn-primary:hover {
        background: #ff5252;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
    }

    .carousel-btn-secondary {
        background: rgba(255, 255, 255, 0.9);
        color: #333;
    }

    .carousel-btn-secondary:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .carousel-dots {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 20;
    }

    .carousel-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.7);
    }

    .carousel-dot.active {
        background: white;
        width: 30px;
        border-radius: 6px;
    }

    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.3);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        border-radius: 50%;
        transition: all 0.3s ease;
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-arrow:hover {
        background: rgba(255, 255, 255, 0.6);
        transform: translateY(-50%) scale(1.1);
    }

    .carousel-arrow.prev {
        left: 30px;
    }

    .carousel-arrow.next {
        right: 30px;
    }
</style>

<div class="carousel-container">
    <!-- Slide 1: Technology -->
    <div class="carousel-slide active" style="background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h1>🚀 Công nghệ tân tiến</h1>
                <p>Khám phá những sản phẩm công nghệ mới nhất</p>
                <div class="carousel-buttons">
                    <a href="#products" class="carousel-btn carousel-btn-primary">Khám phá ngay</a>
                    <a href="/Product" class="carousel-btn carousel-btn-secondary">Xem tất cả</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 2: Shopping -->
    <div class="carousel-slide" style="background-image: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h1>🛍️ Mua sắm thông minh</h1>
                <p>Giá tốt nhất, giao hàng nhanh chóng</p>
                <div class="carousel-buttons">
                    <a href="/Product" class="carousel-btn carousel-btn-primary">Bắt đầu mua sắm</a>
                    <a href="/account/login" class="carousel-btn carousel-btn-secondary">Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 3: Deals -->
    <div class="carousel-slide" style="background-image: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h1>💰 Ưu đãi hấp dẫn</h1>
                <p>Giảm giá lên đến 50% cho sản phẩm chọn lọc</p>
                <div class="carousel-buttons">
                    <a href="#products" class="carousel-btn carousel-btn-primary">Xem khuyến mãi</a>
                    <a href="/account/register" class="carousel-btn carousel-btn-secondary">Đăng ký tài khoản</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 4: Quality -->
    <div class="carousel-slide" style="background-image: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <div class="carousel-overlay">
            <div class="carousel-content">
                <h1>⭐ Chất lượng đảm bảo</h1>
                <p>Sản phẩm chính hãng, bảo hành đầy đủ</p>
                <div class="carousel-buttons">
                    <a href="#products" class="carousel-btn carousel-btn-primary">Xem sản phẩm</a>
                    <a href="/account/login" class="carousel-btn carousel-btn-secondary">Liên hệ hỗ trợ</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Arrows -->
    <button class="carousel-arrow prev" onclick="changeSlide(-1)">❮</button>
    <button class="carousel-arrow next" onclick="changeSlide(1)">❯</button>

    <!-- Dots -->
    <div class="carousel-dots">
        <div class="carousel-dot active" onclick="goToSlide(0)"></div>
        <div class="carousel-dot" onclick="goToSlide(1)"></div>
        <div class="carousel-dot" onclick="goToSlide(2)"></div>
        <div class="carousel-dot" onclick="goToSlide(3)"></div>
    </div>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const totalSlides = slides.length;

    function showSlide(n) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        slides[n].classList.add('active');
        dots[n].classList.add('active');
    }

    function changeSlide(n) {
        currentSlide = (currentSlide + n + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    function goToSlide(n) {
        currentSlide = n;
        showSlide(currentSlide);
    }

    // Auto-slide every 5 seconds
    setInterval(() => {
        changeSlide(1);
    }, 5000);
</script>

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
    <?php if (SessionHelper::isAdmin()) : ?>
        <a href="/Product/add" class="btn btn-success">+ Thêm sản phẩm</a>
    <?php endif; ?>
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
                    <?php if (SessionHelper::isAdmin()) : ?>
                        <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">Sửa</a>
                        <a href="/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger" onclick="return confirm('Xóa sản phẩm?')">X</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
