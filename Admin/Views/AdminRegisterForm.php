<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản quản trị</title>
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
        max-width: 400px;
        margin: 60px auto;
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

    form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    label {
        font-size: 16px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    button {
        padding: 14px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    button:hover {
        background: #0056b3;
    }

    .message {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
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
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-user-plus"></i> Đăng ký tài khoản quản trị</h2>
        
        <?php
        // Hiển thị thông báo từ session
        if (function_exists('get_session_message')) {
            $successMessage = get_session_message('admin_register_success');
            if ($successMessage) {
                echo '<div class="message success">';
                echo '<i class="fa-solid fa-check-circle icon"></i>';
                echo htmlspecialchars($successMessage);
                echo '</div>';
            }
        }
        ?>
        
        <?php if (!empty($message)) : ?>
        <div class="message error">
            <i class="fa-solid fa-exclamation-triangle icon"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        <form method="post">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" id="username" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" id="phone" required pattern="[0-9]{9,12}" title="Nhập số điện thoại hợp lệ">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit"><i class="fa-solid fa-check"></i> Đăng ký</button>
        </form>
        
        <!-- Floating Dashboard Button -->
        <a href="/mvc-oop-basic-duanmau/Admin/index.php" class="floating-dashboard" title="Về Dashboard Admin">
            <i class="fa-solid fa-home"></i>
        </a>
    </div>
</body>

</html>