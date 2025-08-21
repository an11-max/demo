<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Kiểm tra quyền admin
if (!isset($_SESSION['admin'])) {
    header('Location: /mvc-oop-basic-duanmau/?act=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: #f7f7f7;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    /* Floating Dashboard Button */
    .floating-dashboard {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        background: #007bff;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        transition: all 0.3s ease;
        font-size: 24px;
    }

    .floating-dashboard:hover {
        background: #0056b3;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        color: white;
        text-decoration: none;
    }

    .floating-dashboard:active {
        transform: scale(0.95);
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px #ccc;
        padding: 32px;
    }

    h2 {
        text-align: center;
        color: #007bff;
        margin-bottom: 24px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
        overflow-x: auto;
        display: block;
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        table {
            display: table;
            white-space: normal;
        }
    }

    th,
    td {
        padding: 12px 8px;
        border-bottom: 1px solid #eee;
        text-align: left;
        min-width: 80px;
    }

    th:first-child,
    td:first-child {
        min-width: 40px;
    }

    th:nth-child(5),
    td:nth-child(5) {
        min-width: 200px;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    th {
        background: #e9f2fb;
        color: #007bff;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-processing {
        background: #cce5ff;
        color: #004085;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-shipped {
        background: #d4edda;
        color: #155724;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-delivered {
        background: #d1ecf1;
        color: #0c5460;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Delete Button Styles */
    .btn-delete {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: scale(1.05);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        color: #dc3545;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .modal-body {
        margin-bottom: 20px;
        color: #666;
    }

    .modal-footer {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn-confirm {
        background: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-confirm:hover {
        background: #c82333;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .back-link {
        text-align: center;
        margin-top: 24px;
    }

    .back-link a {
        color: #555;
        text-decoration: underline;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-file-invoice"></i> Quản lý đơn hàng</h2>
        
        <!-- Hiển thị thông báo -->
        <?php if (isset($_SESSION['admin_message'])): ?>
        <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
            <?= $_SESSION['admin_message'] ?>
        </div>
        <?php unset($_SESSION['admin_message']); endif; ?>
        
        <?php if (isset($_SESSION['admin_error'])): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #f5c6cb;">
            <?= $_SESSION['admin_error'] ?>
        </div>
        <?php unset($_SESSION['admin_error']); endif; ?>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thời gian</th>
                <th>Thao tác</th>
            </tr>
            <?php if (!empty($orders) && is_array($orders)): ?>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['customer_name'] ?? $order['username'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($order['customer_email'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($order['customer_phone'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($order['shipping_address'] ?? 'N/A') ?></td>
                <td><?= number_format($order['total_amount'] ?? 0) ?>₫</td>
                <td>
                    <span class="status-<?= $order['status'] ?? 'pending' ?>">
                        <?= ucfirst($order['status'] ?? 'pending') ?>
                    </span>
                </td>
                <td><?= $order['created_at'] ?? '' ?></td>
                <td>
                    <button class="btn-delete" onclick="confirmDelete(<?= $order['id'] ?>)" title="Xóa đơn hàng">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;color:#888;">Không có đơn hàng nào.</td>
            </tr>
            <?php endif; ?>
        </table>
        
        <!-- Floating Dashboard Button -->
        <a href="/mvc-oop-basic-duanmau/Admin/index.php" class="floating-dashboard" title="Về Dashboard Admin">
            <i class="fa-solid fa-home"></i>
        </a>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa-solid fa-triangle-exclamation"></i> Xác nhận xóa
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa đơn hàng #<span id="orderIdToDelete"></span>?<br>
                <strong>Hành động này không thể hoàn tác!</strong>
            </div>
            <div class="modal-footer">
                <button class="btn-confirm" onclick="deleteOrder()">
                    <i class="fa-solid fa-trash"></i> Xóa
                </button>
                <button class="btn-cancel" onclick="closeModal()">
                    <i class="fa-solid fa-times"></i> Hủy
                </button>
            </div>
        </div>
    </div>

    <script>
        let orderIdToDelete = null;

        function confirmDelete(orderId) {
            orderIdToDelete = orderId;
            document.getElementById('orderIdToDelete').textContent = orderId;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
            orderIdToDelete = null;
        }

        function deleteOrder() {
            if (orderIdToDelete) {
                console.log('Deleting order ID:', orderIdToDelete);
                
                // Tạo form ẩn để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/mvc-oop-basic-duanmau/Admin/index.php?controller=order&action=delete';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order_id';
                input.value = orderIdToDelete;
                
                form.appendChild(input);
                document.body.appendChild(form);
                
                console.log('Form action:', form.action);
                console.log('Form method:', form.method);
                console.log('Order ID:', input.value);
                
                form.submit();
            }
        }

        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>