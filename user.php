<?php
session_start();
require('conn2.php');

// Lấy giá trị uID từ URL
$uID = $_GET['uID'];

// Truy vấn cơ sở dữ liệu để lấy thông tin của người dùng dựa trên $uID
$query = "SELECT * FROM users WHERE id = $uID";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $user_info = $result->fetch_assoc();
    $user_id = $user_info['id'];
    $user_balance = $user_info['sotien'];

    // Hiển thị thông tin người dùng
    echo "Tên người dùng: " . $user_info['username'] . "<br>";
    echo "Số dư tài khoản của bạn: $" . $user_balance . "<br>";

    // Hiển thị sản phẩm và cho phép mua hàng
    $query = "SELECT * FROM products";
    $product_result = $conn->query($query);

    echo "<h3>Sản phẩm:</h3>";
    echo "<ul>";

    while ($row = $product_result->fetch_assoc()) {
        $product_id = $row['id'];
        $product_name = $row['tenmathang'];
        $product_price = $row['gia'];
        $product_image = $row['image_path'];
        $can_buy = $user_balance >= $product_price;

        echo "<li>";
        echo "{$product_name} - Giá: {$product_price}";
        echo "<br>";
        echo "<img src='$product_image' alt='{$product_name}' width='100'>";
        echo "<br>";

        if ($can_buy) {
            echo "<form method='POST'>";
            echo "<input type='hidden' name='product_id' value='$product_id'>";
            echo "<input type='submit' value='Mua'>";
            echo "</form>";
        } else {
            echo "<span>Không đủ tiền để mua</span>";
        }
        echo "</li>";
    }

    echo "</ul>";
} else {
    echo "Không tìm thấy người dùng.";
}

// Xử lý mua hàng nếu có yêu cầu POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Lấy thông tin sản phẩm
    $product_query = "SELECT * FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_query);
    $product_info = $product_result->fetch_assoc();
    $product_price = $product_info['gia'];
    if ($user_balance >= $product_price) {
        $new_balance = $user_balance - $product_price;
        $update_query = "UPDATE users SET sotien = $new_balance WHERE id = $user_id";
        $conn->query($update_query);
        echo "Mua hàng thành công!";
    } else {
        echo "Bạn không đủ tiền để mua sản phẩm này.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang người dùng</title>
</head>
<body>
    <!-- Đặt các phần hiển thị thông tin ở trên, trong phần PHP -->

    <!-- Đoạn HTML này chỉ để hiển thị phần dưới trang -->
</body>
</html>
