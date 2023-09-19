<?php
$servername = "localhost"; // Thay đổi thành thông tin của máy chủ MySQL của bạn
$username = "root"; // Thay đổi thành tên người dùng của bạn
$password = ""; // Thay đổi thành mật khẩu của bạn
$database = "info_user"; // Thay đổi thành tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}
?>
