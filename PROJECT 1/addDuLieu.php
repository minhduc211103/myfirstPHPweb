<?php
require_once "connectDB.php";
include "constant.php";
session_start();
if (!isset($_SESSION["name"]) || $_SESSION["name"] !== "user") {
    header("Location: login.php");
    exit();
}
echo '<link rel="stylesheet" href="addDuLieu.css">';
$thongBao = "";





if (isset($_POST['btn'])) {

    $ten = $_POST["ten"];
    $anh = $_FILES["anh"];
    $gia = $_POST["gia"];
    $baoHanh = $_POST["baoHanh"];
    $thuMuc = "img/product/";
    $duongDan = $thuMuc . basename($anh["name"]);




    try {
        $sql = "INSERT INTO sanPham(tenSanPham,anhSanPham,giaSanPham,baoHanh) VALUES(?,?,?,?)";
        $sqlCheck = "SELECT COUNT(*) FROM sanPham WHERE tenSanPham = ? ";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$ten]);
        $count = $stmtCheck->fetchColumn();

        if (empty($ten) &&  $_FILES["anh"]["error"] === 4 && empty($gia) && empty($baoHanh)) {
            $thongBao .= MSG_0_All;
        } else if (empty($ten)) {
            $thongBao .= MSG_0_Ten;
        } elseif ($count > 0) {
            $thongBao .= MSG_tontai_Ten;
        } elseif (strlen($ten) > 50) {
            $thongBao .= MSG_length_Ten;
        } elseif ($_FILES["anh"]["error"] === 4) {
            $thongBao .= MSG_0_Anh;
        } elseif ($anh['size'] > 5 * 1024 * 1024) {
            $thongBao .= MSG_size_Anh;
        }elseif (strlen($_FILES['anh']['name']) > 200) {
            $thongBao .= MSG_length_Anh;
        }  elseif (!in_array(strtolower(pathinfo($_FILES["anh"]["name"], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
            $thongBao .= MSG_regax_Anh;
        } elseif (file_exists($duongDan)) {
            $thongBao .= MSG_tontai_Anh;
        } elseif (!file_exists($thuMuc)) {
            if (!mkdir($thuMuc, 0777, true)) { // Tạo thư mục nếu không tồn tại
                $thongBao .= "Không thể tạo thư mục lưu ảnh!";
            }
        } elseif (empty($gia)) {
            $thongBao .= MSG_0_Gia;
        } elseif (!is_numeric($gia)) {
            $thongBao .= MSG_not_Gia;
        } elseif ($gia > 100000000) {
            $thongBao .= MSG_lonhon_Gia ;
        } elseif (empty($baoHanh)) {
            $thongBao .= MSG_0_BaoHanh;
        } elseif (!preg_match('/^[1-9][0-9]?\s?tháng$/', $baoHanh)) {
            $thongBao .= MSG_format_Thang;
        } else {
       
            if (move_uploaded_file($_FILES["anh"]["tmp_name"], $duongDan)) {

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$ten, $anh["name"], $gia, $baoHanh]);
                $thongBao .= MSG_them_Ok;
            } else {
                echo MSG_loi_upd;
            }
        }
    } catch (PDOException $a) {
        $thongBao .= "Thất bại , mã lỗi : " . $a->getMessage();
    }
}
echo '<h1>SẢN PHẨM MỚI</h1>';

if (!empty($thongBao)) {
    echo "<h2>$thongBao</h2>";
}

echo '<form action="addDuLieu.php" method="post" enctype="multipart/form-data">

<label for="">Tên Sản Phẩm :</label><input type="text" name="ten">
<label for="">Ảnh Sản Phẩm :</label><input type="file" name="anh">
<label for="">Giá Sản Phẩm :</label><input type="text" name="gia">
<label for="">Bảo Hành :</label><input type="text" name="baoHanh">
<input type="submit" name="btn" value="TẠO">
</form>
<a href="showDuLieu.php"><button>List Điện Thoại</button></a>
';
