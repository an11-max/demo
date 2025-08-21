<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
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
        max-width: 1100px;
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

    .search-form {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .search-form input {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .search-form button {
        padding: 12px 24px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    .search-form button:hover {
        background: #0056b3;
    }

    .add-btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: #28a745;
        color: #fff;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 24px;
        transition: background 0.2s;
    }

    .add-btn:hover {
        background: #218838;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    th {
        background: #e9f2fb;
        color: #007bff;
        font-weight: 600;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .role-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-admin {
        background: #dc3545;
        color: white;
    }

    .role-user {
        background: #28a745;
        color: white;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active {
        background: #28a745;
        color: white;
    }

    .status-inactive {
        background: #6c757d;
        color: white;
    }

    .message {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
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

    .message .icon {
        margin-right: 8px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(45deg, #007bff, #0056b3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-users"></i> Quản lý người dùng</h2>

        <?php
        // Hiển thị thông báo
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['user_add_success'])) {
            echo '<div class="message success">';
            echo '<i class="fa-solid fa-check-circle icon"></i>';
            echo htmlspecialchars($_SESSION['user_add_success']);
            echo '</div>';
            unset($_SESSION['user_add_success']);
        }
        
        if (isset($_SESSION['user_add_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['user_add_error']);
            echo '</div>';
            unset($_SESSION['user_add_error']);
        }
        
        if (isset($_SESSION['user_edit_success'])) {
            echo '<div class="message success">';
            echo '<i class="fa-solid fa-check-circle icon"></i>';
            echo htmlspecialchars($_SESSION['user_edit_success']);
            echo '</div>';
            unset($_SESSION['user_edit_success']);
        }
        
        if (isset($_SESSION['user_edit_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['user_edit_error']);
            echo '</div>';
            unset($_SESSION['user_edit_error']);
        }
        
        if (isset($_SESSION['user_delete_success'])) {
            echo '<div class="message success">';
            echo '<i class="fa-solid fa-check-circle icon"></i>';
            echo htmlspecialchars($_SESSION['user_delete_success']);
            echo '</div>';
            unset($_SESSION['user_delete_success']);
        }
        
        if (isset($_SESSION['user_delete_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['user_delete_error']);
            echo '</div>';
            unset($_SESSION['user_delete_error']);
        }
        
        if (isset($_SESSION['user_status_success'])) {
            echo '<div class="message success">';
            echo '<i class="fa-solid fa-check-circle icon"></i>';
            echo htmlspecialchars($_SESSION['user_status_success']);
            echo '</div>';
            unset($_SESSION['user_status_success']);
        }
        
        if (isset($_SESSION['user_status_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['user_status_error']);
            echo '</div>';
            unset($_SESSION['user_status_error']);
        }
        ?>

        <form class="search-form" method="get" action="/mvc-oop-basic-duanmau/Admin/index.php">
            <input type="hidden" name="controller" value="user">
            <input type="hidden" name="action" value="search">
            <input type="text" name="keyword" placeholder="Tìm kiếm theo username, email, phone..." 
                   value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit"><i class="fa-solid fa-search"></i> Tìm kiếm</button>
        </form>

        <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=add" class="add-btn">
            <i class="fa-solid fa-user-plus"></i> Thêm người dùng
        </a>

        <table>
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Status</th>
                <th>Ngày tạo</th>
            </tr>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <div class="user-avatar">
                            <?= strtoupper(substr($user['username'], 0, 1)) ?>
                        </div>
                    </td>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone'] ?? 'N/A') ?></td>
                    <td>
                        <span class="role-badge role-<?= $user['role'] ?>">
                            <?= $user['role'] === 'admin' ? 'Admin' : 'User' ?>
                        </span>
                    </td>
                    <td>
                        <?php 
                        $status = $user['status'] ?? 'active';
                        $statusText = $status === 'active' ? 'Hoạt động' : 'Vô hiệu hóa';
                        ?>
                        <span class="status-badge status-<?= $status ?>">
                            <?= $statusText ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #888; padding: 40px;">
                        <i class="fa-solid fa-users" style="font-size: 48px; margin-bottom: 16px; color: #ddd;"></i><br>
                        Không có người dùng nào!
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- Floating Dashboard Button -->
        <a href="/mvc-oop-basic-duanmau/Admin/index.php" class="floating-dashboard" title="Về Dashboard Admin">
            <i class="fa-solid fa-home"></i>
        </a>
    </div>
</body>

</html>
