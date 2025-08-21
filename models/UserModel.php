<?php
class UserModel {
    // Kết nối database (giả sử bạn đã có $conn)
    private $conn;

    public function __construct() {
        // Sử dụng hằng số từ commons/env.php để kết nối đúng database cấu hình
        require_once __DIR__ . '/../commons/env.php';
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
        if ($this->conn->connect_error) {
            die('Kết nối database thất bại: ' . $this->conn->connect_error);
        }

        // Tự động thêm cột role nếu chưa có
        $result = $this->conn->query("SHOW COLUMNS FROM users LIKE 'role'");
        if ($result && $result->num_rows == 0) {
            $this->conn->query("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user'");
        }
    }

    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function register($username, $password, $role = 'user') {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role, email, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $role, $email, $phone);
        return $stmt->execute();
    }
    
    // === ADMIN USER MANAGEMENT METHODS ===
    
    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT id, username, email, phone, role, created_at FROM users ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function addUser($username, $password, $email, $phone, $role) {
        // Kiểm tra username hoặc email đã tồn tại
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return 'exists';
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Thêm user mới
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $hashedPassword, $email, $phone, $role);
        return $stmt->execute();
    }
    
    public function updateUser($id, $username, $email, $phone, $role, $password = '') {
        if (!empty($password)) {
            // Cập nhật với password mới
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, phone = ?, role = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $username, $email, $phone, $role, $hashedPassword, $id);
        } else {
            // Cập nhật không thay đổi password
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, phone = ?, role = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $username, $email, $phone, $role, $id);
        }
        return $stmt->execute();
    }
    
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function searchUsers($keyword) {
        $searchTerm = '%' . $keyword . '%';
        $stmt = $this->conn->prepare("SELECT id, username, email, phone, role, created_at FROM users WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? ORDER BY id DESC");
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, username, email, phone, role, created_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function toggleUserStatus($id) {
        
        $result = $this->conn->query("SHOW COLUMNS FROM users LIKE 'status'");
        if ($result && $result->num_rows == 0) {
            $this->conn->query("ALTER TABLE users ADD COLUMN status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'");
        }
        
        // Toggle status
        $stmt = $this->conn->prepare("UPDATE users SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}