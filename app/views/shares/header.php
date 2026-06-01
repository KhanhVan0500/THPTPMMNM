<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
require_once __DIR__ . '/../../helpers/SessionHelper.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KhanhzannShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{font-family:'Poppins',sans-serif}
        body{
            background: linear-gradient(135deg,#eef2ff,#fdf2f8,#ecfeff);
            min-height:100vh;
            color:#1e293b;
        }
        .navbar{
            background: rgba(255,255,255,.75)!important;
            backdrop-filter: blur(10px);
            border-radius:20px;
            margin:15px auto;
            width:95%;
            box-shadow:0 8px 30px rgba(0,0,0,.08);
        }
        .navbar-brand{
            font-weight:700;
            font-size:28px;
            background: linear-gradient(to right,#7c3aed,#06b6d4);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }
        .nav-link{
            color:#334155!important;
            font-weight:500;
            transition:.3s;
        }
        .nav-link:hover{
            color:#7c3aed!important;
            transform:translateY(-2px);
        }
        .main-box{
            background:rgba(255,255,255,.75);
            backdrop-filter:blur(12px);
            border-radius:30px;
            padding:30px;
            box-shadow:0 10px 40px rgba(0,0,0,.08);
            margin-bottom:30px;
        }
        .btn{
            border:none;
            border-radius:14px;
            padding:10px 18px;
            font-weight:600;
        }
        .btn-primary{background:linear-gradient(45deg,#7c3aed,#06b6d4)}
        .btn-success{background:linear-gradient(45deg,#10b981,#22c55e)}
        .btn-warning{background:linear-gradient(45deg,#f59e0b,#f97316);color:white}
        .btn-danger{background:linear-gradient(45deg,#ef4444,#f43f5e)}
        .card{
            border:none;
            border-radius:24px;
            overflow:hidden;
            background:rgba(255,255,255,.9);
            transition:.3s;
            box-shadow:0 8px 25px rgba(0,0,0,.06);
        }
        .card:hover{
            transform:translateY(-8px) scale(1.02);
        }
        .product-card-img{
            width:100%;
            height:240px;
            object-fit:cover;
            display:block;
        }
        .hero-banner{
            position:relative;
            width:100%;
            border-radius:0;
            overflow:hidden;
            min-height:420px;
            background-image:linear-gradient(180deg,rgba(15,23,42,.15),rgba(15,23,42,.6)),url('https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1600&q=80');
            background-size:cover;
            background-position:center;
            margin-bottom:30px;
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            box-shadow:0 20px 60px rgba(15,23,42,.12);
        }
        .hero-banner .hero-content{
            z-index:1;
            max-width:760px;
            padding:30px;
        }
        .hero-banner h1{
            font-size:3rem;
            line-height:1.05;
            margin-bottom:18px;
            text-shadow:0 20px 40px rgba(15,23,42,.45);
        }
        .hero-banner p{
            font-size:1.05rem;
            opacity:.92;
            margin-bottom:24px;
        }
        .hero-banner .btn-hero{
            background:linear-gradient(45deg,#ec4899,#6366f1);
            border:none;
            border-radius:999px;
            padding:12px 28px;
            font-weight:700;
        }
        .hero-banner::before{
            content:'';
            position:absolute;
            inset:0;
            background:linear-gradient(135deg,rgba(124,58,237,.25),rgba(34,197,94,.2));
        }
        .category-bar{
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin-bottom:30px;
            justify-content:center;
        }
        .category-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 18px;
            border-radius:999px;
            background:rgba(255,255,255,.95);
            color:#334155;
            border:1px solid rgba(99,102,241,.16);
            text-decoration:none;
            font-weight:600;
            box-shadow:0 10px 20px rgba(15,23,42,.04);
            transition:.25s ease;
        }
        .category-pill:hover{
            transform:translateY(-2px);
            background:rgba(124,58,237,.08);
            color:#4f46e5;
        }
        .category-pill.active{
            background:linear-gradient(135deg,#7c3aed,#06b6d4);
            color:#fff;
            border-color:transparent;
            box-shadow:0 14px 30px rgba(99,102,241,.18);
        }
        .badge-info{
            background:#dbeafe;
            color:#2563eb;
            padding:8px 14px;
            border-radius:999px;
        }
        .price-tag{
            color:#7c3aed;
            font-size:22px;
            font-weight:700;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="/Product">KhanhzannShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item"><a class="nav-link" href="/Product">Khám phá</a></li>
            <?php if (SessionHelper::isLoggedIn()) : ?>
                <li class="nav-item"><a class="nav-link" href="/Product/orders"><?php echo SessionHelper::isAdmin() ? 'Quản lý đơn hàng' : 'Đơn hàng của tôi'; ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/account/profile">Hồ sơ</a></li>
            <?php endif; ?>
            <?php if (SessionHelper::isAdmin()) : ?>
                <li class="nav-item"><a class="nav-link" href="/Category">Quản lý danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="/account/users">Quản lý người dùng</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['username'])) : ?>
                <?php if (!empty($_SESSION['avatar'])) : ?>
                    <li class="nav-item d-flex align-items-center mr-2">
                        <img src="<?php echo htmlentities($_SESSION['avatar']); ?>" alt="Avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;margin-right:8px;">
                    </li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="#">Xin chào, <?php echo htmlentities($_SESSION['fullname'] ?: $_SESSION['username']); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/account/logout">Logout</a></li>
            <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="/account/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="/account/register">Đăng ký</a></li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="btn btn-primary ml-2" href="/Product/cart">🛒 Giỏ hàng<?php echo $cartCount > 0 ? ' (' . $cartCount . ')' : ''; ?></a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
<div class="main-box">
