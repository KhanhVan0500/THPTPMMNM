<?php
$seoTitle = $seoTitle ?? 'KZANN — Điện thoại chính hãng, giá tốt nhất, dịch vụ tận tâm.';
$seoDescription = $seoDescription ?? 'KZANN chuyên cung cấp điện thoại chính hãng, giá tốt nhất, dịch vụ tận tâm. Phục vụ khách hàng từ 2020.';
$seoImage = $seoImage ?? 'uploads/novatech-logo.svg';
$seoUrl = $seoUrl ?? 'https://kzann.vn/';
$seoRobots = $seoRobots ?? 'index, follow';
?>
<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($seoTitle) ?></title>
    <meta name="description" content="<?= e($seoDescription) ?>">
    <meta name="robots" content="<?= e($seoRobots) ?>">
    <meta property="og:title" content="<?= e($seoTitle) ?>">
    <meta property="og:description" content="<?= e($seoDescription) ?>">
    <meta property="og:image" content="<?= e($seoImage) ?>">
    <meta property="og:url" content="<?= e($seoUrl) ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($seoTitle) ?>">
    <meta name="twitter:description" content="<?= e($seoDescription) ?>">
    <meta name="twitter:image" content="<?= e($seoImage) ?>">
    <link rel="icon" href="uploads/novatech-logo.svg" type="image/svg+xml">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #d70018; /* Màu đỏ thương hiệu retail */
            --primary-dark: #af0013;
            --bg: #f4f6f8; /* Nền xám nhạt để nổi bật khung trắng */
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e5e7eb;
            --radius: 10px;
            --shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --transition: all 0.2s ease;
        }

        * { box-sizing: border-box; }
        
        .container {
            max-width: 1200px !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
        }

        .navbar-custom {
            background: var(--primary) !important; /* Header màu đỏ nổi bật */
            padding: 0.5rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-custom .navbar-brand {
            font-weight: 800;
            color: #ffffff !important;
            letter-spacing: -0.02em;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        .navbar-custom .nav-link:hover, .navbar-custom .nav-link.active {
            color: #ffffff !important;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
        }

        .main-content { padding: 20px 0 40px; flex: 1; }

        .page-header {
            background: #ffffff;
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border);
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }
        .page-header h2 { font-weight: 700; letter-spacing: -0.03em; color: var(--text-main); }
        .page-header p { color: var(--text-muted); font-size: 1rem; }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: var(--shadow);
        }
        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #eff6ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .stat-content h6 { margin: 0; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 600; }
        .stat-value { font-size: 1.25rem; font-weight: 700; color: var(--text-main); }

    .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }
        .card-header { background: #fafafa; border-bottom: 1px solid var(--border); padding: 15px 20px; font-weight: 600; }

        .btn { border-radius: 8px; font-weight: 600; padding: 0.5rem 1.25rem; transition: var(--transition); }
        .btn-primary { background: var(--primary); border: 1px solid var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .btn-outline-light { border: 1px solid var(--border); color: var(--text-main); }
        .btn-outline-light:hover { background: #f8fafc; color: var(--primary); }

        .table thead th { 
            background: #f8fafc; 
            color: var(--text-muted); 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            border-bottom: 1px solid var(--border);
            padding: 15px;
        }
        .table td { padding: 15px; border-top: 1px solid var(--border); }
        .badge-status { border-radius: 6px; padding: 4px 10px; font-size: 0.75rem; font-weight: 600; }
        .status-new { background: #dcfce7; color: #166534; }

        .top-announcement { background: #1e293b; color: #cbd5e1; font-size: 0.8rem; padding: 6px 0; }
        .top-announcement span { margin-right: 20px; }

        .footer { background: #fff; border-top: 1px solid var(--border); padding: 40px 0 20px; color: var(--text-muted); }
        .footer h5 { color: var(--text-main); font-weight: 700; }
    </style>
</head>
<body>

<div class="top-announcement">
    <div class="container">
        <div>
            <span><i class="fas fa-check-circle mr-1"></i> KZANN - Since 2020</span>
            <span><i class="fas fa-truck mr-1"></i> Freeship toàn quốc</span>
        </div>
        <div class="ml-auto"><i class="fas fa-phone-alt mr-1"></i> 0909 999 099</div>
    </div>
</div>

<?php
$seoTitle = $seoTitle ?? 'KZANN — Điện thoại chính hãng, giá tốt nhất, dịch vụ tận tâm.';
$seoDescription = $seoDescription ?? 'KZANN chuyên cung cấp điện thoại chính hãng, giá tốt nhất, dịch vụ tận tâm. Phục vụ khách hàng từ 2020.';
$seoImage = $seoImage ?? 'uploads/novatech-logo.svg';
$seoUrl = $seoUrl ?? 'https://kzann.vn/';
$seoRobots = $seoRobots ?? 'index, follow';
$cartCount = getCartCount();
$wishlistCount = getWishlistCount();
$compareCount = isset($_SESSION['compare']) ? count($_SESSION['compare']) : 0;
$currentUrl = $_GET['url'] ?? 'dashboard';
$currentSection = strtolower(explode('/', $currentUrl)[0]);
?>

<div class="mobile-nav-backdrop" id="mobileNavBackdrop"></div>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom" id="siteNavbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= isAdmin() ? 'index.php?url=dashboard' : 'index.php?url=product' ?>">
            <i class="fas fa-shopping-bag mr-2"></i> KZANN
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="fas fa-bars text-dark"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <form class="nav-search" method="GET" action="index.php" role="search">
                <input type="hidden" name="url" value="product">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0" name="q" placeholder="Tìm kiếm..." value="<?= e($_GET['q'] ?? '') ?>">
                    <div class="input-group-append"><button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button></div>
                </div>
            </form>
            <ul class="navbar-nav ml-auto align-items-lg-center">
                <?php if (isAdmin()): ?>
                <li class="nav-item"><a class="nav-link" href="index.php?url=dashboard">Dashboard</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="index.php?url=product">Cửa hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?url=order">Đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link count-link <?= $currentSection === 'wishlist' ? 'active' : '' ?>" href="index.php?url=wishlist"><i class="fas fa-heart mr-1"></i>Yêu thích<?php if ($wishlistCount > 0): ?><span class="nav-count"><?= $wishlistCount ?></span><?php endif; ?></a></li>
                <li class="nav-item"><a class="nav-link count-link <?= $currentSection === 'compare' ? 'active' : '' ?>" href="index.php?url=compare"><i class="fas fa-balance-scale mr-1"></i>So sánh<?php if ($compareCount > 0): ?><span class="nav-count"><?= $compareCount ?></span><?php endif; ?></a></li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?url=cart"><i class="fas fa-shopping-cart"></i> (<?= $cartCount ?>)</a>
                </li>
                <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
                <li class="nav-item"><a class="nav-link" href="index.php?url=product/create"><i class="fas fa-plus mr-1"></i>Thêm SP</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?url=product/apimanager"><i class="fas fa-code mr-1"></i>API Manager</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentSection === 'account' ? 'active' : '' ?>" href="index.php?url=account/manage"><i class="fas fa-users-cog mr-1"></i>Tài khoản</a></li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                        <?php $navAvatarMini = !empty($_SESSION['avatar']) && file_exists(BASE_PATH . '/' . $_SESSION['avatar']) ? $_SESSION['avatar'] : ''; ?>
                        <?php if ($navAvatarMini): ?><img src="<?= e($navAvatarMini) ?>" alt="Avatar" style="width:24px;height:24px;border-radius:999px;object-fit:cover;margin-right:6px;border:1px solid var(--line)"><?php else: ?><i class="fas fa-user-circle mr-1"></i><?php endif; ?><?= e($_SESSION['fullname'] ?? $_SESSION['username'] ?? '') ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dropdown-menu">
                        <div class="user-dropdown-header">
                            <?php $navAvatar = !empty($_SESSION['avatar']) && file_exists(BASE_PATH . '/' . $_SESSION['avatar']) ? $_SESSION['avatar'] : ''; ?>
                            <div class="user-dropdown-avatar" style="overflow:hidden">
                                <?php if ($navAvatar): ?>
                                    <img src="<?= e($navAvatar) ?>" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">
                                <?php else: ?>
                                    <i class="fas fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <div class="user-dropdown-info">
                                <strong><?= e($_SESSION['fullname'] ?? $_SESSION['username'] ?? '') ?></strong>
                                <span><?= e($_SESSION['role'] ?? 'user') === 'admin' ? 'Quản trị viên' : 'Thành viên' ?><?= !empty($_SESSION['email']) ? ' • ' . e($_SESSION['email']) : '' ?></span>
                            </div>
                        </div>
                        <div class="dropdown-divider" style="border-color:var(--line);margin:0"></div>
                        <a class="dropdown-item" href="index.php?url=order"><i class="fas fa-receipt mr-2"></i>Đơn hàng của tôi</a>
                        <a class="dropdown-item" href="index.php?url=wishlist"><i class="fas fa-heart mr-2"></i>Sản phẩm yêu thích</a>
                        <a class="dropdown-item" href="index.php?url=account/profile"><i class="fas fa-user-cog mr-2"></i>Quản lý tài khoản</a>
                        <?php if (isAdmin()): ?>
                        <div class="dropdown-divider" style="border-color:var(--line);margin:0"></div>
                        <a class="dropdown-item" href="index.php?url=account/manage"><i class="fas fa-users-cog mr-2"></i>Quản lý người dùng</a>
                        <a class="dropdown-item" href="index.php?url=account/jwtdemo"><i class="fas fa-key mr-2"></i>JWT Demo (Bài 6)</a>
                        <?php endif; ?>
                        <div class="dropdown-divider" style="border-color:var(--line);margin:0"></div>
                        <a class="dropdown-item dropdown-logout" href="index.php?url=account/logout"><i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất</a>
                    </div>
                </li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link <?= $currentSection === 'account' ? 'active' : '' ?>" href="index.php?url=account/login"><i class="fas fa-sign-in-alt mr-1"></i>Đăng nhập</a></li>
                <?php endif; ?>
                <li class="nav-item ml-lg-2 mt-2 mt-lg-0"><button class="theme-toggle" type="button" id="themeToggle" title="Đổi giao diện"><i class="fas fa-moon"></i></button></li>
            </ul>
        </div>
    </div>
</nav>

<script>
(function () {
    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }
    ready(function () {
        var navbar = document.getElementById('siteNavbar');
        var collapse = document.getElementById('navbarNav');
        var backdrop = document.getElementById('mobileNavBackdrop');
        var toggler = document.querySelector('.navbar-toggler');

        function onScroll() {
            if (!navbar) return;
            navbar.classList.toggle('is-scrolled', window.scrollY > 80);
        }
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        if (collapse && backdrop) {
            $('#navbarNav').on('show.bs.collapse', function () { backdrop.classList.add('is-open'); document.body.style.overflow = 'hidden'; });
            $('#navbarNav').on('hide.bs.collapse', function () { backdrop.classList.remove('is-open'); document.body.style.overflow = ''; });
            backdrop.addEventListener('click', function () { $('#navbarNav').collapse('hide'); });
            collapse.querySelectorAll('a.nav-link, .mega-menu-item').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 992) $('#navbarNav').collapse('hide');
                });
            });
        }
        if (toggler) toggler.addEventListener('click', function () { setTimeout(onScroll, 40); });
    });
})();
</script>

<div class="main-content">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i><?= e($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i><?= e($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>
