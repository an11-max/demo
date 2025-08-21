<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập quản trị viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: #e0eafc;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .login-box {
        max-width: 400px;
        margin: 80px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px #cce3ff;
        padding: 32px;
    }

    h2 {
        text-align: center;
        color: #007bff;
        margin-bottom: 24px;
    }

    label {
        font-weight: 500;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 8px 0 16px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .back-link {
        margin-top: 18px;
        text-align: center;
    }

    .back-link a {
        color: #555;
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="login-box">
        <h2><i class="fa-solid fa-user-shield"></i> Đăng nhập quản trị viên</h2>
        <form method="post" action="/mvc-oop-basic-duanmau/Admin/index.php?controller=admin&action=login">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <div class="back-link">
            <a href="/mvc-oop-basic-duanmau/index.php">Quay về trang người dùng</a>
        </div>
    </div>
</body>

</html>