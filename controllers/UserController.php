<?php
require_once __DIR__ . '/../commons/session.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $model;
    
    public function __construct() {
        $this->model = new UserModel();
    }

    public function login() {
        // Lấy dữ liệu từ form
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = new UserModel();
        $user = $userModel->getUserByUsername($username); // Sử dụng hàm từ model để lấy thông tin người dùng

        // Kiểm tra đăng nhập
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            // Chuyển hướng tất cả tài khoản về trang admin
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php');
            exit;
        } else {
            // Xử lý đăng nhập thất bại
            $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
            include 'Views/login.php'; // Giả sử bạn có file login.php để hiển thị form đăng nhập
        }
    }
    
    // === ADMIN USER MANAGEMENT METHODS ===
    
    public function list() {
        $users = $this->model->getAllUsers();
        require_once dirname(__DIR__) . '/Admin/Views/UserList.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $role = $_POST['role'] ?? 'user';
            
            if (!empty($username) && !empty($password) && !empty($email)) {
                $result = $this->model->addUser($username, $password, $email, $phone, $role);
                
                if ($result === true) {
                    set_session_message('success', "Đã thêm người dùng '{$username}' thành công!", 'user_add_success');
                } elseif ($result === 'exists') {
                    set_session_message('error', "Username hoặc email đã tồn tại!", 'user_add_error');
                } else {
                    set_session_message('error', "Có lỗi xảy ra khi thêm người dùng!", 'user_add_error');
                }
                
                header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list');
                exit;
            } else {
                set_session_message('error', "Vui lòng điền đầy đủ thông tin bắt buộc!", 'user_add_error');
            }
        }
        require_once dirname(__DIR__) . '/Admin/Views/UserAddForm.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $password = $_POST['password'] ?? '';
            
            if (!empty($username) && !empty($email)) {
                $result = $this->model->updateUser($id, $username, $email, $phone, $role, $password);
                
                if ($result === true) {
                    set_session_message('success', "Đã cập nhật người dùng thành công!", 'user_edit_success');
                } else {
                    set_session_message('error', "Có lỗi xảy ra khi cập nhật người dùng!", 'user_edit_error');
                }
                
                header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list');
                exit;
            } else {
                set_session_message('error', "Vui lòng điền đầy đủ thông tin bắt buộc!", 'user_edit_error');
            }
        }
        
        $user = $this->model->getUserById($id);
        if (!$user) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list');
            exit;
        }
        
        require_once dirname(__DIR__) . '/Admin/Views/UserEditForm.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $user = $this->model->getUserById($id);
            
            if ($user) {
                $result = $this->model->deleteUser($id);
                
                if ($result) {
                    set_session_message('success', "Đã xóa người dùng '{$user['username']}' thành công!", 'user_delete_success');
                } else {
                    set_session_message('error', "Có lỗi xảy ra khi xóa người dùng!", 'user_delete_error');
                }
            }
        }
        
        header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list');
        exit;
    }
    
    public function search() {
        $keyword = $_GET['keyword'] ?? '';
        $users = $this->model->searchUsers($keyword);
        require_once dirname(__DIR__) . '/Admin/Views/UserList.php';
    }
    
    public function toggleStatus() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $result = $this->model->toggleUserStatus($id);
            
            if ($result) {
                set_session_message('success', "Đã thay đổi trạng thái người dùng!", 'user_status_success');
            } else {
                set_session_message('error', "Có lỗi xảy ra khi thay đổi trạng thái!", 'user_status_error');
            }
        }
        
        header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=user&action=list');
        exit;
    }
}
?>