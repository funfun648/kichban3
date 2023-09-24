<?php
session_start();
include('conn2.php');
// Kiểm tra xem người dùng đã đăng nhập chưa
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     echo "Bạn không có quyền truy cập.";
//     echo "<a href='login.php'>Quay lại trang đăng nhập</a>";
//     exit();
// }

// if ($_SESSION['role'] !== 1) {
//     echo "Bạn không có quyền truy cập.";
//     echo "<a href='login.php'>Quay lại trang đăng nhập</a>";
//     exit();
// }
// Xử lý khi có yêu cầu POST để thêm sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image_path = $_POST['product_image_path'];

    // Kiểm tra giá sản phẩm có lớn hơn 0 không
    // if ($product_price <= 0) {
    //     echo "<script>alert('sản phẩm phải lớn hơn 0')</script>";
    // } else {
        // Thêm sản phẩm mới vào cơ sở dữ liệu
        $insert_query = "INSERT INTO products (tenmathang, gia, image_path) VALUES ('$product_name', $product_price, '$product_image_path')";

        if ($conn->query($insert_query) === TRUE) {
            echo "<script>alert('Thêm sản phẩm mới thành công!')</script>";
        } else {
            echo "<script>alert('Có lỗi sảy ra khi thêm sản phẩm')</script>" . $conn->error;
        }
    //}
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <link rel="stylesheet" href="./css/manager.css">
</head>

<body>
    <div class="container">
        <form id="contact" method="POST">
        <h3>Xin chào quản trị viên! </h3>
        <a href="user.php?uID=<?php echo $_SESSION['user_id']; ?>">Trở lại trang người dùng</a>
        <h4> Thêm sản phẩm mới:</h4>
            <fieldset>
                <label for="product_name">Tên sản phẩm:</label>
                <input placeholder="Tên sản phẩm" type="text" id="product_name" name="product_name" tabindex="1" equired autofocus ><br><br>
            </fieldset>

            <fieldset>
                <label for="product_price">Giá sản phẩm:</label>
                <input placeholder="Giá sản phẩm" type="number" id="product_price" name="product_price" tabindex="2" equired><br><br>
            </fieldset>
            <fieldset>
                <label for="product_image_path">Đường dẫn hình ảnh:</label>
                <input type="text" id="product_image_path" name="product_image_path" tabindex="3" equired><br><br>
            </fieldset>

            <fieldset>
                <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
        </form>
    </div>
</body>

</html>