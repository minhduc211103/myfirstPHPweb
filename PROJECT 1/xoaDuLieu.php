<?php
include "constant.php";

require_once "connectDB.php";
include "constant.php";

echo '<link rel="stylesheet" href="xoaDuLieu.css">';
if (!isset($_GET['this_id'])) {
    header("location:showDuLieu.php");
} else {
    $id = $_GET['this_id'];
    $thongBao = "";
    $sql = "SELECT anhSanPham FROM sanPham WHERE idSanPham = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($row) {
        try {
            $sql = "DELETE FROM sanPham WHERE idSanPham = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id]) == true) {

                if (file_exists("img/product/" . $row['anhSanPham'])) {
                    unlink("img/product/" . $row['anhSanPham']); //  xóa hẳn
                    $thongBao .= MSG_Xoa_OK;

                    echo '<meta http-equiv="refresh" content="3;url=showDuLieu.php">';
                } else {
                    $thongBao .= MSG_Xoa_Fail;
                }
            } else {
                $thongBao .= MSG_Xoa_Fail;
                echo "<h1>$thongBao</h1>";
            }
        } catch (PDOException $a) {
            echo " Lỗi , mã lỗi :" . $a->getMessage();
        }
    }
}
