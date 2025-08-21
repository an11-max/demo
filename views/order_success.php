<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <script src="assets/css/animation.js"></script>
    <style>
    body {
        font-family: Arial;
        background: #f7f7f7;
    }

    .success-box {
        max-width: 450px;
        margin: 60px auto;
        background: #fff;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .success-box h2 {
        color: #27ae60;
        margin-bottom: 20px;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .success-box a {
        color: #3498db;
        text-decoration: none;
        margin: 0 10px;
    }

    .success-box a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="success-box">
        <h2>🎉 Đặt hàng thành công!</h2>

        <div class="success-message">
            Cảm ơn bạn đã mua hàng! Đơn hàng của bạn đã được ghi nhận và đang được xử lý.
        </div>

        <?php if (isset($order) && $order): ?>
        <p><strong>Mã đơn hàng:</strong> #<?= htmlspecialchars($order['id']) ?></p>
        <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> đ</p>
        <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
        <?php endif; ?>

        <div style="margin: 20px 0;">
            <?php if (isset($_SESSION['user'])): ?>
            <a href="/mvc-oop-basic-duanmau/?act=order_history">📋 Xem lịch sử đơn hàng</a>
            <?php endif; ?>
            <a href="/mvc-oop-basic-duanmau/">🛍️ Tiếp tục mua sắm</a>
        </div>
    </div>
</body>

</html>