<?php
/**PDO bao gồm :
 * 
 * Dữ liệu kết nối (như thông tin máy chủ, tên cơ sở dữ liệu, tài khoản người dùng, mật khẩu).

Cung cấp các phương thức để thực thi các câu lệnh SQL (SELECT, INSERT, UPDATE, DELETE, ...).

Cung cấp cơ chế bảo mật (như chuẩn bị câu lệnh SQL với tham số, tránh SQL injection).

Quản lý lỗi thông qua cơ chế try-catch và báo cáo lỗi chi tiết. */


$server = "localhost";   //server
$dbname = "csdl1";       //tên db
$user = "root";          //tên ng dùng 
$pass = "";               //mk

try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(" Connect Failed: " . $e->getMessage());
}

/**
 * Ở try , tạo ra biến $pdo hứng một đối tượng PDO đã có các thuộc tính của đối tượng PDO đã bao gồm thông tin kết nối với CSDL
 * Sau đó set cách ném Exception của nó qua setAttribute 
 * Ở catch PDOException sẽ là đại diện của lỗi , đặt rút gọn là biến $e
 * $e->getMessage() để gọi ra lỗi 
 */
