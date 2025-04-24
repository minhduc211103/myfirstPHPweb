<?php
include "constant.php";
session_start();
include "constant.php";

echo '<link rel="stylesheet" href="login.css">';
require_once 'connectDB.php';
if (isset($_SESSION["name"]) && $_SESSION["name"] == "user") {
    header("Location: showDuLieu.php");
    exit();
}
<<<<<<< HEAD

=======
>>>>>>> d87e2b791d5c54eaf36e9e07581b460ecae9c73b

$thongBao = "";
if (isset($_POST["btn"])) {

    $email = $_POST['ten'];
    $matKhau = $_POST['matKhau'];


    try {
        if (empty($email) && empty($matKhau)) {
            $thongBao .= MSG_0_All;
        } elseif (empty($email)) {
            $thongBao .= MSG_0_Email;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $thongBao .= MSG_format_Email;
        } elseif (empty($matKhau)) {
            $thongBao .= MSG_0_MatKhau;
        } elseif (strlen($matKhau) > 20) {
            $thongBao .= MSG_length_MatKhau;
        } else {
            $sql = "SELECT * FROM taiKhoan WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $ketQua = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$ketQua) {
                $thongBao .= MSG_0tontai_Email;
            } else {


                if ($matKhau === $ketQua["password"]) {

                    $_SESSION['name'] = "user";
                    header('Location:showDuLieu.php');
                    exit();
                } else {
                    $thongBao .= MSG_check_MatKhau;
                }
            }
        }
    } catch (PDOException $a) {
        echo "Không thể kết nối , mã lỗi :" . $a->getMessage();
    }
}






echo '<form action="" method="POST" enctype="multipart/form-data">';

echo '<h1>LOGIN</h1>';
if (!empty($thongBao)) {
    echo "<h2>$thongBao</h2>";
}
echo '   <label for="">Email :</label><input type="text" name="ten" id="">
    <label for="">Mật Khẩu :</label><input type="password" name="matKhau" id="">
    <input type="submit" name="btn" value="ĐĂNG NHẬP">
</form>';;
