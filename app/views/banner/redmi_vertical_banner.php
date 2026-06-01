<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REDMI Note 15 Series Banner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f0f4f8 0%, #e8f1f7 100%);
        }
        .banner-container {
            width: 300px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .logo-section {
            background: linear-gradient(135deg, #ff9800 0%, #ff7043 100%);
            padding: 12px;
            text-align: center;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        .title-section {
            padding: 20px 16px 16px;
            text-align: center;
        }
        .main-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
            margin-bottom: 4px;
        }
        .highlight-text {
            color: #e91e63;
            font-weight: 700;
            font-size: 18px;
        }
        .slogan {
            font-size: 14px;
            color: #666;
            font-weight: 500;
            margin: 8px 0;
        }
        .price-text {
            font-size: 13px;
            color: #00897b;
            font-weight: 600;
        }
        .offer-box {
            background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
            margin: 16px;
            padding: 14px;
            border-radius: 12px;
            color: white;
            font-size: 13px;
            line-height: 1.6;
        }
        .offer-item {
            margin-bottom: 8px;
        }
        .offer-item:last-child {
            margin-bottom: 0;
        }
        .offer-bold {
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }
        .small-text {
            font-size: 11px;
            color: #555;
            text-align: center;
            padding: 0 16px 8px;
            line-height: 1.4;
        }
        .small-text-highlight {
            color: #00897b;
            font-weight: 600;
        }
        .cta-button {
            background: linear-gradient(135deg, #ff6f00 0%, #ff5722 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: underline;
            transition: transform 0.2s, box-shadow 0.2s;
            width: 90%;
            margin: 0 auto 16px;
            display: block;
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 87, 34, 0.3);
        }
        .phone-section {
            padding: 16px;
            background: linear-gradient(180deg, #f0f4f8 0%, #e1f5fe 100%);
            text-align: center;
        }
        .phone-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #b3e5fc 0%, #81d4fa 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0277bd;
            font-size: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Banner Container -->
    <div class="banner-container">
        <!-- 1. Logo Section -->
        <div class="logo-section">
            <div class="logo-icon">REDMI</div>
        </div>

        <!-- 2. Title & Slogan Section -->
        <div class="title-section">
            <div class="main-title">
                REDMI <span class="highlight-text">Note 15</span><br>Series
            </div>
            <div class="slogan">Bền vô đối</div>
            <div class="price-text">Giá từ 5.49 Triệu</div>
        </div>

        <!-- 3. Offer Box -->
        <div class="offer-box">
            <div class="offer-item">
                <span class="offer-bold">🎁 Tặng Loa Xiaomi</span>
                <span>1.3 Triệu</span>
            </div>
            <div class="offer-item">
                <span class="offer-bold">⬆️ Trợ giá lên đời</span>
                <span>đến 2 Triệu</span>
            </div>
        </div>

        <!-- 4. Small Text & Button -->
        <div class="small-text">
            <span class="small-text-highlight">S-Teacher | S-Student</span><br>
            Giảm thêm đến 300K
        </div>
        <button class="cta-button">Mua Ngay</button>

        <!-- 5. Phone Image Section -->
        <div class="phone-section">
            <div class="phone-image">
                <div>
                    <div style="font-size: 48px; margin-bottom: 8px;">📱</div>
                    <div>REDMI Note 15</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
