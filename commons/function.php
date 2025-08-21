<?php
// Thêm dòng này vào đầu file (ngay sau <?php nếu có)
require_once __DIR__ . '/env.php';

// Luôn hiển thị lỗi PHP ra màn hình để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kết nối CSDL qua PDO
function connectDB() {
    
    if (!defined('DB_HOST')) {
        require_once __DIR__ . '/env.php';
    }
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
        return $conn;
    } catch (PDOException $e) {
        echo ("Connection failed: " . $e->getMessage());
    }
}

function connectDBi() {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        die('Kết nối database thất bại: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    return $conn;
}

function uploadFile($file, $folderSave){
    $file_upload = $file;
    $pathStorage = $folderSave . rand(10000, 99999) . $file_upload['name'];

    $tmp_file = $file_upload['tmp_name'];
    $pathSave = PATH_ROOT . $pathStorage; // Đường dãn tuyệt đối của file

    if (move_uploaded_file($tmp_file, $pathSave)) {
        return $pathStorage;
    }
    return null;
}

function deleteFile($file){
    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete); // Hàm unlink dùng để xóa file
    }
}

/**
 * Format currency safely - handle null values
 */
function safe_number_format($number, $decimals = 0, $decimal_separator = '.', $thousands_separator = ',') {
    return number_format($number ?? 0, $decimals, $decimal_separator, $thousands_separator);
}

/**
 * Format price in Vietnamese dong
 */
function format_price($price) {
    return safe_number_format($price, 0, ',', '.') . ' đ';
}

/**
 * Format price short (for display)
 */
function format_price_short($price) {
    return safe_number_format($price) . 'đ';
}