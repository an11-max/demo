<?php
class AuthController {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }
    public function Login() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = $user;
                    // Nếu là tài khoản có role admin thì set session admin và chuyển sang giao diện admin dashboard đẹp
                    if (isset($user['role']) && $user['role'] === 'admin') {
                        $_SESSION['admin'] = true;
                        header('Location: /mvc-oop-basic-duanmau/admin'); exit;
                    } else {
                        header('Location: /mvc-oop-basic-duanmau/'); exit;
                    }
                } else {
                    $error = 'Sai mật khẩu!';
                }
            } else {
                $error = 'Tài khoản không tồn tại!';
            }
        }
        require './views/login.php';
    }
    public function Register() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            if ($password !== $password2) {
                $error = 'Mật khẩu nhập lại không khớp!';
            } else {
                $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = :username");
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->fetch()) {
                    $error = 'Tên đăng nhập đã tồn tại!';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, phone) VALUES (:username, :password, :email, :phone)");
                    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        header('Location: /mvc-oop-basic-duanmau/?act=login'); exit;
                    } else {
                        $error = 'Lỗi đăng ký!';
                    }
                }
            }
        }
        require './views/register.php';
    }
    public function Logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['user']);
        header('Location: /mvc-oop-basic-duanmau/?act=login'); exit;
    }
}