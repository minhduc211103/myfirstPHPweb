<?php
include "constant.php";

require_once "connectDB.php";

$sql = "CREATE TABLE IF NOT EXISTS sanPham(
idSanPham INT AUTO_INCREMENT PRIMARY KEY, 
tenSanPham VARCHAR(50) NOT NULL,
anhSanPham VARCHAR(200) NOT NULL,
giaSanPham INT NOT NULL,
baoHanh VARCHAR(200) NOT NULL
) ";


try {
    $pdo->exec($sql);
    echo "Tạo bảng thành công !";
} catch (PDOException $a) {
    echo "Tạo bảng thất bại , Mã lỗi : " . $a->getMessage();
}
