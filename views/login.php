<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <style>
    body {
        background: #f7f7f7;
        font-family: 'Quicksand', Arial, sans-serif;
    }

    .login-main {
        min-height: 100vh;
        display: flex;
        align-items: stretch;
        justify-content: center;
        position: relative;
    }

    .login-back {
        position: absolute;
        left: 32px;
        top: 32px;
        z-index: 10;
    }

    .login-back a {
        display: flex;
        align-items: center;
        color: #2d36b6;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.08em;
        gap: 6px;
    }

    .login-back a span {
        font-size: 1.5em;
        line-height: 1;
    }

    .login-left {
        flex: 1 1 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 320px;
        min-height: 400px;
    }

    .login-left img {
        width: 100%;
        height: 800px;
        max-width: 600px;
        border-radius: 18px;
        box-shadow: 0 4px 24px #b0c4de;
        object-fit: cover;
    }

    .login-right {
        flex: 1 1 50%;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 48px 36px 36px 36px;
        min-width: 340px;
        box-shadow: 0 4px 24px #b0c4de;
    }

    .login-title {
        font-size: 2em;
        font-weight: 700;
        color: #222;
        margin-bottom: 18px;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .login-form input[type="text"],
    .login-form input[type="password"] {
        padding: 12px 14px;
        border: 1.5px solid #b0c4de;
        border-radius: 8px;
        font-size: 1.08em;
        background: #f7f7f7;
        outline: none;
        transition: border 0.2s;
    }

    .login-form input:focus {
        border: 1.5px solid #217dbb;
    }

    .login-form button {
        background: #2d36b6;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 0;
        font-size: 1.1em;
        font-weight: 700;
        cursor: pointer;
        margin-top: 8px;
        transition: background 0.2s;
    }

    .login-form button:hover {
        background: #1a237e;
    }

    .login-social {
        margin: 18px 0 10px 0;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .login-social button {
        background: #fff;
        border: 1.5px solid #b0c4de;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 1.1em;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: box-shadow 0.2s;
    }

    .login-social button:hover {
        box-shadow: 0 2px 8px #b0c4de;
    }

    .login-register-link {
        margin-top: 18px;
        color: #222;
        font-size: 1em;
    }

    .login-register-link a {
        color: #2d36b6;
        text-decoration: underline;
    }

    .login-benefit {
        margin-top: 24px;
        color: #444;
        font-size: 0.98em;
    }

    .login-benefit ul {
        margin: 8px 0 0 18px;
    }

    .error {
        color: #e74c3c;
        text-align: center;
        margin-bottom: 10px;
    }

    @media (max-width: 900px) {
        .login-main {
            flex-direction: column;
        }

        .login-left,
        .login-right {
            min-width: 100vw;
        }

        .login-left img {
            width: 100vw;
            max-width: 100vw;
            border-radius: 0;
        }

        .login-right {
            box-shadow: none;
        }
    }
    </style>
</head>

<body>
    <div class="login-main">
        <div class="login-back">
            <a href="?act=home" title="Về trang chủ">
                <span style="font-size:1.7em;line-height:1;display:flex;align-items:center;">
                    <!-- icon ngôi nhà SVG -->
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        style="display:inline-block;vertical-align:middle;">
                        <path d="M3 10.75L12 4L21 10.75" stroke="#2d36b6" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M5 10V20C5 20.5523 5.44772 21 6 21H18C18.5523 21 19 20.5523 19 20V10" stroke="#2d36b6"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="login-left">
            <img src="uploads/imgproduct/loginbanner.jpg" alt="Login Banner">
        </div>
        <div class="login-right">
            <div class="login-title">Đăng nhập</div>
            <?php if(!empty($error)) echo '<div class="error">'.$error.'</div>'; ?>
            <form class="login-form" method="post">
                <input type="text" name="username" placeholder="Email hoặc tên đăng nhập" required>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <button type="submit">Tiếp</button>
            </form>
            <div class="login-register-link">
                Bạn chưa có tài khoản? <a href="?act=register">Đăng ký ngay!</a>
            </div>
            <div class="login-benefit">
                <b>Đăng nhập để luôn nắm bắt thông tin mới nhất:</b>
                <ul>
                    <li>Tham gia chương trình tích điểm miễn phí</li>
                    <li>Chương trình giảm giá và ưu đãi độc quyền</li>
                    <li>365 ngày đổi trả miễn phí với sản phẩm</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>