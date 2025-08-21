

-- Tạo database
CREATE DATABASE IF NOT EXISTS mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mvc;



DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS categories;

-- =================================================
-- TẠO CẤU TRÚC BẢNG
-- =================================================

-- Bảng danh mục sản phẩm
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng người dùng (khách hàng)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) DEFAULT '',
    phone VARCHAR(20) DEFAULT '',
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng quản trị viên
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) DEFAULT '',
    phone VARCHAR(20) DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng sản phẩm
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    image VARCHAR(255),
    image_blob LONGBLOB,
    description TEXT,
    category VARCHAR(50) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng đánh giá sản phẩm
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bảng đơn hàng
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    customer_name VARCHAR(100),
    customer_email VARCHAR(100),
    customer_phone VARCHAR(20),
    shipping_address TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Bảng chi tiết đơn hàng
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- =================================================
-- CHÈN DỮ LIỆU MẪU
-- =================================================

-- Dữ liệu mẫu cho danh mục
INSERT INTO categories (name, code) VALUES
('Xe ô tô điện trẻ em', 'oto'),
('Xe máy điện trẻ em', 'maydien'),
('Xe cần cẩu máy xúc', 'cancau'),
('Xe chòi chân cho bé', 'choichan'),
('Xe đạp trẻ em', 'xedap'),
('Xe trượt scooter trẻ em', 'scooter'),
('Đồ chơi cho bé', 'dochoi');

-- Dữ liệu mẫu cho quản trị viên
-- Password mặc định: admin123 (đã được hash)
INSERT INTO admins (username, password, email, phone) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@mvc.com', '0123456789'),
('superadmin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin@mvc.com', '0987654321'),
('manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager@mvc.com', '0111222333');

