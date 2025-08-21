<?php
class User {
    // ...existing properties and methods...

    public function register($data) {
        // Gán role là admin khi đăng ký từ trang quản trị viên
        $data['role'] = 'admin';

        // ...existing code to save to database...
    }

    // ...existing methods...
}
?>