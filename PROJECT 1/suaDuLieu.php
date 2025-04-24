<?php
session_start();
require_once 'connectDB.php';
require_once 'constant.php';

if (!isset($_SESSION['name']) ||  $_SESSION['name'] != "user") {
    header("Location: login.php ");
    exit();
}



$thongBao = "";
if (isset($_GET['this_id'])) {
    $id = $_GET['this_id'];

    try {
        $sql = "SELECT * FROM sanPham WHERE idSanPham = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {


                $ten = $_POST['ten'];
                $anh = $_FILES['anh'];
                $gia = $_POST['gia'];
                $baoHanh = $_POST['baoHanh'];
                $linkFile = "img/product/";

                try {
                    $sqlCheck = "SELECT * FROM sanPham WHERE tenSanPham = ? AND idSanPham != ?";
                    $stmtCheck = $pdo->prepare($sqlCheck);
                    $stmtCheck->execute([$ten, $id]);  // $ten là tên sản phẩm người dùng nhập, $id là id của sản phẩm hiện tại
                    $existingProduct = $stmtCheck->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $a) {
                    $thongBao .= "Lỗi , mã lỗi :  ^^ " . $a->getMessage();
                }



                if (empty($ten) && empty($gia) && empty($baoHanh)) {
                    $thongBao .= MSG_0_All;
                } elseif ($existingProduct) {
                    $thongBao .= MSG_tontai_Ten;
                } elseif (empty($ten)) {
                    $thongBao .= MSG_0_Ten;
                } elseif (strlen($ten) > 50) {
                    $thongBao .= MSG_length_Ten;
                } elseif (empty($gia)) {
                    $thongBao .= MSG_0_Gia;
                } elseif (!is_numeric($gia)) {
                    $thongBao .= MSG_not_Gia;
                } elseif ($gia > 100000000) {
                    $thongBao .= MSG_lonhon_Gia;
                } elseif (empty($baoHanh)) {
                    $thongBao .= MSG_0_BaoHanh;
                } elseif (!preg_match('/^(1[0-2]|[1-9])\s?tháng$/i', $baoHanh)) {
                    $thongBao .= MSG_not_BaoHanh;
                } else {
                    if ($anh['error'] == UPLOAD_ERR_OK) {

                        if (strlen($anh['name']) > 200) {
                            $thongBao .= MSG_length_Anh;
                        } elseif (!in_array(strtolower(pathinfo($anh["name"], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
                            $thongBao .= MSG_regax_Anh;
                        } elseif ($anh['size'] > 5 * 1024 * 1024) {
                            $thongBao .= MSG_size_Anh;
                        } elseif (file_exists($linkFile . $anh['name'])) {
                            $thongBao .= MSG_tontai_Anh;
                        } else {
                            try {
                                unlink($linkFile . $row['anhSanPham']);
                                move_uploaded_file($anh['tmp_name'], $linkFile . basename($anh['name']));
                                $sql1 = "UPDATE  sanPham 
                            SET tenSanPham =? ,anhSanPham =?, giaSanPham =? , baoHanh =? WHERE idSanPham = ? 
                            ";
                                $stmt = $pdo->prepare($sql1);
                                $stmt->execute([$ten, $anh['name'], $gia, $baoHanh, $id]);
                                $thongBao .= MSG_OK_Sua;
                                header("location:showDuLieu.php");
                                exit();
                            } catch (PDOException $a) {
                                $thongBao .= MSG_OK_Sua . " ,mã lỗi : " . $a->getMessage();
                            }
                        }
                    } elseif ($_FILES['anh']['error'] == UPLOAD_ERR_NO_FILE) {
                        $sql = "UPDATE sanPham  
                   SET tenSanPham=? , giaSanPham=? , baoHanh=? WHERE idSanPham=?
                   ";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$ten, $gia, $baoHanh, $id]);
                        $thongBao .= MSG_OK_Sua;
                        header("location:showDuLieu.php");
                        exit();
                    } else {
                        $thongBao .= MSG_OK_Sua . " ,mã lỗi :" . $anh['error'];
                    }
                }
            }
        } catch (PDOException $a) {
            $thongBao .= "Mã Lỗi :" . $a->getMessage();
        }
    } catch (PDOException $a) {
        $thongBao .= "Lấy thông tin sản phẩm thất bại, mã lỗi :" . $a->getMessage();
    }
} else {
    $thongBao .= MSG_0tontai_ID;
}

















?>
<link rel="stylesheet" href="suaDuLieu.css">
<form action="" method="POST" enctype="multipart/form-data">

    <h1>Sửa thông tin</h1>
    <?php if (!empty($thongBao)) : ?>
        <h2 class="thong-bao"><?= $thongBao ?></h2>
    <?php endif; ?>
    <label for="">Tên sản phẩm</label><input type="text" name="ten" id="" value="<?= htmlspecialchars($row['tenSanPham']) ?>">
    <div class="image-upload-container">
        <label for="anh">Ảnh sản phẩm</label>
        <img src="img/product/<?= htmlspecialchars($row['anhSanPham']) ?>" width="100" alt="Ảnh sản phẩm">
        <input type="file" name="anh" id="anh">

    </div>


    <label for="">Giá sản phẩm</label><input type="text" name="gia" value="<?= htmlspecialchars($row['giaSanPham']) ?>">
    <label for="">Bảo hành</label><input type="text" name="baoHanh" value="<?= htmlspecialchars($row['baoHanh']) ?>">
    <input type="submit" value="Cập nhật">
    <a href="showDuLieu.php">Trang chủ</a>






</form>
