<?php
session_start();
include('conn2.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Thực hiện truy vấn để kiểm tra thông tin đăng nhập
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_role'] = $row['role']; // Lưu vai trò của người dùng vào phiên làm việc
        header("Location: user.php?uID=" . $row['id']);
    } else {
        echo "Thông tin đăng nhập không đúng.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="POST" action="login.php">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html>