-- Dữ liệu mẫu cho người dùng
-- Password mặc định: user123 (đã được hash)
INSERT INTO users (username, password, email, phone, role, status) VALUES
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user1@gmail.com', '0901234567', 'user', 'active'),
('user2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user2@gmail.com', '0902345678', 'user', 'active'),
('customer1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer1@yahoo.com', '0903456789', 'user', 'active'),
('testuser', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'test@mvc.com', '0904567890', 'user', 'inactive'),
('demo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'demo@mvc.com', '0905678901', 'admin', 'active');

-- Dữ liệu mẫu cho sản phẩm (84 sản phẩm - 12 cho mỗi danh mục)
INSERT INTO products (name, price, image, description, category) VALUES
-- Xe ô tô điện trẻ em (12 sản phẩm)
('Xe ô tô điện trẻ em Mercedes', 3500000, 'oto1.jpg', 'Xe ô tô điện trẻ em kiểu dáng Mercedes, có điều khiển từ xa, an toàn cho bé.', 'oto'),
('Xe ô tô điện trẻ em BMW', 3400000, 'oto2.jpg', 'Xe ô tô điện trẻ em BMW, động cơ mạnh mẽ, màu xanh cá tính.', 'oto'),
('Xe ô tô điện trẻ em Audi', 3600000, 'oto3.jpg', 'Xe ô tô điện trẻ em Audi, thiết kế sang trọng, bảo vệ an toàn.', 'oto'),
('Xe ô tô điện trẻ em Ford', 3300000, 'oto4.jpg', 'Xe ô tô điện trẻ em Ford, bánh lớn, phù hợp mọi địa hình.', 'oto'),
('Xe ô tô điện trẻ em Lexus', 3550000, 'oto5.jpg', 'Xe ô tô điện trẻ em Lexus, màu trắng sang trọng.', 'oto'),
('Xe ô tô điện trẻ em Jeep', 4200000, 'oto6.jpg', 'Xe jeep điện địa hình cho bé, bánh lớn, động cơ mạnh, phù hợp mọi địa hình.', 'oto'),
('Xe ô tô điện trẻ em Toyota', 3200000, 'oto7.jpg', 'Xe ô tô điện trẻ em Toyota, tiết kiệm điện, an toàn.', 'oto'),
('Xe ô tô điện trẻ em KIA', 3100000, 'oto8.jpg', 'Xe ô tô điện trẻ em KIA, màu đỏ nổi bật.', 'oto'),
('Xe ô tô điện trẻ em Hyundai', 3250000, 'oto9.jpg', 'Xe ô tô điện trẻ em Hyundai, thiết kế hiện đại.', 'oto'),
('Xe ô tô điện trẻ em Porsche', 3700000, 'oto10.jpg', 'Xe ô tô điện trẻ em Porsche, kiểu dáng thể thao.', 'oto'),
('Xe ô tô điện trẻ em VinFast', 3450000, 'oto11.jpg', 'Xe ô tô điện trẻ em VinFast, thương hiệu Việt.', 'oto'),
('Xe ô tô điện trẻ em Lamborghini', 3900000, 'oto12.jpg', 'Xe ô tô điện trẻ em Lamborghini, siêu xe cho bé.', 'oto'),

-- Xe máy điện trẻ em (12 sản phẩm)
('Xe máy điện trẻ em Vespa', 2100000, 'sm1.jpg', 'Xe máy điện trẻ em kiểu dáng Vespa, màu hồng dễ thương, phù hợp cho bé gái.', 'maydien'),
('Xe máy điện trẻ em Honda', 2000000, 'sm2.jpg', 'Xe máy điện trẻ em Honda, động cơ bền bỉ.', 'maydien'),
('Xe máy điện trẻ em Yamaha', 2150000, 'sm3.jpg', 'Xe máy điện trẻ em Yamaha, màu xanh thể thao.', 'maydien'),
('Xe máy điện trẻ em Ducati', 2250000, 'sm4.jpg', 'Xe máy điện trẻ em Ducati, kiểu dáng thể thao.', 'maydien'),
('Xe máy điện trẻ em BMW', 2300000, 'sm5.jpg', 'Xe máy điện trẻ em BMW, thiết kế mạnh mẽ.', 'maydien'),
('Xe máy điện trẻ em Suzuki', 2050000, 'sm6.jpg', 'Xe máy điện trẻ em Suzuki, màu vàng nổi bật.', 'maydien'),
('Xe máy điện trẻ em Piaggio', 2200000, 'sm7.jpg', 'Xe máy điện trẻ em Piaggio, kiểu dáng Ý.', 'maydien'),
('Xe máy điện trẻ em Aprilia', 2400000, 'sm8.jpg', 'Xe máy điện trẻ em Aprilia, phong cách đua.', 'maydien'),
('Xe máy điện trẻ em Kawasaki', 2350000, 'sm9.jpg', 'Xe máy điện trẻ em Kawasaki, động cơ mạnh.', 'maydien'),
('Xe máy điện trẻ em Harley', 2500000, 'sm10.jpg', 'Xe máy điện trẻ em Harley Davidson, phong cách Mỹ.', 'maydien'),
('Xe máy điện trẻ em SYM', 1950000, 'sm11.jpg', 'Xe máy điện trẻ em SYM, nhỏ gọn, tiện lợi.', 'maydien'),
('Xe máy điện trẻ em Kymco', 2100000, 'sm12.jpg', 'Xe máy điện trẻ em Kymco, màu cam cá tính.', 'maydien'),

-- Xe cần cẩu máy xúc (12 sản phẩm)
('Xe cần cẩu trẻ em CAT', 1200000, 'cau1.jpg', 'Xe cần cẩu trẻ em CAT, mô phỏng xe công trình.', 'cancau'),
('Xe máy xúc trẻ em Komatsu', 1300000, 'cau2.jpg', 'Xe máy xúc trẻ em Komatsu, màu vàng nổi bật.', 'cancau'),
('Xe cần cẩu trẻ em Volvo', 1250000, 'cau3.jpg', 'Xe cần cẩu trẻ em Volvo, thiết kế chắc chắn.', 'cancau'),
('Xe máy xúc trẻ em Hitachi', 1350000, 'cau4.jpg', 'Xe máy xúc trẻ em Hitachi, động cơ khỏe.', 'cancau'),
('Xe cần cẩu trẻ em Liebherr', 1400000, 'cau5.jpg', 'Xe cần cẩu trẻ em Liebherr, mô phỏng thực tế.', 'cancau'),
('Xe máy xúc trẻ em JCB', 1280000, 'cau6.jpg', 'Xe máy xúc trẻ em JCB, màu vàng đen.', 'cancau'),
('Xe cần cẩu trẻ em Hyundai', 1220000, 'cau7.jpg', 'Xe cần cẩu trẻ em Hyundai, thiết kế hiện đại.', 'cancau'),
('Xe máy xúc trẻ em Doosan', 1380000, 'cau8.jpg', 'Xe máy xúc trẻ em Doosan, động cơ mạnh.', 'cancau'),
('Xe cần cẩu trẻ em Kobelco', 1270000, 'cau9.jpg', 'Xe cần cẩu trẻ em Kobelco, màu xanh dương.', 'cancau'),
('Xe máy xúc trẻ em Volvo', 1320000, 'cau10.jpg', 'Xe máy xúc trẻ em Volvo, mô phỏng thực tế.', 'cancau'),
('Xe cần cẩu trẻ em XCMG', 1290000, 'cau11.jpg', 'Xe cần cẩu trẻ em XCMG, thương hiệu nổi tiếng.', 'cancau'),
('Xe máy xúc trẻ em SANY', 1340000, 'cau12.jpg', 'Xe máy xúc trẻ em SANY, động cơ bền.', 'cancau'),

-- Xe chòi chân cho bé (12 sản phẩm)
('Xe chòi chân trẻ em Little Tikes', 650000, 'choi1.jpg', 'Xe chòi chân trẻ em Little Tikes, màu đỏ vàng.', 'choichan'),
('Xe chòi chân trẻ em Smart Trike', 700000, 'choi2.jpg', 'Xe chòi chân trẻ em Smart Trike, thiết kế thông minh.', 'choichan'),
('Xe chòi chân trẻ em Chicco', 680000, 'choi3.jpg', 'Xe chòi chân trẻ em Chicco, màu xanh lá.', 'choichan'),
('Xe chòi chân trẻ em Radio Flyer', 720000, 'choi4.jpg', 'Xe chòi chân trẻ em Radio Flyer, kiểu dáng Mỹ.', 'choichan'),
('Xe chòi chân trẻ em Fisher Price', 690000, 'choi5.jpg', 'Xe chòi chân trẻ em Fisher Price, màu sắc tươi sáng.', 'choichan'),
('Xe chòi chân trẻ em Babyhop', 670000, 'choi6.jpg', 'Xe chòi chân trẻ em Babyhop, nhỏ gọn.', 'choichan'),
('Xe chòi chân trẻ em Joovy', 710000, 'choi7.jpg', 'Xe chòi chân trẻ em Joovy, thiết kế hiện đại.', 'choichan'),
('Xe chòi chân trẻ em Puky', 730000, 'choi8.jpg', 'Xe chòi chân trẻ em Puky, thương hiệu Đức.', 'choichan'),
('Xe chòi chân trẻ em Globber', 660000, 'choi9.jpg', 'Xe chòi chân trẻ em Globber, màu xanh dương.', 'choichan'),
('Xe chòi chân trẻ em Broller', 640000, 'choi10.jpg', 'Xe chòi chân trẻ em Broller, giá rẻ.', 'choichan'),
('Xe chòi chân trẻ em QPlay', 750000, 'choi11.jpg', 'Xe chòi chân trẻ em QPlay, thiết kế thông minh.', 'choichan'),
('Xe chòi chân trẻ em Munchkin', 760000, 'choi12.jpg', 'Xe chòi chân trẻ em Munchkin, màu cam.', 'choichan'),

-- Xe đạp trẻ em (12 sản phẩm)
('Xe đạp trẻ em RoyalBaby', 1500000, 'xd1.jpg', 'Xe đạp trẻ em RoyalBaby 16 inch, thiết kế chắc chắn, màu sắc tươi sáng.', 'xedap'),
('Xe đạp trẻ em Giant', 1600000, 'xd2.jpg', 'Xe đạp trẻ em Giant, thương hiệu nổi tiếng.', 'xedap'),
('Xe đạp trẻ em Thống Nhất', 1200000, 'xd3.jpg', 'Xe đạp trẻ em Thống Nhất, bền đẹp.', 'xedap'),
('Xe đạp trẻ em Martin', 1300000, 'xd4.jpg', 'Xe đạp trẻ em Martin, màu xanh lá.', 'xedap'),
('Xe đạp trẻ em Stitch', 1400000, 'xd5.jpg', 'Xe đạp trẻ em Stitch, thiết kế dễ thương.', 'xedap'),
('Xe đạp trẻ em Fornix', 1350000, 'xd6.jpg', 'Xe đạp trẻ em Fornix, bánh lớn.', 'xedap'),
('Xe đạp trẻ em Asama', 1450000, 'xd7.jpg', 'Xe đạp trẻ em Asama, màu hồng.', 'xedap'),
('Xe đạp trẻ em Totem', 1250000, 'xd8.jpg', 'Xe đạp trẻ em Totem, kiểu dáng thể thao.', 'xedap'),
('Xe đạp trẻ em Nhựa Chợ Lớn', 1100000, 'xd9.jpg', 'Xe đạp trẻ em Nhựa Chợ Lớn, giá rẻ.', 'xedap'),
('Xe đạp trẻ em Cannondale', 1550000, 'xd10.jpg', 'Xe đạp trẻ em Cannondale, thương hiệu Mỹ.', 'xedap'),
('Xe đạp trẻ em Phoenix', 1150000, 'xd11.jpg', 'Xe đạp trẻ em Phoenix, màu đỏ.', 'xedap'),
('Xe đạp trẻ em Trinx', 1250000, 'xd12.jpg', 'Xe đạp trẻ em Trinx, thiết kế thể thao.', 'xedap'),

-- Xe trượt scooter trẻ em (12 sản phẩm)
('Xe scooter trẻ em 3 bánh', 490000, 'co1.jpg', 'Xe scooter 3 bánh cho bé, dễ sử dụng, phát triển vận động.', 'scooter'),
('Xe scooter trẻ em Globber', 520000, 'co2.jpg', 'Xe scooter trẻ em Globber, màu xanh.', 'scooter'),
('Xe scooter trẻ em Micro', 530000, 'co3.jpg', 'Xe scooter trẻ em Micro, thương hiệu Thụy Sĩ.', 'scooter'),
('Xe scooter trẻ em Oxelo', 510000, 'co4.jpg', 'Xe scooter trẻ em Oxelo, thiết kế chắc chắn.', 'scooter'),
('Xe scooter trẻ em Broller', 500000, 'co5.jpg', 'Xe scooter trẻ em Broller, giá rẻ.', 'scooter'),
('Xe scooter trẻ em Babyhop', 540000, 'co6.jpg', 'Xe scooter trẻ em Babyhop, màu hồng.', 'scooter'),
('Xe scooter trẻ em QPlay', 550000, 'co7.jpg', 'Xe scooter trẻ em QPlay, thiết kế thông minh.', 'scooter'),
('Xe scooter trẻ em Munchkin', 560000, 'co8.jpg', 'Xe scooter trẻ em Munchkin, màu cam.', 'scooter'),
('Xe scooter trẻ em Puky', 570000, 'co9.jpg', 'Xe scooter trẻ em Puky, thương hiệu Đức.', 'scooter'),
('Xe scooter trẻ em Joovy', 580000, 'co10.jpg', 'Xe scooter trẻ em Joovy, thiết kế hiện đại.', 'scooter'),
('Xe scooter trẻ em Little Tikes', 590000, 'co11.jpg', 'Xe scooter trẻ em Little Tikes, màu đỏ vàng.', 'scooter'),
('Xe scooter trẻ em Smart Trike', 600000, 'co12.jpg', 'Xe scooter trẻ em Smart Trike, thiết kế thông minh.', 'scooter'),

-- Đồ chơi cho bé (12 sản phẩm)
('Bộ xếp hình Lego', 350000, 'D1.jpg', 'Bộ xếp hình Lego cho bé phát triển trí tuệ.', 'dochoi'),
('Bộ đồ chơi nấu ăn', 250000, 'D2.jpg', 'Bộ đồ chơi nấu ăn cho bé gái.', 'dochoi'),
('Bộ đồ chơi bác sĩ', 270000, 'D3.jpg', 'Bộ đồ chơi bác sĩ cho bé.', 'dochoi'),
('Bộ đồ chơi siêu nhân', 300000, 'D4.jpg', 'Bộ đồ chơi siêu nhân cho bé trai.', 'dochoi'),
('Bộ đồ chơi xe cứu hỏa', 320000, 'D5.jpg', 'Bộ đồ chơi xe cứu hỏa cho bé.', 'dochoi'),
('Bộ đồ chơi xe cảnh sát', 310000, 'D6.jpg', 'Bộ đồ chơi xe cảnh sát cho bé.', 'dochoi'),
('Bộ đồ chơi xếp hình nam châm', 330000, 'D7.jpg', 'Bộ đồ chơi xếp hình nam châm sáng tạo.', 'dochoi'),
('Bộ đồ chơi lắp ráp xe', 340000, 'D8.jpg', 'Bộ đồ chơi lắp ráp xe cho bé.', 'dochoi'),
('Bộ đồ chơi nhà bếp', 260000, 'D9.jpg', 'Bộ đồ chơi nhà bếp mini.', 'dochoi'),
('Bộ đồ chơi dụng cụ sửa chữa', 280000, 'D10.jpg', 'Bộ đồ chơi dụng cụ sửa chữa cho bé trai.', 'dochoi'),
('Bộ đồ chơi xe tải', 290000, 'D11.jpg', 'Bộ đồ chơi xe tải mini.', 'dochoi'),
('Bộ đồ chơi xe buýt', 295000, 'D12.jpg', 'Bộ đồ chơi xe buýt cho bé.', 'dochoi');

-- Dữ liệu mẫu cho đánh giá sản phẩm
INSERT INTO reviews (product_id, user_id, rating, comment) VALUES
(1, 1, 5, 'Xe rất đẹp và chất lượng, con tôi rất thích!'),
(1, 2, 4, 'Sản phẩm tốt, giao hàng nhanh.'),
(2, 1, 5, 'BMW mini này quá tuyệt, thiết kế rất đẹp.'),
(3, 3, 5, 'Audi cho bé chất lượng cao, đáng tiền.'),
(4, 2, 4, 'Ford này bền và an toàn cho bé.'),
(13, 1, 5, 'Xe máy Vespa dễ thương, bé gái rất thích.'),
(25, 2, 4, 'Xe cần cẩu CAT mô phỏng thật, bé trai mê.'),
(37, 3, 5, 'Xe chòi chân Little Tikes chất lượng tốt.'),
(49, 1, 4, 'Xe đạp RoyalBaby đẹp và an toàn.'),
(61, 2, 5, 'Scooter 3 bánh giúp bé học thăng bằng tốt.'),
(73, 3, 5, 'Lego phát triển trí tuệ rất tốt cho bé.');

-- Dữ liệu mẫu cho đơn hàng (tùy chọn)
INSERT INTO orders (user_id, total_amount, status, customer_name, customer_email, customer_phone, shipping_address) VALUES
(1, 3500000, 'delivered', 'Nguyễn Văn A', 'user1@gmail.com', '0901234567', '123 Đường ABC, Quận 1, TP.HCM'),
(2, 2100000, 'processing', 'Trần Thị B', 'user2@gmail.com', '0902345678', '456 Đường DEF, Quận 2, TP.HCM'),
(3, 1200000, 'pending', 'Lê Văn C', 'customer1@yahoo.com', '0903456789', '789 Đường GHI, Quận 3, TP.HCM');

-- Dữ liệu mẫu cho chi tiết đơn hàng
INSERT INTO order_items (order_id, product_id, quantity, price, total) VALUES
(1, 1, 1, 3500000, 3500000),
(2, 13, 1, 2100000, 2100000),
(3, 25, 1, 1200000, 1200000);



CREATE INDEX idx_products_category ON products(category);
CREATE INDEX idx_products_name ON products(name);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_admins_username ON admins(username);
CREATE INDEX idx_reviews_product_id ON reviews(product_id);
CREATE INDEX idx_reviews_user_id ON reviews(user_id);



SELECT 'Database setup completed successfully!' as message;
SELECT COUNT(*) as total_categories FROM categories;
SELECT COUNT(*) as total_products FROM products;
SELECT COUNT(*) as total_users FROM users;
SELECT COUNT(*) as total_admins FROM admins;
SELECT COUNT(*) as total_reviews FROM reviews;
