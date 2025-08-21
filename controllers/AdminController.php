<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../commons/session.php';

class AdminController {
    public function register() {
        require_once __DIR__ . '/../models/AdminModel.php';
        $adminModel = new AdminModel();
        $userModel = new UserModel();

        safe_session_start();
        $message = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            
            // Validation
            if (empty($username) || empty($password) || empty($email) || empty($phone)) {
                $message = '❌ Vui lòng nhập đầy đủ thông tin!';
            } elseif (strlen($username) < 3) {
                $message = '❌ Tên đăng nhập phải có ít nhất 3 ký tự!';
            } elseif (strlen($password) < 6) {
                $message = '❌ Mật khẩu phải có ít nhất 6 ký tự!';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = '❌ Email không hợp lệ!';
            } elseif (!preg_match('/^[0-9]{9,12}$/', $phone)) {
                $message = '❌ Số điện thoại phải có 9-12 chữ số!';
            } elseif ($adminModel::exists($username)) {
                $message = '❌ Tên đăng nhập đã tồn tại trong hệ thống quản trị!';
            } else {
                // Kiểm tra email đã tồn tại chưa
                $existingUser = $userModel->getUserByEmail($email);
                if ($existingUser) {
                    $message = '❌ Email đã được sử dụng bởi tài khoản khác!';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Đăng ký vào bảng admins
                    if ($adminModel::register($username, $hashedPassword, $email, $phone)) {
                        // Xóa user cũ nếu đã tồn tại trong bảng users
                        $user = $userModel->getUserByUsername($username);
                        if ($user) {
                            $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
                            $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $stmt->close();
                            $conn->close();
                        }
                        
                        // Đăng ký lại user với role admin
                        $userResult = $userModel->register($username, $hashedPassword, 'admin');
                        
                        if ($userResult) {
                            set_session_message('success', '✅ Đăng ký tài khoản admin thành công! Bạn có thể đăng nhập ngay bây giờ.', 'admin_register_success');
                            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=admin&action=register');
                            exit;
                        } else {
                            $message = '❌ Lỗi khi tạo tài khoản user! Vui lòng thử lại.';
                        }
                    } else {
                        $message = '❌ Lỗi khi đăng ký vào hệ thống quản trị! Vui lòng thử lại.';
                    }
                }
            }
        }
        
        require_once dirname(__DIR__) . '/Admin/Views/AdminRegisterForm.php';
    }
    public function login() {
        // Hiển thị form đăng nhập admin hoặc xử lý đăng nhập
        // Nếu đã đăng nhập admin thì chuyển hướng về dashboard
        if (isset($_SESSION['admin'])) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php');
            exit;
        }
        require_once dirname(__DIR__) . '/Admin/Views/AdminLoginForm.php';
    }

    public function dashboard() {
        // Hiển thị dashboard admin, truyền dữ liệu đơn hàng
        require_once dirname(__DIR__) . '/models/OrderModel.php';
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();
        require_once dirname(__DIR__) . '/Admin/Views/AdminDashboard.php';
    }
}