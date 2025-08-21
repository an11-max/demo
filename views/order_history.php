<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <script src="assets/css/animation.js"></script>
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f7f7f7;
    }

    .history-box {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        padding: 32px 32px 24px 32px;
        border-radius: 16px;
        box-shadow: 0 4px 24px #b0c4de;
        animation: fadeIn .7s;
    }

    .order-title {
        text-align: center;
        font-size: 2.1em;
        font-weight: 800;
        color: #2d36b6;
        margin-bottom: 18px;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px #e3eaf1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .order-icon {
        font-size: 1.2em;
        background: linear-gradient(90deg, #ff8000 60%, #ffd600 100%);
        border-radius: 50%;
        padding: 8px 12px;
        color: #fff;
        box-shadow: 0 2px 8px #ffd60044;
        margin-right: 6px;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 18px;
        background: #fafdff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px #e3eaf1;
    }

    .order-table th {
        background: linear-gradient(90deg, #ff8000 60%, #ffd600 100%);
        color: #fff;
        font-size: 1.08em;
        font-weight: 700;
        border: none;
        padding: 12px 0;
    }

    .order-table td {
        border: none;
        padding: 12px 8px;
        font-size: 1.08em;
        background: #fff;
        transition: background 0.2s;
    }

    .order-row:hover td {
        background: #f1f7ff;
    }

    .order-id {
        font-weight: 700;
        color: #3498db;
        font-size: 1.08em;
    }

    .order-total {
        color: #e74c3c;
        font-weight: bold;
        font-size: 1.08em;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 16px;
        border-radius: 16px;
        font-size: 1em;
        font-weight: 600;
        letter-spacing: 1px;
        box-shadow: 0 2px 8px #e3eaf1;
    }

    .status-pending {
        background: #fffbe6;
        color: #ff8000;
        border: 1.5px solid #ffd600;
    }

    .status-canceled {
        background: #ffeaea;
        color: #e74c3c;
        border: 1.5px solid #e74c3c;
    }

    .status-completed {
        background: #eaffea;
        color: #27ae60;
        border: 1.5px solid #27ae60;
    }

    .status-shipping {
        background: #eaf6fb;
        color: #3498db;
        border: 1.5px solid #3498db;
    }

    .btn-delete {
        background: linear-gradient(90deg, #e74c3c 60%, #ffb366 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 1em;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 8px #e3eaf1;
        transition: background 0.2s, transform 0.15s;
        text-decoration: none;
        margin: 0 2px;
        display: inline-block;
    }

    .btn-delete:hover {
        background: linear-gradient(90deg, #c0392b 60%, #e67e22 100%);
        transform: translateY(-2px) scale(1.04);
    }

    .no-action {
        color: #bbb;
        font-size: 1.1em;
    }

    .no-order {
        color: #888;
        font-size: 1.1em;
        text-align: center;
        padding: 18px 0;
    }

    .order-back {
        margin-top: 18px;
        text-align: center;
    }

    .order-back a {
        color: #3498db;
        font-weight: 600;
        text-decoration: none;
        font-size: 1.08em;
        transition: color 0.2s;
    }

    .order-back a:hover {
        color: #2d36b6;
        text-decoration: underline;
    }

    .message {
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .message.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @media (max-width: 900px) {
        .history-box {
            padding: 12px 2vw 12px 2vw;
        }

        .order-title {
            font-size: 1.3em;
        }

        .order-table th,
        .order-table td {
            font-size: 0.98em;
            padding: 8px 2px;
        }
    }
    </style>
</head>

<body>
    <div class="history-box">
        <h2 class="order-title">
            <span class="order-icon">📦</span> Lịch sử đơn hàng của bạn
        </h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message success">
                ✅ <?php echo htmlspecialchars($_SESSION['message']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="message error">
                ❌ <?php echo htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <table class="order-table">
            <tr>
                <th>ID</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
            <?php foreach($orders as $order): ?>
            <tr class="order-row <?php echo $order['status']; ?>">
                <td><span class="order-id">#<?php echo $order['id']; ?></span></td>
                <td><?php echo $order['created_at']; ?></td>
                <td><span class="order-total"><?php echo number_format($order['total_amount'] ?? 0, 0, ',', '.'); ?> đ</span></td>
                <td class="status">
                    <?php 
                    $status_text = '';
                    $status_class = '';
                    switch($order['status']) {
                        case 'pending':
                            $status_text = 'Chờ xử lý';
                            $status_class = 'pending';
                            break;
                        case 'processing':
                            $status_text = 'Đang xử lý';
                            $status_class = 'shipping';
                            break;
                        case 'shipped':
                            $status_text = 'Đang giao';
                            $status_class = 'shipping';
                            break;
                        case 'delivered':
                            $status_text = 'Đã giao';
                            $status_class = 'completed';
                            break;
                        case 'cancelled':
                            $status_text = 'Đã hủy';
                            $status_class = 'canceled';
                            break;
                        default:
                            $status_text = ucfirst($order['status']);
                            $status_class = 'pending';
                    }
                    ?>
                    <span class="status-badge status-<?php echo $status_class; ?>">
                        <?php echo $status_text; ?>
                    </span>
                </td>
                <td>
                    <?php 
                    // Define deletable statuses
                    $deletable_statuses = ['pending', 'cancelled'];
                    if (in_array($order['status'], $deletable_statuses)): 
                    ?>
                    <a href="?act=order_history&delete=<?php echo $order['id']; ?>"
                        onclick="return confirm('Bạn chắc chắn muốn xóa đơn hàng #<?php echo $order['id']; ?>?\n\nTrạng thái: <?php echo $status_text; ?>\n\nLưu ý: Hành động này không thể hoàn tác!');" 
                        class="btn-delete">🗑️ Xóa</a>
                    <?php else: ?>
                    <span class="no-action" title="Chỉ có thể xóa đơn hàng đang chờ xử lý hoặc đã hủy">Không thể xóa</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($orders)): ?><tr>
                <td colspan="5" class="no-order">Bạn chưa có đơn hàng nào.</td>
            </tr><?php endif; ?>
        </table>
        <div class="order-back"><a href="/mvc-oop-basic-duanmau/?act=products">&lt; Tiếp tục mua sắm</a></div>
    </div>
</body>

</html>