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
    <title>Admin Dashboard - Quản lý bán hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .dashboard {
        max-width: 600px;
        margin: 60px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
        padding: 40px 32px 32px 32px;
    }

    h2 {
        text-align: center;
        color: #007bff;
        margin-bottom: 16px;
    }

    .welcome {
        text-align: center;
        color: #666;
        margin-bottom: 32px;
        font-size: 16px;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #f8f9fa;
        padding: 16px;
        border-radius: 8px;
        text-align: center;
        border-left: 4px solid #007bff;
    }

    .stat-number {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }

    .stat-label {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }

    .admin-btns {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .admin-btns a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px;
        background: #007bff;
        color: #fff;
        text-align: left;
        border-radius: 8px;
        text-decoration: none;
        font-size: 20px;
        font-weight: 500;
        box-shadow: 0 2px 8px #cce3ff;
        transition: background 0.2s;
    }

    .admin-btns a:hover {
        background: #0056b3;
    }

    .logout-btn {
        background: #dc3545 !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3) !important;
    }

    .logout-btn:hover {
        background: #c82333 !important;
    }

    .back-link {
        margin-top: 32px;
        text-align: center;
    }

    .back-link a {
        color: #555;
        text-decoration: underline;
        font-size: 16px;
    }

    .admin-btns i {
        font-size: 22px;
    }
    </style>
</head>

<body>
    <div class="dashboard">
        <h2><i class="fa-solid fa-gauge-high"></i> Admin Dashboard</h2>
        <div class="welcome">
            Chào mừng, <strong><?= htmlspecialchars($_SESSION['admin']['username'] ?? 'Admin') ?></strong>!
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($orders ?? []) ?></div>
                <div class="stat-label">Đơn hàng</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $totalRevenue = 0;
                    if (!empty($orders)) {
                        foreach ($orders as $order) {
                            $totalRevenue += $order['total_amount'] ?? 0;
                        }
                    }
                    echo number_format($totalRevenue / 1000000, 1);
                    ?>M
                </div>
                <div class="stat-label">Doanh thu (VNĐ)</div>
            </div>
        </div>

        <div class="admin-btns">
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=list"><i
                    class="fa-solid fa-list"></i> Quản lý danh mục</a>
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list"><i
                    class="fa-solid fa-box"></i> Quản lý sản phẩm</a>
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=order&action=list"><i
                    class="fa-solid fa-file-invoice"></i> Quản lý đơn hàng</a>
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list"><i
                    class="fa-solid fa-users"></i> Quản lý người dùng</a>
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=review&action=list"><i
                    class="fa-solid fa-star"></i> Quản lý đánh giá</a>
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=admin&action=register"><i
                    class="fa-solid fa-user-plus"></i> Đăng ký quản trị viên</a>
            <a href="/mvc-oop-basic-duanmau/index.php"><i class="fa-solid fa-house"></i> Về trang người dùng</a>
            <a href="/mvc-oop-basic-duanmau/?act=logout" class="logout-btn"><i class="fa-solid fa-sign-out-alt"></i> Đăng xuất</a>
        </div>
    </div>
</body>

</html>