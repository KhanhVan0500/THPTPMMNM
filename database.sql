-- =============================================
-- CƠ SỞ DỮ LIỆU KZANN - BÁN ĐIỆN THOẠI CHÍNH HÃNG
-- Bản nâng cấp tài khoản: email verification, reset password, avatar, remember me, lock/unlock.
-- =============================================

CREATE DATABASE IF NOT EXISTS my_store
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE my_store;

-- Bắt buộc để tránh lỗi font/mojibake (ký tự lạ) khi import bằng dòng lệnh mysql
-- trên các client có charset mặc định khác utf8mb4 (ví dụ latin1).
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(15,2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    category_id INT,
    brand VARCHAR(50) DEFAULT NULL,
    rating DECIMAL(3,1) DEFAULT 0,
    reviews_count INT DEFAULT 0,
    original_price DECIMAL(15,2) DEFAULT NULL,
    discount VARCHAR(20) DEFAULT NULL,
    specs JSON DEFAULT NULL,
    tag VARCHAR(50) DEFAULT NULL,
    emoji VARCHAR(10) DEFAULT '📦',
    FOREIGN KEY (category_id) REFERENCES category(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS product_images (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng tài khoản người dùng nâng cao
CREATE TABLE IF NOT EXISTS account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    email_verified_at DATETIME NULL,
    email_verification_token VARCHAR(64) NULL,
    password_reset_token VARCHAR(64) NULL,
    password_reset_expires DATETIME NULL,
    remember_token_hash VARCHAR(255) NULL,
    last_login_at DATETIME NULL,
    failed_login_attempts INT NOT NULL DEFAULT 0,
    locked_until DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    INDEX idx_account_email (email),
    INDEX idx_account_reset_token (password_reset_token),
    INDEX idx_account_verify_token (email_verification_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NULL,
    address TEXT NOT NULL,
    note TEXT NULL,
    payment_method VARCHAR(50) DEFAULT 'COD',
    payment_status VARCHAR(20) DEFAULT 'unpaid',
    subtotal_amount DOUBLE DEFAULT 0,
    discount_amount DOUBLE DEFAULT 0,
    shipping_fee DOUBLE DEFAULT 0,
    total_amount DOUBLE DEFAULT 0,
    status VARCHAR(30) DEFAULT 'new',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_orders_account_id (account_id),
    FOREIGN KEY (account_id) REFERENCES account(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    quantity INT NOT NULL,
    price DOUBLE NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Bảng lưu giỏ hàng theo tài khoản. Giúp giỏ hàng không mất khi đóng/mở lại trình duyệt hoặc đăng nhập lại.
CREATE TABLE IF NOT EXISTS user_cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_cart_item (account_id, product_id),
    INDEX idx_user_cart_account (account_id),
    INDEX idx_user_cart_product (product_id),
    CONSTRAINT fk_user_cart_account
        FOREIGN KEY (account_id) REFERENCES account(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user_cart_product
        FOREIGN KEY (product_id) REFERENCES product(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng đánh giá sản phẩm (đã đổi tên và cấu trúc theo yêu cầu mới)
CREATE TABLE IF NOT EXISTS product_reviews (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    username   VARCHAR(255) NOT NULL,
    rating     INT NOT NULL,
    comment    TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng danh sách yêu thích (theo session)
CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(128) NOT NULL,
    product_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_wish (session_id, product_id),
    CONSTRAINT fk_wishlist_product
        FOREIGN KEY (product_id) REFERENCES product(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu - danh mục
INSERT INTO category (id, name, description) VALUES
(1, 'Điện thoại',      'Danh mục các loại điện thoại'),
(2, 'Laptop',          'Danh mục các loại laptop'),
(3, 'Máy tính bảng',   'Danh mục các loại máy tính bảng'),
(4, 'Phụ kiện',        'Danh mục phụ kiện điện tử'),
(5, 'Thiết bị âm thanh','Danh mục loa, tai nghe, micro');

-- Dữ liệu mẫu - sản phẩm
INSERT INTO product (id, name, description, price, image, category_id, brand, rating, reviews_count, original_price, discount, tag) VALUES
(1, 'iPhone 15 Pro Max 256GB', 'Điện thoại cao cấp của Apple, chip A17 Pro, camera 48MP', 33990000, 'uploads/anh5.jpg', 1, 'Apple', 4.8, 2148, 36990000, '8%', 'hot'),
(2, 'Samsung Galaxy S24 Ultra', 'Điện thoại Android cao cấp, bút S-Pen, camera 200MP', 31990000, 'uploads/anh6.jpg', 1, 'Samsung', 4.7, 1856, 34990000, '9%', 'hot'),
(3, 'MacBook Air M3 13 inch',   'Laptop siêu mỏng nhẹ, chip M3, pin 18 giờ', 31990000, 'uploads/anh7.jpg', 2, 'Apple', 4.9, 945, 35990000, '11%', 'sale'),
(4, 'Dell XPS 15 OLED',         'Laptop cao cấp màn hình OLED 3.5K, Intel i9', 45990000, 'uploads/anh8.jpg', 2, 'Dell', 4.6, 673, 49990000, '8%', ''),
(5, 'iPad Pro M4 11 inch',      'Máy tính bảng chuyên nghiệp, chip M4, màn OLED', 27990000, 'uploads/anh9.jpg', 3, 'Apple', 4.8, 823, 30990000, '10%', 'new'),
(6, 'AirPods Pro 2',            'Tai nghe không dây, chống ồn chủ động, âm thanh Spatial', 6490000, 'uploads/anh10.jpg', 5, 'Apple', 4.9, 3421, 7990000, '19%', 'hot'),
(7, 'Apple Watch Series 9',     'Đồng hồ thông minh, theo dõi sức khỏe, GPS', 11990000, 'uploads/anh11.jpg', 4, 'Apple', 4.7, 1234, 13990000, '14%', ''),
(8, 'Chuột Logitech MX Master 3','Chuột không dây cao cấp, DPI 8000, pin 70 ngày', 2290000, 'uploads/anh12.jpg', 4, 'Logitech', 4.8, 567, 2890000, '21%', '');

-- Tài khoản mặc định. MD5 được giữ để tương thích khi import SQL; ứng dụng sẽ tự nâng cấp sang password_hash sau lần đăng nhập thành công.
INSERT INTO account (username, email, password, fullname, role, is_active, email_verified_at) VALUES
('admin', 'admin@khanhstore.vn', MD5('123456'), 'Quản trị viên', 'admin', 1, NOW()),
('user1', 'user1@khanhstore.vn', MD5('123456'), 'Nguyễn Văn A', 'user', 1, NOW());
