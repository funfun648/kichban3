<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Người dùng</title>
    <link rel="stylesheet" href="./css/user.css">
</head>

<body>
    <?php
    session_start();
    require('conn2.php');

   if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
    if (!isset($_GET['uID'])) {
        echo "lỗi không thể tìm thấy người dùng";
        echo "<a href='login.php'>Quay lại trang đăng nhập</a>";
        exit();
    }
    // Lấy giá trị uID từ URL
    $uID = $_GET['uID'];

    $query = "SELECT * FROM users WHERE id = $uID";
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        $user_info = $result->fetch_assoc();
        $user_id = $user_info['id'];
        $user_balance = $user_info['sotien'];
        
        // Phòng thủ : Kiểm tra xem người dùng có quyền truy cập vào ID này không
        // if ($user_id != $_SESSION['user_id']) {
        //     echo "Bạn không có quyền truy cập vào ID này.";
        //     exit();
        // }

        echo "<strong>Tên người dùng: </strong>" . $user_info['username'] . "<br>";
        echo "<strong>Số dư tài khoản của bạn: </strong>" . $user_balance . "<br>";

        // Hiển thị sản phẩm và cho phép mua hàng
        $query = "SELECT * FROM products";
        $product_result = $conn->query($query);

        echo "<h3>Sản phẩm:</h3>";
        echo "<ol class='alternating-colors'>";

        while ($row = $product_result->fetch_assoc()) {
            $product_id = $row['id'];
            $product_name = $row['tenmathang'];
            $product_price = $row['gia'];
            $product_image = $row['image_path'];
            $can_buy = $user_balance >= $product_price;

            echo "<li>";
            echo "<strong>{$product_name} </strong> <br> Giá: {$product_price}";
            echo "<img src='$product_image' alt='{$product_name}'>";
            echo "<br>";

            if ($can_buy) {
                echo "<form method='POST'>";
                echo "<input type='hidden' name='product_id' value='$product_id'>";
                echo "<input type='submit' value='Mua' class='button'>";
                echo "</form>";
            } else {
                echo "<span>Không đủ tiền để mua</span>";
            }
            echo "</li>";
        }

        echo "</ol>";

        // Kiểm tra xem người dùng có quyền xem trang quản trị  role là 1
        if ($user_info['role'] == 1) {
            echo "<a href='manager.php'>Trang quản trị</a><br>";
        }
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
            
            if ($conn->query($update_query) === TRUE) {
                // Cập nhật thành công, cập nhật lại biến $user_balance
                $user_balance = $new_balance;
                echo "<script>alert('Mua hàng thành công')</script>";
            } else {
                echo "Lỗi khi cập nhật số dư: " . $conn->error;
            }
        } else {
            echo "Bạn không đủ tiền để mua sản phẩm này.";
        }
    }
    ?>

</body>

</html>