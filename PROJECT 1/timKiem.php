<?php
session_start();

require_once 'connectDB.php';
include "constant.php";


if (!isset($_SESSION['name']) || $_SESSION['name'] != "user") {
    header("location:login.php");
    exit();
}
echo '<link rel="stylesheet" href="timKiem.css">';
$thongBao = "";
$htmlRow = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $ten = $_POST['ten'];
    if (empty($ten)) {
        $thongBao .= MSG_0_Ten;
    } elseif (strlen($ten) > 50) {

        $thongBao .= MSG_length_Ten;
    } else {
        try {
            $sql = "SELECT * FROM sanPham WHERE tenSanPham = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$ten]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {

                $tenLike = "%" . $ten . "%";

                $sql1 = "SELECT * FROM sanPham WHERE tenSanPham LIKE ?";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->execute([$tenLike]);
                $row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                if ($row1) {
                    foreach ($row1 as $row1) {
                        $htmlRow .= "
                            <tr>
                                <td>{$row1['idSanPham']}</td>
                                <td>{$row1['tenSanPham']}</td>
                                <td><img src='img/product/{$row1['anhSanPham']}' width='100px'></td>                                                      
                                <td>{$row1['giaSanPham']}</td>
                                <td>{$row1['baoHanh']}</td>
                            </tr>                                                          
                                ";
                    }
                } else {
                    $thongBao .= MSG_0tontai_Ten;
                }
            } else {
                $htmlRow = "
                <tr>
                    <td>{$row['idSanPham']}</td>
                    <td>{$row['tenSanPham']}</td>
                    <td><img src='img/product/{$row['anhSanPham']}' width='100px'></td>                                        
                    <td>{$row['giaSanPham']}</td>
                    <td>{$row['baoHanh']}</td>
                </tr>
                                       
                   ";
            }
        } catch (PDOException $a) {
            $thongBao .= "Lỗi , mã lỗi : " . $a->getMessage();
        }
    }
}



echo ' <form action="" class="search-form" method="POST">';
echo '<h1>Tìm Kiếm</h1>';
if (!empty($thongBao)) {
    echo " <h2>" . $thongBao . "</h2>";
}


?>


<input type="text" name="ten" id="ten" class="input-field" placeholder="Nhập tên sản phẩm cần tìm ">
<input type="submit" value="Tìm" class="submit-btn">

<table class="product-table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Tên Sản Phẩm</td>
            <td>Ảnh</td>
            <td>Giá Sản Phẩm</td>
            <td>Bảo Hành</td>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($htmlRow)) {
            echo  $htmlRow;
        } ?>
    </tbody>
</table>
</form><a style="text-decoration: none;color: white;" href="showDuLieu.php"><button class="submit-btn">Trang chủ</button></a>
