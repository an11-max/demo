<?php
require_once __DIR__ . '/../commons/function.php';
class AdminModel {
    public static function register($username, $password, $email, $phone) {
        $conn = connectDBi();
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $sql = "INSERT INTO admins (username, password, email, phone) VALUES ('$username', '$password', '$email', '$phone')";
        return mysqli_query($conn, $sql);
    }
    public static function exists($username) {
        $conn = connectDBi();
        $username = mysqli_real_escape_string($conn, $username);
        $sql = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
}