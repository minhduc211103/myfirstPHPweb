<?php
include "constant.php";

require_once 'connectDB.php';
session_start();
if (!isset($_SESSION["name"]) || $_SESSION["name"] !== "user") {
    header("Location: login.php");
    exit();
}


echo '<link rel="stylesheet" href="showDuLieu.css">';

try {
    $sql = "Select * from sanPham ";
    $result = $pdo->query($sql);
    echo "
    <h1>Thông Tin Điện Thoại</h1>
    <table>
    <thead>
    <tr>
    <th>ID</th>
    <th>Tên</th>
    <th>Hình Ảnh</th>
    <th>Giá</th>
    <th>Bảo Hành</th>
    <th>Chức Năng</th>


    </tr>
    </thead>
   ";



    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {


        echo "<tbody>";
        echo "<tr>
    <td>{$row['idSanPham']}</td>
    <td>{$row['tenSanPham']}</td>
    <td><img src='img/product/" . htmlspecialchars($row['anhSanPham']) . "' width='100'></td>
    <td>{$row['giaSanPham']}</td>
    <td>{$row['baoHanh']}</td>
    <td><a href='xoaDuLieu.php?this_id={$row['idSanPham']}'>Xóa</a> |  <a href='suaDuLieu.php?this_id={$row['idSanPham']} '>Sửa</a> </td>
<<<<<<< HEAD
=======
    

>>>>>>> d87e2b791d5c54eaf36e9e07581b460ecae9c73b
    

</tr>";
    }
    echo " </tbody>";
    echo "</table>";
    echo "<div class='button-container'>
            <a href='addDuLieu.php'><button>Thêm Điện Thoại</button></a>
            <a href='logout.php'><button>Đăng xuất</button></a>
            <a href='timKiem.php'><button>Tìm Kiếm</button></a>

          </div>";
} catch (PDOException $a) {
    echo "Lỗi , mã lỗi : " . $a->getMessage();
}
