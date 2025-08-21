<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: #f7f7f7;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .container {
        max-width: 600px;
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

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
    }

    .required {
        color: #dc3545;
    }

    .submit-btn {
        width: 100%;
        padding: 14px;
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        margin-bottom: 16px;
    }

    .submit-btn:hover {
        background: #218838;
    }

    .cancel-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background: #6c757d;
        color: #fff;
        border: none;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: background 0.2s;
    }

    .cancel-btn:hover {
        background: #545b62;
    }

    .form-help {
        font-size: 14px;
        color: #6c757d;
        margin-top: 4px;
    }

    .password-strength {
        margin-top: 8px;
        font-size: 14px;
    }

    .strength-weak {
        color: #dc3545;
    }

    .strength-medium {
        color: #ffc107;
    }

    .strength-strong {
        color: #28a745;
    }

    .message {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .message .icon {
        margin-right: 8px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-user-plus"></i> Thêm người dùng mới</h2>

        <?php
        // Hiển thị thông báo lỗi
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['user_add_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['user_add_error']);
            echo '</div>';
            unset($_SESSION['user_add_error']);
        }
        ?>

        <form method="post">
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" required maxlength="50"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                <div class="form-help">Username phải có ít nhất 3 ký tự và không chứa ký tự đặc biệt</div>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div class="form-help">Email sẽ được sử dụng để khôi phục mật khẩu</div>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" maxlength="15"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                <div class="form-help">Định dạng: 0123456789 hoặc +84123456789</div>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <input type="password" id="password" name="password" required minlength="6"
                       onkeyup="checkPasswordStrength(this.value)">
                <div id="password-strength" class="password-strength"></div>
                <div class="form-help">Mật khẩu phải có ít nhất 6 ký tự</div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu <span class="required">*</span></label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       onkeyup="checkPasswordMatch()">
                <div id="password-match" style="font-size: 14px; margin-top: 4px;"></div>
            </div>

            <div class="form-group">
                <label for="role">Quyền <span class="required">*</span></label>
                <select id="role" name="role" required>
                    <option value="user" <?= ($_POST['role'] ?? 'user') === 'user' ? 'selected' : '' ?>>
                        User - Người dùng thường
                    </option>
                    <option value="admin" <?= ($_POST['role'] ?? '') === 'admin' ? 'selected' : '' ?>>
                        Admin - Quản trị viên
                    </option>
                </select>
                <div class="form-help">Admin có quyền truy cập vào tất cả tính năng quản lý</div>
            </div>

            <button type="submit" class="submit-btn" id="submit-btn" disabled>
                <i class="fa-solid fa-user-plus"></i> Thêm người dùng
            </button>

            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list" class="cancel-btn">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
            </a>
        </form>
    </div>

    <script>
    function checkPasswordStrength(password) {
        const strengthDiv = document.getElementById('password-strength');
        const submitBtn = document.getElementById('submit-btn');
        
        if (password.length === 0) {
            strengthDiv.innerHTML = '';
            return;
        }
        
        let strength = 0;
        let feedback = [];
        
        // Kiểm tra độ dài
        if (password.length >= 8) strength += 1;
        else feedback.push('ít nhất 8 ký tự');
        
        // Kiểm tra chữ hoa
        if (/[A-Z]/.test(password)) strength += 1;
        else feedback.push('chữ hoa');
        
        // Kiểm tra chữ thường
        if (/[a-z]/.test(password)) strength += 1;
        else feedback.push('chữ thường');
        
        // Kiểm tra số
        if (/[0-9]/.test(password)) strength += 1;
        else feedback.push('số');
        
        // Kiểm tra ký tự đặc biệt
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        else feedback.push('ký tự đặc biệt');
        
        if (strength < 2) {
            strengthDiv.innerHTML = '<span class="strength-weak">❌ Yếu - Cần: ' + feedback.join(', ') + '</span>';
        } else if (strength < 4) {
            strengthDiv.innerHTML = '<span class="strength-medium">⚠️ Trung bình - Cần thêm: ' + feedback.join(', ') + '</span>';
        } else {
            strengthDiv.innerHTML = '<span class="strength-strong">✅ Mạnh - Mật khẩu tốt!</span>';
        }
        
        checkFormValidity();
    }
    
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const matchDiv = document.getElementById('password-match');
        
        if (confirmPassword.length === 0) {
            matchDiv.innerHTML = '';
            return;
        }
        
        if (password === confirmPassword) {
            matchDiv.innerHTML = '<span style="color: #28a745;">✅ Mật khẩu khớp</span>';
        } else {
            matchDiv.innerHTML = '<span style="color: #dc3545;">❌ Mật khẩu không khớp</span>';
        }
        
        checkFormValidity();
    }
    
    function checkFormValidity() {
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const submitBtn = document.getElementById('submit-btn');
        
        const isValid = username.length >= 3 && 
                       email.includes('@') && 
                       password.length >= 6 && 
                       password === confirmPassword;
        
        submitBtn.disabled = !isValid;
        submitBtn.style.opacity = isValid ? '1' : '0.6';
    }
    
    // Validate form khi nhập
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = ['username', 'email', 'password', 'confirm_password'];
        inputs.forEach(inputId => {
            document.getElementById(inputId).addEventListener('input', checkFormValidity);
        });
    });
    </script>
</body>

</html>
