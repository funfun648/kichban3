Đây là bài lab có các lỗ hổng về Type Juggling, xss và sql injection.

SQLi và xss là 2 lỗ hổng phổ biến nhất . Đồng thời trong bài lab này lợi dụng việc phân quyền cơ sở dữ liệu ta có thể RCE thông qua sql injection. Lỗ hổng Type Juggling khi một ứng dụng web so sánh mật khẩu người dùng với một giá trị băm, sự linh hoạt của PHP trong việc chuyển đổi kiểu dữ liệu có thể bị lợi dụng để tạo ra các giá trị giả mạo có cùng giá trị băm.
