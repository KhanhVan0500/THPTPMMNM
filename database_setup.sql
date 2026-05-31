-- =====================================================
-- SQL SETUP - Web Bán Hàng (Bài 2 + Bài 3)
-- Chạy script này trong phpMyAdmin hoặc MySQL CLI
-- =====================================================

-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS my_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE my_store;

-- Tạo bảng category (danh mục sản phẩm)
CREATE TABLE IF NOT EXISTS category (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT
);

-- Tạo bảng product (sản phẩm)
CREATE TABLE IF NOT EXISTS product (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL,
    image       VARCHAR(255) DEFAULT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
);

-- Tạo bảng orders (đơn hàng) - BÀI 3
CREATE TABLE IF NOT EXISTS orders (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(255) DEFAULT NULL,
    name       VARCHAR(255) NOT NULL,
    phone      VARCHAR(20)  NOT NULL,
    address    TEXT NOT NULL,
    status     VARCHAR(50) NOT NULL DEFAULT 'Đang xử lý',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Nếu đã có bảng orders nhưng thiếu cột username hoặc status chưa đúng mặc định
ALTER TABLE orders ADD COLUMN IF NOT EXISTS username VARCHAR(255) DEFAULT NULL;
ALTER TABLE orders MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'Đang xử lý';

-- Tạo bảng order_details (chi tiết đơn hàng) - BÀI 3
CREATE TABLE IF NOT EXISTS order_details (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT NOT NULL,
    price      DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- =====================================================
-- DỮ LIỆU MẪU
-- =====================================================

-- Chèn dữ liệu danh mục
INSERT INTO category (name, description) VALUES
('Điện thoại',      'Danh mục các loại điện thoại'),
('Laptop',          'Danh mục các loại laptop'),
('Máy tính bảng',   'Danh mục các loại máy tính bảng'),
('Phụ kiện',        'Danh mục phụ kiện điện tử'),
('Thiết bị âm thanh','Danh mục loa, tai nghe, micro');

-- Chèn dữ liệu sản phẩm mẫu
INSERT INTO product (name, description, price, category_id) VALUES
('iPhone 15 Pro Max 256GB', 'Điện thoại cao cấp của Apple, chip A17 Pro, camera 48MP', 33990000, 1),
('Samsung Galaxy S24 Ultra', 'Điện thoại Android cao cấp, bút S-Pen, camera 200MP', 31990000, 1),
('MacBook Air M3 13 inch',   'Laptop siêu mỏng nhẹ, chip M3, pin 18 giờ', 31990000, 2),
('Dell XPS 15 OLED',         'Laptop cao cấp màn hình OLED 3.5K, Intel i9', 45990000, 2),
('iPad Pro M4 11 inch',      'Máy tính bảng chuyên nghiệp, chip M4, màn OLED', 27990000, 3),
('AirPods Pro 2',            'Tai nghe không dây, chống ồn chủ động, âm thanh Spatial', 6490000, 5),
('Apple Watch Series 9',     'Đồng hồ thông minh, theo dõi sức khỏe, GPS', 11990000, 4),
('Chuột Logitech MX Master 3','Chuột không dây cao cấp, DPI 8000, pin 70 ngày', 2290000, 4);
