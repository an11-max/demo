<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f7f7f7; font-family: 'Segoe UI', Arial, sans-serif; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #ccc; padding: 32px; }
        h2 { text-align: center; color: #007bff; margin-bottom: 24px; }
        .back-link { text-align: center; margin-top: 24px; }
        .back-link a { color: #555; text-decoration: underline; font-size: 16px; }
        .product-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; }
        .product-item { background: #f9f9f9; border-radius: 8px; box-shadow: 0 1px 4px #ccc; padding: 18px; text-align: center; }
        .product-img { width: 120px; border-radius: 6px; margin-bottom: 12px; }
        .product-name { font-size: 18px; font-weight: 500; color: #007bff; margin-bottom: 8px; }
        .product-price { color: #28a745; font-size: 16px; font-weight: 500; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-search"></i> Kết quả tìm kiếm sản phẩm</h2>
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $prod): ?>
                    <div class="product-item">
                        <img src="../uploads/imgproduct/<?= $prod['image'] ?>" class="product-img">
                        <div class="product-name"><?= $prod['name'] ?></div>
                        <div class="product-price"><?= number_format($prod['price'] ?? 0) ?>đ</div>
                        <div><?= $prod['category_name'] ?? '' ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div>Không tìm thấy sản phẩm phù hợp.</div>
            <?php endif; ?>
        </div>
        <div class="back-link">
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list">Quay lại danh sách sản phẩm</a>
        </div>
    </div>
</body>
</html>
