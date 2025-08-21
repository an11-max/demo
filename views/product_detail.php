<?php
require_once './commons/function.php';
require_once './models/ProductModel.php';

// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy ID sản phẩm
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$productModel = new ProductModel();
$product = $productModel->getProductById($id);

// Nếu không tồn tại sản phẩm
if (!$product) {
    echo '<div style="text-align:center;margin:60px 0;font-size:1.2em;color:#e74c3c;">Sản phẩm không tồn tại!</div>';
    exit;
}

// Xử lý đường dẫn ảnh sản phẩm
$imagePath = 'uploads/imgproduct/' . $product['image'];
if (empty($product['image']) || !file_exists(__DIR__ . '/../' . $imagePath)) {
    $imagePath = 'uploads/imgproduct/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> | Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <style>
    body {
        background: #f7f7f7;
        font-family: 'Quicksand', Arial, sans-serif;
    }

    .product-detail-container {
        max-width: 1100px;
        margin: 40px auto 30px auto;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 24px #b0c4de;
        display: flex;
        gap: 36px;
        padding: 32px 36px 28px 36px;
        align-items: flex-start;
    }

    .product-detail-image {
        flex: 1 1 340px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-detail-image img {
        width: 340px;
        height: 340px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 2px 12px #e3eaf1;
        background: #fff;
    }

    .product-detail-info {
        flex: 2 1 400px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .product-detail-title {
        font-size: 2em;
        font-weight: 700;
        color: #217dbb;
        margin-bottom: 8px;
    }

    .product-detail-price {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        padding: 12px 18px;
        margin: 12px 0;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        text-align: center;
        position: relative;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .product-detail-price:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        border-color: #dee2e6;
    }

    .price-main {
        color: #495057;
        font-size: 1.6em;
        font-weight: 600;
        display: block;
        margin-bottom: 4px;
        position: relative;
    }

    .price-main::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #6c757d, #495057);
        border-radius: 1px;
        transition: width 0.3s ease;
    }

    .product-detail-price:hover .price-main::after {
        width: 60%;
    }

    .price-label {
        color: #6c757d;
        font-size: 0.85em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .product-detail-desc {
        color: #444;
        font-size: 1.08em;
        margin-bottom: 18px;
    }

    .product-detail-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 18px;
    }

    .product-detail-actions input[type="number"] {
        width: 80px;
        height: 40px;
        padding: 8px;
        font-size: 1em;
        border: 1px solid #b0c4de;
        border-radius: 6px;
        margin-right: 12px;
        outline: none;
        transition: border 0.2s;
        box-sizing: border-box;
    }
    
    .product-detail-actions input[type="number"]:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }
    
    .product-detail-actions input[type="number"]:hover {
        border-color: #85a5cc;
    }

    .btn-animated {
        background: linear-gradient(90deg, #27ae60 60%, #2ecc71 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 22px;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: 0 2px 8px #27ae6033;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: background 0.3s, transform 0.2s;
        min-width: 120px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-animated:hover {
        background: linear-gradient(90deg, #219150 60%, #27ae60 100%);
        transform: translateY(-2px) scale(1.04);
    }

    .btn-animated:active {
        transform: scale(0.97);
    }
    
    .btn-animated:disabled {
        background: #95a5a6;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-animated[name="buy_now"] {
        background: linear-gradient(90deg, #e67e22 60%, #ffb366 100%);
        margin-left: 8px;
    }
    
    .btn-animated[name="buy_now"]:hover {
        background: linear-gradient(90deg, #d35400 60%, #e67e22 100%);
    }

    .product-detail-review {
        margin-top: 18px;
        background: #fefefeff;
        border-radius: 8px;
        padding: 14px 18px;
        box-shadow: 0 1px 6px #e3eaf1;
    }

    .product-detail-review h4 {
        margin: 0 0 8px 0;
        color: #217dbb;
    }

    .product-detail-review .review-item {
        background: #157de4ff;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
    }

    .product-detail-back {
        position: fixed;
        left: 50px;
        top: 7px;
        z-index: 100;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 12px #b0c4de44;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: box-shadow 0.2s, background 0.2s;
        background: #c2eac4ff;
    }

    .product-detail-back:hover {
        box-shadow: 0 4px 18px #217dbb33;
        background: #c2ca74ff;

    }

    .product-detail-back a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: #2d36b6;
        text-decoration: none;
    }

    .product-detail-back a span {
        font-size: 1.7em;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-detail-back a span svg {
        width: 28px;
        height: 28px;
        fill: none;
        stroke: #2d36b6;
        stroke-width: 2;
    }

    .product-detail-back a span svg path {
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    @media (max-width: 768px) {
        .product-detail-container {
            flex-direction: column;
            align-items: center;
        }

        .product-detail-image img {
            width: 100%;
            height: auto;
        }

        .product-detail-info {
            width: 100%;
            text-align: center;
        }

        .product-detail-actions {
            flex-direction: column;
            align-items: center;
        }

        .btn-animated {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .product-detail-title {
            font-size: 1.5em;
        }

        .product-detail-price {
            font-size: 1.2em;
        }

        .product-detail-desc {
            font-size: 1em;
        }

        .btn-animated {
            padding: 8px 16px;
            font-size: 0.9em;
        }
    }

    .review-item b {
        color: #fff;
        font-weight: 600;
    }

    .review-item {
        color: #fff;
        font-size: 0.95em;
        margin-bottom: 8px;
    }

    .review-item:last-child {
        margin-bottom: 0;
    }

    .review-item span {
        color: #ffd700;
    }

    .review-item br {
        margin: 4px 0;
    }

    .review-item:hover {
        background: #1e90ff;
        transform: translateY(-2px);
        transition: background 0.2s, transform 0.2s;
    }

    .review-item:hover b {
        color: #fff;
    }

    .review-item:hover span {
        color: #ffd700;
    }

    .review-item:hover br {
        margin: 6px 0;
    }

    .review-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .review-item:hover b {
        color: #fff;
    }

    .review-item:hover span {
        color: #ffd700;
    }

    .review-item:hover br {
        margin: 6px 0;
    }

    .review-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .review-item:hover b {
        color: #fff;
    }

    .review-item:hover span {
        color: #ffd700;
    }

    .review-item:hover br {
        margin: 6px 0;
    }

    .review-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .review-item:hover b {
        color: #fff;
    }
    </style>
</head>

<body>

    <!-- Nút quay lại trang chủ -->
    <div class="product-detail-back">
        <a href="?act=home" title="Về trang chủ">
            <span>
                <svg width="28" height="28" viewBox="0 0 24 24">
                    <path d="M3 10.75L12 4L21 10.75" stroke="#2d36b6" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M5 10V20C5 20.5523 5.44772 21 6 21H18C18.5523 21 19 20.5523 19 20V10" stroke="#2d36b6"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </a>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="product-detail-container">
        <div class="product-detail-image">
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="product-detail-info">
            <div class="product-detail-title"><?= htmlspecialchars($product['name']) ?></div>
            <div class="price-container price-large">
                <span class="price-label">Giá bán:</span>
                <span class="price-amount"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?>đ</span>
            </div>
            <div class="product-detail-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></div>

            <!-- Form thêm vào giỏ -->
            <form class="product-detail-actions" method="post" action="/mvc-oop-basic-duanmau/?act=add_cart">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="number" name="qty" value="1" min="1" max="99" 
                       style="width:80px;height:40px;padding:8px;border:1px solid #ccc;border-radius:6px;margin-right:12px;"
                       onchange="validateQty(this)" oninput="validateQty(this)">
                <button type="submit" class="btn-animated">Thêm vào giỏ</button>
                <button type="submit" name="buy_now" value="1" class="btn-animated">Mua ngay</button>
            </form>

            <!-- Đánh giá sản phẩm -->
            <div class="product-detail-review">
                <h4>Đánh giá sản phẩm</h4>
                <?php
            $conn = connectDB();
            $stmt = $conn->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ? ORDER BY r.created_at DESC LIMIT 5");
            $stmt->execute([$product['id']]);
            $reviews = $stmt->fetchAll();

            if ($reviews) {
                foreach ($reviews as $review) {
                    echo "<div class='review-item'><b>" . htmlspecialchars($review['username']) . "</b> - " . str_repeat('⭐', $review['rating']) . "<br>" . nl2br(htmlspecialchars($review['comment'])) . "</div>";
                }
            } else {
                echo '<div style="color:#888;">Chưa có đánh giá nào.</div>';
            }

            // Form đánh giá
            if (isset($_SESSION['user'])):
            ?>
                <form method="post" action="?act=review" style="margin-top:10px;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <label>Chọn sao:
                        <select name="rating" required>
                            <option value="5">5 ⭐</option>
                            <option value="4">4 ⭐</option>
                            <option value="3">3 ⭐</option>
                            <option value="2">2 ⭐</option>
                            <option value="1">1 ⭐</option>
                        </select>
                    </label><br>
                    <textarea name="comment" required placeholder="Nhận xét của bạn"
                        style="width:100%;margin-top:8px;"></textarea>
                    <button type="submit" class="btn-animated" style="margin-top:6px;">Gửi đánh giá</button>
                </form>
                <?php else: ?>
                <div style="color:#e67e22;margin-top:8px;">Bạn cần <a href="?act=login">đăng nhập</a> để đánh giá!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Gợi ý sản phẩm -->
    <div style="max-width:1100px;margin:30px auto 0 auto;">
        <h3 style="color:#217dbb;margin-bottom:18px;">Gợi ý sản phẩm liên quan</h3>
        <div style="display:flex;gap:22px;flex-wrap:wrap;">
            <?php
        $suggests = $productModel->getProductByCategory($product['category'], $product['id']);
        $count = 0;

        foreach ($suggests as $sp) {
            if (++$count > 4) break;

            $imgPath = 'uploads/imgproduct/' . ($sp['image'] ?: 'default.jpg');
            if (!file_exists(__DIR__ . '/../' . $imgPath)) {
                $imgPath = 'uploads/imgproduct/default.jpg';
            }

            echo "<div style='width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px #e3eaf1;padding:12px;cursor:pointer;transition:all 0.3s ease;' onclick=\"location.href='?act=product_detail&id={$sp['id']}'\" onmouseover=\"this.style.transform='translateY(-4px)';this.style.boxShadow='0 4px 15px rgba(0,0,0,0.15)';\" onmouseout=\"this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px #e3eaf1';\">";
            echo "<img src='$imgPath' alt='" . htmlspecialchars($sp['name']) . "' style='width:100%;height:120px;object-fit:cover;border-radius:8px;'>";
            echo "<div style='font-weight:700;color:#217dbb;margin:10px 0 8px 0;text-align:center;'>" . htmlspecialchars($sp['name']) . "</div>";
            echo "<div class='price-container price-small' style='margin:0;'>";
            echo "<span class='price-amount'>" . number_format($sp['price'] ?? 0, 0, ',', '.') . "đ</span>";
            echo "</div>";
            echo "</div>";
        }
        ?>
        </div>
    </div>

    <script>
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
    
    // Add event listener to quantity input
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInput = document.querySelector('input[name="qty"]');
        if (qtyInput) {
            qtyInput.addEventListener('change', function() {
                validateQty(this);
            });
            
            qtyInput.addEventListener('input', function() {
                validateQty(this);
            });
        }
        
        // Add debug for form submission
        const cartForm = document.querySelector('.product-detail-actions');
        if (cartForm) {
            cartForm.addEventListener('submit', function(e) {
                console.log('Product detail form submitting...');
                console.log('Action:', this.action);
                console.log('Method:', this.method);
                
                const formData = new FormData(this);
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, ':', value);
                }
                
                const qty = formData.get('qty');
                const productId = formData.get('product_id');
                
                if (!productId || productId === '0') {
                    e.preventDefault();
                    showNotification('Lỗi: Không xác định được sản phẩm!', 'error');
                    return false;
                }
                
                if (!qty || parseInt(qty) < 1) {
                    e.preventDefault();
                    showNotification('Vui lòng chọn số lượng hợp lệ!', 'error');
                    return false;
                }
                
                // Show loading notification
                showNotification(`Đang thêm ${qty} sản phẩm vào giỏ hàng...`, 'info');
                
                // Disable button to prevent double submission
                const button = this.querySelector('button[type="submit"]:not([name="buy_now"])');
                if (button) {
                    button.disabled = true;
                    button.textContent = 'Đang thêm...';
                    
                    setTimeout(() => {
                        button.disabled = false;
                        button.textContent = 'Thêm vào giỏ';
                    }, 3000);
                }
            });
        }
    });
    </script>

</body>

</html>