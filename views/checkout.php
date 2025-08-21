<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <script src="assets/css/animation.js"></script>
    <style>
    body {
        font-family: Arial;
        background: #f7f7f7;
    }

    .checkout-box {
        max-width: 400px;
        margin: 40px auto;
        background: #fff;
        padding: 28px;
        border-radius: 8px;
        box-shadow: 0 2px 8px #ccc;
    }

    h2 {
        text-align: center;
    }

    input,
    textarea {
        width: 100%;
        padding: 8px;
        margin: 8px 0 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #27ae60;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1em;
        cursor: pointer;
    }

    button:hover {
        background: #219150;
    }

    .error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .error::before {
        content: "⚠️";
        margin-right: 8px;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <?php if ($productInfo): ?>
    <div style="max-width:500px;margin:30px auto 0 auto;background:#fafdff;border-radius:10px;box-shadow:0 2px 12px #b0c4de;padding:18px 24px 12px 24px;">
        <div style="display:flex;align-items:center;gap:18px;">
            <img src="<?php echo htmlspecialchars($productInfo['image']); ?>" alt="<?php echo htmlspecialchars($productInfo['name']); ?>" style="width:110px;height:110px;object-fit:cover;border-radius:8px;box-shadow:0 2px 8px #e3eaf1;">
            <div>
                <h3 style="margin:0 0 8px 0;color:#217dbb;font-size:1.2em;"><?php echo htmlspecialchars($productInfo['name']); ?></h3>
                <div class="price-container price-small">
                    <span class="price-label">Giá bán:</span>
                    <span class="price-amount">
                        <?php echo number_format($productInfo['price'] ?? 0, 0, ',', '.'); ?>đ
                    </span>
                </div>
                <div style="color:#555;font-size:0.98em;line-height:1.5;">
                    <?php echo htmlspecialchars($productInfo['description']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="checkout-box">
        <h2>Xác nhận đặt hàng</h2>
        <?php if(!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" id="checkoutForm">
            <input type="text" name="name" placeholder="Họ tên người nhận *" required 
                   minlength="2" maxlength="100" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            <textarea name="address" placeholder="Địa chỉ nhận hàng *" required 
                      minlength="10" maxlength="500" rows="3"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            <input type="tel" name="phone" placeholder="Số điện thoại *" required 
                   pattern="[0-9]{9,12}" title="Số điện thoại phải có 9-12 chữ số"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            <button type="submit" id="submitBtn">💳 Đặt hàng ngay</button>
        </form>
        <div style="margin-top:12px;text-align:center;">
            <a href="http://localhost/mvc-oop-basic-duanmau/?act=cart">🛒 Quay về giỏ hàng</a>
        </div>
    </div>

    <script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const name = this.name.value.trim();
        const address = this.address.value.trim();
        const phone = this.phone.value.trim();
        
        if (name.length < 2) {
            alert('❌ Họ tên phải có ít nhất 2 ký tự!');
            e.preventDefault();
            return;
        }
        
        if (address.length < 10) {
            alert('❌ Địa chỉ giao hàng phải có ít nhất 10 ký tự!');
            e.preventDefault();
            return;
        }
        
        if (!/^[0-9]{9,12}$/.test(phone)) {
            alert('❌ Số điện thoại phải có 9-12 chữ số!');
            e.preventDefault();
            return;
        }
        
        // Disable button to prevent double submission
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '⏳ Đang xử lý...';
    });
    </script>
</body>

</html>