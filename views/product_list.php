<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <link rel="stylesheet" href="assets/css/compact-filter.css">
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f7f7f7;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    .product-table th,
    .product-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .product-table th {
        background: #f8f9fa;
        font-weight: bold;
    }

    .product-table img {
        max-width: 60px;
        height: auto;
        border-radius: 4px;
    }

    .price {
        font-weight: bold;
        color: #ff8000;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>🛍️ Danh sách sản phẩm</h2>

        <!-- Compact Filter -->
        <div class="compact-filter">
            <h4>🏷️ Lọc theo giá</h4>
            <form method="get" action="">
                <input type="hidden" name="act" value="product-list">
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
                        <a href="?act=product-list" class="btn-compact btn-reset-compact">
                            ↻ Reset
                        </a>
                    </div>
                </div>
                <div class="quick-filters-compact">
                    <a href="?act=product-list&max_price=100000" class="quick-filter-btn">< 100K</a>
                    <a href="?act=product-list&min_price=100000&max_price=500000" class="quick-filter-btn">100K-500K</a>
                    <a href="?act=product-list&min_price=500000&max_price=1000000" class="quick-filter-btn">500K-1M</a>
                    <a href="?act=product-list&min_price=1000000" class="quick-filter-btn">> 1M</a>
                </div>
            </form>
        </div>

        <!-- Results count -->
        <div style="margin-bottom: 20px; color: #666;">
            <strong>Kết quả: <?php echo is_array($products) ? count($products) : 0; ?> sản phẩm</strong>
            <?php if (!empty($_GET['min_price']) || !empty($_GET['max_price']) || !empty($_GET['category'])): ?>
            <span style="color: #28a745;"> (đã lọc)</span>
            <?php endif; ?>
        </div>

        <!-- Product Table -->
        <table class="product-table">
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ảnh</th>
                <th>Danh mục</th>
            </tr>
            <?php if (!empty($products)): ?>
            <?php foreach ($products as $prod): ?>
            <tr>
                <td><?= $prod['id'] ?></td>
                <td><?= htmlspecialchars($prod['name']) ?></td>
                <td class="price"><?= number_format($prod['price']) ?>đ</td>
                <td><img src="/mvc-oop-basic-duanmau/uploads/imgproduct/<?= $prod['image'] ?>"
                        alt="<?= htmlspecialchars($prod['name']) ?>"></td>
                <td><?= isset($prod['category_name']) ? htmlspecialchars($prod['category_name']) : htmlspecialchars($prod['category']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: #999;">
                    Không có sản phẩm nào phù hợp với bộ lọc của bạn.
                </td>
            </tr>
            <?php endif; ?>
        </table>

        <div style="margin-top: 30px; text-align: center;">
            <a href="/" class="btn" style="background: #ff8000; color: white;">🏠 Về trang chủ</a>
        </div>
    </div>
</body>

</html>