<?php
session_start();
include('conn2.php');

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== '1') {
    header("Location: login.php");
    exit;
}
// Xử lý khi có yêu cầu POST để thêm sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image_path = $_POST['product_image_path'];

    $insert_query = "INSERT INTO products (tenmathang, gia, image_path) VALUES ('$product_name', $product_price, '$product_image_path')";
    
    if ($conn->query($insert_query) === TRUE) {
        echo "Thêm sản phẩm mới thành công!";
    } else {
        echo "Có lỗi xảy ra khi thêm sản phẩm mới: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang Quản Trị</title>
</head>
<body>
    <h2>Xin chào quản trị viên!</h2>
    <h3>Thêm sản phẩm mới:</h3>
    <form method="POST">
        <label for="product_name">Tên sản phẩm:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_price">Giá sản phẩm:</label>
        <input type="number" id="product_price" name="product_price" required><br><br>

        <label for="product_image_path">Đường dẫn hình ảnh:</label>
        <input type="text" id="product_image_path" name="product_image_path" required><br><br>

        <input type="submit" value="Thêm sản phẩm">
    </form>
</body>
</html>
