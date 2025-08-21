<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa người dùng</title>
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

    .user-info {
        background: #e9f2fb;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        border-left: 4px solid #007bff;
    }

    .user-info h4 {
        margin: 0 0 8px 0;
        color: #007bff;
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
        background: #007bff;
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
        background: #0056b3;
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

    .password-section {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
        background: #f8f9fa;
    }

    .password-section h4 {
        margin: 0 0 12px 0;
        color: #495057;
        font-size: 16px;
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

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
        margin-right: 8px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-user-edit"></i> Chỉnh sửa người dùng</h2>

        <?php
        // Hiển thị thông báo lỗi
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['user_edit_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['user_edit_error']);
            echo '</div>';
            unset($_SESSION['user_edit_error']);
        }
        ?>

        <div class="user-info">
            <h4><i class="fa-solid fa-info-circle"></i> Thông tin hiện tại</h4>
            <p><strong>ID:</strong> <?= $user['id'] ?></p>
            <p><strong>Ngày tạo:</strong> <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></p>
            <p><strong>Trạng thái:</strong> 
                <?php 
                $status = $user['status'] ?? 'active';
                $statusText = $status === 'active' ? 'Hoạt động' : 'Vô hiệu hóa';
                $statusColor = $status === 'active' ? '#28a745' : '#6c757d';
                ?>
                <span style="color: <?= $statusColor ?>; font-weight: bold;"><?= $statusText ?></span>
            </p>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" required maxlength="50"
                       value="<?= htmlspecialchars($user['username']) ?>">
                <div class="form-help">Username phải có ít nhất 3 ký tự</div>
            </div>

            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required
                       value="<?= htmlspecialchars($user['email']) ?>">
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="tel" id="phone" name="phone" maxlength="15"
                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="role">Quyền <span class="required">*</span></label>
                <select id="role" name="role" required>
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                        User - Người dùng thường
                    </option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                        Admin - Quản trị viên
                    </option>
                </select>
            </div>

            <div class="password-section">
                <h4><i class="fa-solid fa-lock"></i> Thay đổi mật khẩu</h4>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="change_password" onchange="togglePasswordFields()">
                    <label for="change_password">Tôi muốn thay đổi mật khẩu</label>
                </div>

                <div id="password-fields" style="display: none;">
                    <div class="form-group">
                        <label for="password">Mật khẩu mới</label>
                        <input type="password" id="password" name="password" minlength="6">
                        <div class="form-help">Để trống nếu không muốn thay đổi mật khẩu</div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu mới</label>
                        <input type="password" id="confirm_password" onkeyup="checkPasswordMatch()">
                        <div id="password-match" style="font-size: 14px; margin-top: 4px;"></div>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submit-btn">
                <i class="fa-solid fa-save"></i> Cập nhật người dùng
            </button>

            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list" class="cancel-btn">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
            </a>
        </form>
    </div>

    <script>
    function togglePasswordFields() {
        const checkbox = document.getElementById('change_password');
        const passwordFields = document.getElementById('password-fields');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        
        if (checkbox.checked) {
            passwordFields.style.display = 'block';
            passwordInput.required = true;
            confirmPasswordInput.required = true;
        } else {
            passwordFields.style.display = 'none';
            passwordInput.required = false;
            confirmPasswordInput.required = false;
            passwordInput.value = '';
            confirmPasswordInput.value = '';
            document.getElementById('password-match').innerHTML = '';
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
        const changePassword = document.getElementById('change_password').checked;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const submitBtn = document.getElementById('submit-btn');
        
        let isValid = username.length >= 3 && email.includes('@');
        
        if (changePassword) {
            isValid = isValid && password.length >= 6 && password === confirmPassword;
        }
        
        submitBtn.disabled = !isValid;
        submitBtn.style.opacity = isValid ? '1' : '0.6';
    }
    
    // Validate form khi nhập
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = ['username', 'email', 'password'];
        inputs.forEach(inputId => {
            const element = document.getElementById(inputId);
            if (element) {
                element.addEventListener('input', checkFormValidity);
            }
        });
        
        checkFormValidity(); // Check initial state
    });
    </script>
</body>

</html>
