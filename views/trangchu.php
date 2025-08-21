<!DOCTYP    <link rel="stylesheet" href="assets/css/animation.css">
    <link rel="stylesheet" href="assets/css/compact-filter.css">ml>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <link rel="stylesheet" href="assets/css/compact-filter.css">
    <link rel="stylesheet" href="assets/css/price-filter.css">
    <link rel="stylesheet" href="assets/css/price-filter.css">
    <link rel="stylesheet" href="assets/css/harmonious-price.css">
    <script src="assets/css/animation.js"></script>
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f7f7f7;
    }

    .container {
        max-width: 1200px;
        margin: 30px auto;
        background: #fff;
        padding: 0;
        border-radius: 12px;
        box-shadow: 0 4px 24px #b0c4de;
        display: flex;
    }

    .sidebar {
        width: 240px;
        background: #ff8000;
        color: #fff;
        border-radius: 12px 0 0 12px;
        padding: 0 0 20px 0;
        min-height: 100vh;
        position: sticky;
        top: 0;
        align-self: flex-start;
        z-index: 10;
    }

    .sidebar h3 {
        background: #ff8000;
        color: #fff;
        margin: 0;
        padding: 18px 0 12px 28px;
        font-size: 1.2em;
        border-radius: 12px 0 0 0;
        letter-spacing: 1px;
    }

    .sidebar ul {
        list-style: none;
        padding: 0 0 0 10px;
        margin: 0;
    }

    .sidebar ul li {
        padding: 12px 0 12px 28px;
        border-bottom: 1px solid #ffb366;
        font-size: 1.08em;
        cursor: pointer;
        transition: background 0.2s;
    }

    .sidebar ul li:hover {
        background: #ffb366;
        color: #fff;
    }

    .main-content {
        flex: 1;
        padding: 36px 36px 0 36px;
    }

    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .logo {
        display: flex;
        align-items: center;
        font-size: 2em;
        color: #3498db;
        font-weight: bold;
        letter-spacing: 2px;
    }

    .logo img {
        width: 60px;
        height: 60px;
        margin-right: 12px;
    }

    nav {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    nav a {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        font-size: 1.08em;
        padding: 6px 12px;
        border-radius: 6px;
        transition: background 0.2s, color 0.2s;
    }

    nav a:hover {
        background: #eaf6fb;
        color: #217dbb;
    }

    nav .icon {
        font-size: 1.2em;
    }

    .products {
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        justify-content: flex-start;
    }

    .product {
        background: #fafdff;
        border: 1px solid #e3eaf1;
        border-radius: 12px;
        width: 270px;
        padding: 18px;
        box-sizing: border-box;
        transition: box-shadow 0.2s, transform 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .product:hover {
        box-shadow: 0 6px 24px #b0c4de;
        transform: translateY(-4px) scale(1.03);
    }

    .product img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px #e3eaf1;
    }

    .product h3 {
        margin: 14px 0 8px;
        font-size: 1.15em;
        text-align: center;
        color: #217dbb;
    }

    .product .price {
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 8px;
        display: block;
        font-size: 1.08em;
    }

    .product-price {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        padding: 8px 12px;
        margin: 8px 0;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        text-align: center;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .product-price:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        border-color: #dee2e6;
    }

    .price-current {
        color: #495057;
        font-size: 1.1em;
        font-weight: 600;
        display: inline-block;
        position: relative;
    }

    .price-current::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 1px;
        background: linear-gradient(90deg, #6c757d, #495057);
        transition: width 0.3s ease;
    }

    .product-price:hover .price-current::after {
        width: 100%;
    }

    .price-original {
        color: #adb5bd;
        text-decoration: line-through;
        font-size: 0.85em;
        margin-left: 8px;
        opacity: 0.7;
    }

    .price-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 0.7em;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .product .desc {
        font-size: 0.99em;
        color: #555;
        text-align: center;
        margin-bottom: 12px;
    }

    .product .btn-detail {
        background: #3498db;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        margin-bottom: 6px;
    }

    .product .btn-detail:hover {
        background: #217dbb;
    }

    .no-product {
        color: #888;
        font-size: 1.1em;
        text-align: center;
        margin: 40px 0;
    }

    footer {
        margin-top: 48px;
        text-align: center;
        color: #888;
        font-size: 1em;
        background: #fafdff;
        border-radius: 0 0 16px 16px;
        padding: 18px 0 8px 0;
        box-shadow: 0 -2px 12px #e3eaf1;
    }

    .add-cart-form {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
        justify-content: center;
    }

    .add-cart-form input[type="number"] {
        width: 50px;
        height: 32px;
        padding: 5px 4px;
        font-size: 0.98em;
        border: 1px solid #b0c4de;
        border-radius: 5px;
        outline: none;
        transition: all 0.3s ease;
        box-sizing: border-box;
        text-align: center;
    }

    .add-cart-form input[type="number"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
        transform: scale(1.05);
    }

    .add-cart-form input[type="number"]:hover {
        border-color: #007bff;
    }

    .btn-add-cart,
    .btn-buy-now {
        min-width: 90px;
        width: 90px;
        height: 32px;
        padding: 0;
        border-radius: 5px;
        font-size: 0.98em;
        font-weight: 500;
        cursor: pointer;
        box-shadow: 0 2px 8px #e3eaf1;
        border: none;
        transition: background 0.2s, transform 0.15s;
        display: inline-block;
        text-align: center;
        line-height: 32px;
    }

    .btn-add-cart {
        background: linear-gradient(90deg, #27ae60 60%, #2ecc71 100%);
        color: #fff;
        margin-right: 0;
    }

    .btn-add-cart:hover {
        background: linear-gradient(90deg, #219150 60%, #27ae60 100%);
        transform: translateY(-2px) scale(1.04);
    }

    .btn-buy-now {
        background: linear-gradient(90deg, #e67e22 60%, #ffb366 100%);
        color: #fff;
    }

    .btn-buy-now:hover {
        background: linear-gradient(90deg, #d35400 60%, #e67e22 100%);
        transform: translateY(-2px) scale(1.04);
    }

    .banner-slider {
        margin-bottom: 32px;
    }

    .banner-slider img {
        width: 100%;
        max-height: 320px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 12px #b0c4de;
    }

    .main-title-box {
        text-align: center;
        margin: 18px 0 18px 0;
        padding: 0 0 8px 0;
    }

    .main-title {
        font-size: 2.2em;
        font-weight: 900;
        color: #ff8000;
        letter-spacing: 2px;
        text-shadow: 0 4px 24px #dac24bff, 0 2px 8px #e3eaf1;
        background: linear-gradient(90deg, #ff8000 40%, #ffd600 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
        animation: fadeInDown 0.7s;
    }

    .main-weather {
        font-size: 1.35em;
        font-weight: 700;
        color: #217dbb;
        text-shadow: 0 2px 8px #b0c4de;
        background: linear-gradient(90deg, #3498db 40%, #eaf6fb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0;
        animation: fadeInUp 0.7s;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
    <div
        style="width:100vw;max-width:100%;background:#3498db;box-shadow:0 2px 12px #b0c4de;position:relative;z-index:100;">
        <img src="uploads/imgproduct/banner-top.jpg" alt="Banner Top"
            style="width:100%;max-height:110px;object-fit:cover;display:block;margin:0 auto;">
    </div>
    <div class="container">
        <div class="sidebar" data-animate>
            <h3>DANH MỤC SẢN PHẨM</h3>
            <ul>
                <?php
                require_once './models/CategoryModel.php';
                $catModel = new CategoryModel();
                $categories = $catModel->getAll();
                // Nếu muốn hiển thị icon, nên thêm trường 'icon' vào bảng danh mục, ví dụ: $cat['icon']
                foreach ($categories as $cat) {
                    // Nếu có trường 'code' hoặc 'slug' trong bảng, dùng nó, nếu không thì dùng id
                    $code = !empty($cat['code']) ? $cat['code'] : (!empty($cat['slug']) ? $cat['slug'] : $cat['id']);
                    // Nếu có trường 'icon', dùng nó, nếu không thì để trống
                    $icon = !empty($cat['icon']) ? $cat['icon'] : '';
                    echo '<li><a href="?category=' . htmlspecialchars($code) . '" style="color:#fff;text-decoration:none;">' . $icon . ' ' . htmlspecialchars($cat['name']) . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="main-content" data-animate>
            <header>
                <div class="logo">
                    <img src="uploads/imgproduct/logo.jpg" alt="Logo Hòa Thủy Shop">
                    Hòa Thủy Shop
                </div>
                <nav class="menu" data-animate>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=home">
                        <span class="icon">🏠</span> Trang chủ
                    </a>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=products">
                        <span class="icon">🚗</span> Sản phẩm
                    </a>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=contact">
                        <span class="icon">📞</span> Liên hệ
                    </a>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=cart">
                        <span class="icon">🛒</span> Giỏ hàng
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                    <span style="margin-left:18px; color:#27ae60;">
                        <span class="icon">👤</span> Xin chào,
                        <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                    </span>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=logout"
                        style="margin-left:10px; color:#e74c3c;">
                        <span class="icon">🚪</span> Đăng xuất
                    </a>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=order_history">
                        <span class="icon">📦</span> Lịch sử đơn hàng
                    </a>
                    <?php else: ?>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=login"><span class="icon">🔑</span> Đăng
                        nhập</a>
                    <a href="http://localhost/mvc-oop-basic-duanmau/?act=register"><span class="icon">📝</span> Đăng
                        ký</a>
                    <?php endif; ?>
                </nav>
            </header>
            <div class="main-title-box">
                <h1 class="main-title"><?php echo $title; ?></h1>
                <h2 class="main-weather"><?php echo $thoiTiet; ?></h2>
            </div>
            <form method="get" action="http://localhost/mvc-oop-basic-duanmau/?act=products"
                style="margin: 18px 0 24px 0; display: flex; justify-content: center;">
                <input type="text" name="search" placeholder="Nhập từ khóa sản phẩm..."
                    value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
                    style="width: 320px; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px 0 0 6px; font-size: 1em;">
                <button type="submit"
                    style="background: #ff8000; color: #fff; border: none; padding: 8px 22px; border-radius: 0 6px 6px 0; font-size: 1em; cursor: pointer;">🔍
                    Tìm kiếm</button>
            </form>

            <!-- Compact Filter -->
            <div class="compact-filter">
                <h4>🏷️ Lọc theo giá</h4>
                <form method="get" action="">
                    <div class="filter-row">
                        <div class="filter-input-group">
                            <label>Từ:</label>
                            <input type="number" name="min_price" placeholder="0" 
                                   value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>">
                        </div>
                        <div class="filter-input-group">
                            <label>Đến:</label>
                            <input type="number" name="max_price" placeholder="999999999"
                                   value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>">
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn-compact btn-filter-compact">
                                🔍 Lọc
                            </button>
                            <a href="?" class="btn-compact btn-reset-compact">
                                ↻ Reset
                            </a>
                        </div>
                    </div>
                    <div class="quick-filters-compact">
                        <a href="?max_price=100000" class="quick-filter-btn">< 100K</a>
                        <a href="?min_price=100000&max_price=500000" class="quick-filter-btn">100K-500K</a>
                        <a href="?min_price=500000&max_price=1000000" class="quick-filter-btn">500K-1M</a>
                        <a href="?min_price=1000000" class="quick-filter-btn">> 1M</a>
                    </div>
                </form>
            </div>

            <div class="banner-slider" data-animate>
                <img id="banner-img" src="uploads/imgproduct/banner1.jpg" alt="Banner"
                    style="width:100%;max-height:320px;object-fit:cover;border-radius:10px;box-shadow:0 2px 12px #b0c4de;">
            </div>
            <script>
            const bannerImages = [
                'uploads/imgproduct/banner1.jpg',
                'uploads/imgproduct/banner2.jpg',
                'uploads/imgproduct/banner3.jpg'
            ];
            let bannerIndex = 0;
            setInterval(() => {
                bannerIndex = (bannerIndex + 1) % bannerImages.length;
                document.getElementById('banner-img').src = bannerImages[bannerIndex];
            }, 3500);
            </script>
            <div class="products">
                <?php if (!empty($products)): foreach ($products as $p): ?>
                <div class="product product-card" data-animate
                    onclick="window.location.href='?act=product_detail&id=<?php echo (int)$p['id']; ?>'">
                    <?php
                    // Hiển thị ảnh từ database nếu có
                    if (!empty($p['image_blob'])) {
                        $imgSrc = 'data:image/jpeg;base64,' . base64_encode($p['image_blob']);
                    } else {
                        $imgPath = 'uploads/imgproduct/' . ($p['image'] ?? '');
                        if (empty($p['image']) || !is_file($imgPath)) {
                            $imgPath = 'uploads/imgproduct/default.jpg';
                        }
                        $imgSrc = htmlspecialchars($imgPath);
                    }
                    ?>
                    <div style="position:relative;width:100%;height:160px;">
                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"
                            style="width:100%;height:160px;object-fit:cover;border-radius:8px;box-shadow:0 2px 8px #e3eaf1;">
                    </div>
                    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                    
                    <!-- Hiển thị giá sản phẩm -->
                    <div class="price-container price-small">
                        <span class="price-amount">
                            <?php echo number_format($p['price'], 0, ',', '.'); ?>đ
                        </span>
                        <?php if (isset($p['original_price']) && $p['original_price'] > $p['price']): ?>
                            <span class="price-original">
                                <?php echo number_format($p['original_price'], 0, ',', '.'); ?>đ
                            </span>
                            <div class="price-discount-badge">
                                -<?php echo round((($p['original_price'] - $p['price']) / $p['original_price']) * 100); ?>%
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="star-rating"
                        style="margin: 0 auto 8px auto; text-align:center; font-size:1.15em; color:#FFD600; letter-spacing:1px;">
                        <?php
                        // Tối ưu: dùng prepared statement, tránh lỗi SQL injection, đồng bộ với code mẫu
                        $conn = connectDB();
                        $pid = (int)$p['id'];
                        $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = ?");
                        $stmt->execute([$pid]);
                        $row = $stmt ? $stmt->fetch() : null;
                        $avg = $row && $row['avg_rating'] ? round($row['avg_rating'],1) : 0;
                        $total = $row ? (int)$row['total'] : 0;
                        $fullStars = floor($avg);
                        $halfStar = ($avg - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                        for ($i=0; $i<$fullStars; $i++) echo '★';
                        if ($halfStar) echo '<span style="color:#FFD600;">☆</span>';
                        for ($i=0; $i<$emptyStars; $i++) echo '<span style=\'color:#ccc;\'>★</span>';
                        echo $total > 0 ? " <span style='color:#888;font-size:0.98em;'>($avg/5, $total đánh giá)</span>" : " <span style='color:#bbb;font-size:0.98em;'>(Chưa có đánh giá)</span>";
                        ?>
                    </div>

                    <a class="btn-detail" href="#"
                        onclick="showReviewForm(<?php echo (int)$p['id']; ?>);event.stopPropagation();return false;">Đánh
                        giá</a>
                    <form method="post" action="/mvc-oop-basic-duanmau/?act=add_cart" class="add-cart-form"
                        style="margin-top:8px;" onclick="event.stopPropagation();">
                        <input type="hidden" name="product_id" value="<?php echo (int)$p['id']; ?>">
                        <input type="number" name="qty" value="1" min="1" max="99" style="width:50px;"
                            onclick="event.stopPropagation();" onchange="validateQty(this)">
                        <button type="submit" class="btn-add-cart" onclick="event.stopPropagation();">Thêm vào
                            giỏ</button>
                        <button type="submit" name="buy_now" value="1" class="btn-buy-now"
                            style="background:#e67e22;margin-left:8px;" onclick="event.stopPropagation();">Mua
                            ngay</button>
                    </form>
                    <div class="review-form" id="review-form-<?php echo $p['id']; ?>"
                        style="display:none;margin-top:10px;">
                        <?php if (isset($_SESSION['user'])): ?>
                        <form method="post" action="http://localhost/mvc-oop-basic-duanmau/?act=review">
                            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                            <label>Chọn sao:
                                <select name="rating" required>
                                    <option value="5">5 ⭐</option>
                                    <option value="4">4 ⭐</option>
                                    <option value="3">3 ⭐</option>
                                    <option value="2">2 ⭐</option>
                                    <option value="1">1 ⭐</option>
                                </select>
                            </label><br>
                            <textarea name="comment" placeholder="Nhận xét của bạn" required
                                style="width:100%;margin:8px 0;"></textarea>
                            <button type="submit">Gửi đánh giá</button>
                        </form>
                        <?php else: ?>
                        <div style="color:#e67e22;">Bạn cần <a
                                href="http://localhost/mvc-oop-basic-duanmau/?act=login">đăng nhập</a> để đánh giá!
                        </div>
                        <?php endif; ?>
                    </div>
                    <script>
                    function showReviewForm(id) {
                        var f = document.getElementById('review-form-' + id);
                        f.style.display = (f.style.display === 'none') ? 'block' : 'none';
                    }
                    </script>
                    <div style="margin-top:10px;">
                        <?php 
                        // Hiển thị đánh giá sản phẩm
                        $conn = connectDB();
                        $pid = $p['id'];
                        $sql = "SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = $pid ORDER BY r.created_at DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $reviews = $stmt ? $stmt->fetchAll() : [];
                        if (count($reviews) > 0):
                            foreach($reviews as $review): ?>
                        <div style="background:#f1f1f1;padding:7px 10px;border-radius:5px;margin-bottom:5px;">
                            <b><?php echo htmlspecialchars($review['username']); ?></b> -
                            <?php echo str_repeat('⭐', $review['rating']); ?><br>
                            <span><?php echo nl2br(htmlspecialchars($review['comment'])); ?></span>
                        </div>
                        <?php endforeach; else: ?>
                        <div style="color:#888;">Chưa có đánh giá nào.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; else: ?>
                <div class="no-product">Hiện chưa có sản phẩm nào!</div>
                <?php endif; ?>
            </div>
            <footer>
                &copy; <?php echo date('Y'); ?> Xe Trẻ Em. Liên hệ: 0123 456 789 - Địa chỉ: 123 Đường ABC,
                TP. XYZ<br>
                Website demo đồ án môn học - Được phát triển bởi sinh viên.<br>
                <div style="margin-top:10px;">
                    <a href="mailto:support@xetreem.com" style="color:#3498db;">Email hỗ trợ</a> |
                    <a href="https://facebook.com" target="_blank" style="color:#3498db;">Facebook</a> |
                    <a href="https://zalo.me" target="_blank" style="color:#3498db;">Zalo</a>
                </div>
            </footer>
        </div>
    </div>
    <script>
    function showProductInfo(el, product) {
        // Xóa popup cũ nếu có
        let old = document.getElementById('product-info-popup');
        if (old) old.remove();
        // Tạo popup
        let div = document.createElement('div');
        div.id = 'product-info-popup';
        div.style.position = 'fixed';
        div.style.top = '0';
        div.style.left = '0';
        div.style.width = '100vw';
        div.style.height = '100vh';
        div.style.background = 'rgba(0,0,0,0.45)';
        div.style.display = 'flex';
        div.style.alignItems = 'center';
        div.style.justifyContent = 'center';
        div.style.zIndex = '9999';
        div.innerHTML = `
            <div style="background:#fff;max-width:420px;width:95vw;border-radius:12px;box-shadow:0 4px 24px #b0c4de;padding:28px 24px 18px 24px;position:relative;animation:fadeIn .5s;">
                <button onclick="document.getElementById('product-info-popup').remove()" style="position:absolute;top:10px;right:14px;background:none;border:none;font-size:1.5em;cursor:pointer;color:#888;">&times;</button>
                <div style="display:flex;align-items:center;gap:18px;">
                    <img src="${product.image}" alt="${product.name}" style="width:110px;height:110px;object-fit:cover;border-radius:8px;box-shadow:0 2px 8px #e3eaf1;">
                    <div>
                        <h3 style="margin:0 0 8px 0;color:#217dbb;font-size:1.2em;">${product.name}</h3>
                        <div style="color:#e74c3c;font-weight:bold;font-size:1.08em;margin-bottom:6px;">${Number(product.price).toLocaleString('vi-VN')} đ</div>
                    </div>
                </div>
                <div style="color:#555;font-size:0.98em;line-height:1.5;margin-top:12px;">${product.description}</div>
            </div>
        `;
        document.body.appendChild(div);
    }

    // Validate quantity input
    function validateQty(input) {
        let qty = parseInt(input.value);
        console.log('Validating quantity:', qty);

        if (isNaN(qty) || qty < 1) {
            input.value = 1;
            console.log('Set to minimum: 1');
            showNotification('Số lượng phải từ 1 trở lên!', 'warning');
        } else if (qty > 99) {
            input.value = 99;
            console.log('Set to maximum: 99');
            showNotification('Số lượng tối đa là 99!', 'warning');
        }

        console.log('Final quantity:', input.value);
    }

    // Confirm add to cart with feedback
    function confirmAddToCart(button) {
        const form = button.closest('form');
        const qty = form.querySelector('input[name="qty"]').value;
        const productId = form.querySelector('input[name="product_id"]').value;
        const productName = form.closest('.product').querySelector('h3').textContent;

        if (parseInt(qty) < 1) {
            showNotification('Vui lòng chọn số lượng hợp lệ!', 'error');
            return false;
        }

        if (!productId || productId === '0') {
            showNotification('Lỗi: Không xác định được sản phẩm!', 'error');
            return false;
        }

        // Change button text to show loading
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang thêm...';
        button.disabled = true;

        // Store form data for potential retry
        window.lastCartData = {
            form: form,
            button: button,
            originalText: originalText,
            productName: productName,
            qty: qty
        };

        // Re-enable button after timeout (in case form doesn't submit properly)
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 5000);

        showNotification(`Đang thêm ${qty} ${productName} vào giỏ hàng...`, 'info');
        return true;
    }

    // Show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#ff9800'};
            color: white;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            font-weight: 500;
            transform: translateX(300px);
            transition: transform 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        // Slide in
        setTimeout(() => notification.style.transform = 'translateX(0)', 100);

        // Slide out and remove
        setTimeout(() => {
            notification.style.transform = 'translateX(300px)';
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 3000);
    }

    // Debug form submission
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener to all cart forms
        const cartForms = document.querySelectorAll('.add-cart-form');
        cartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                console.log('Form submitting...');
                console.log('Action:', this.action);
                console.log('Method:', this.method);

                const formData = new FormData(this);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, ':', value);
                }

                // Let form submit normally
                console.log('Form will submit to:', this.action);
            });
        });
    });
    </script>
</body>

</html>