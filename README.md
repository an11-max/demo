# 🛒 MVC OOP Basic - E-commerce Website

Dự án website bán hàng được xây dựng theo mô hình MVC và lập trình hướng đối tượng (OOP) với PHP.

## 📋 Tính năng chính

### 👤 Người dùng
- ✅ **Đăng ký/Đăng nhập** tài khoản
- ✅ **Tìm kiếm** sản phẩm theo tên
- ✅ **Lọc sản phẩm** theo khoảng giá (Filter thu gọn)
- ✅ **Xem chi tiết** sản phẩm
- ✅ **Thêm vào giỏ hàng** và quản lý giỏ hàng
- ✅ **Đặt hàng** và thanh toán
- ✅ **Xem lịch sử** đơn hàng
- ✅ **Hủy đơn hàng** (nếu chưa xử lý)

### 🛡️ Admin
- ✅ **Quản lý danh mục** (CRUD)
- ✅ **Quản lý sản phẩm** (CRUD) 
- ✅ **Quản lý đơn hàng** (Xem, cập nhật trạng thái, xóa)
- ✅ **Dashboard** thống kê tổng quan
- ✅ **Đăng ký admin** mới

## 🛠️ Công nghệ sử dụng

- **Backend**: PHP 8+ (OOP, MVC Pattern)
- **Database**: MySQL/MariaDB (PDO)
- **Frontend**: HTML5, CSS3, JavaScript
- **Security**: Password hashing, SQL injection prevention
- **Session**: PHP Session management

## 📁 Cấu trúc dự án

```
mvc-oop-basic-duanmau/
├── Admin/                    # Admin panel
├── assets/css/              # CSS files
│   ├── animation.css        # Animation effects
│   ├── animation.js         # JavaScript effects  
│   └── compact-filter.css   # Product filter styles
├── commons/                 # Common utilities
│   ├── env.php             # Environment config
│   └── function.php        # Helper functions
├── controllers/             # Controllers (MVC)
├── models/                  # Models (MVC)
├── views/                   # Views (MVC)
├── uploads/imgproduct/      # Product images
├── database_complete.sql    # Database structure
└── index.php               # Entry point
```

## 🚀 Cài đặt

### 1. Clone dự án
```bash
git clone https://github.com/[username]/mvc-oop-basic-duanmau.git
cd mvc-oop-basic-duanmau
```

### 2. Cấu hình database
```sql
-- Import file database_complete.sql vào MySQL
mysql -u root -p your_database < database_complete.sql
```

### 3. Cấu hình kết nối database
Chỉnh sửa file `commons/env.php`:
```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username'); 
define('DB_PASS', 'your_password');
?>
```

### 4. Chạy dự án
```bash
# Sử dụng XAMPP/WAMP/Laragon
# Hoặc PHP built-in server:
php -S localhost:8000
```

## 🎨 Tính năng mới nhất

### ✨ Filter sản phẩm thu gọn
- **Giao diện**: Filter nằm gọn trong 1 hàng ngang
- **Tìm kiếm**: Theo tên sản phẩm
- **Lọc giá**: Nhập khoảng giá tùy chỉnh
- **Quick filters**: < 100K, 100K-500K, 500K-1M, > 1M
- **Responsive**: Tương thích mọi thiết bị

### 🔧 Code đã tối ưu
- Xóa CSS và file không cần thiết
- Tối ưu hóa hiệu suất loading
- Code sạch sẽ, dễ maintain

## 📸 Screenshots

### Trang chủ với Filter thu gọn
![Homepage](screenshot-homepage.png)

### Admin Dashboard  
![Admin](screenshot-admin.png)

## 🤝 Đóng góp

1. Fork dự án
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.

## 📧 Liên hệ

- **Developer**: [Your Name]
- **Email**: [your.email@example.com]
- **GitHub**: [@yourusername](https://github.com/yourusername)

---

⭐ **Star this repo if you find it helpful!** ⭐
