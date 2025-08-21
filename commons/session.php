<?php
/**
 * Session Management Utility
 * Đảm bảo session được start một cách an toàn
 */

/**
 * Start session an toàn - chỉ start nếu chưa có session
 */
function safe_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Set session message với key tự động
 */
function set_session_message($type, $message, $key = null) {
    safe_session_start();
    
    if ($key === null) {
        $key = $type . '_message';
    }
    
    $_SESSION[$key] = $message;
}

/**
 * Get và xóa session message
 */
function get_session_message($key, $remove = true) {
    safe_session_start();
    
    if (isset($_SESSION[$key])) {
        $message = $_SESSION[$key];
        if ($remove) {
            unset($_SESSION[$key]);
        }
        return $message;
    }
    
    return null;
}

/**
 * Kiểm tra user đã đăng nhập chưa
 */
function is_logged_in() {
    safe_session_start();
    return isset($_SESSION['user']);
}

/**
 * Kiểm tra admin đã đăng nhập chưa
 */
function is_admin_logged_in() {
    safe_session_start();
    return isset($_SESSION['admin']);
}

/**
 * Get current user info
 */
function get_current_session_user() {
    safe_session_start();
    return $_SESSION['user'] ?? null;
}

/**
 * Get current admin info
 */
function get_current_admin() {
    safe_session_start();
    return $_SESSION['admin'] ?? null;
}

/**
 * Logout user
 */
function logout_user() {
    safe_session_start();
    unset($_SESSION['user']);
}

/**
 * Logout admin
 */
function logout_admin() {
    safe_session_start();
    unset($_SESSION['admin']);
}

/**
 * Destroy toàn bộ session
 */
function destroy_session() {
    safe_session_start();
    session_destroy();
}
?>
