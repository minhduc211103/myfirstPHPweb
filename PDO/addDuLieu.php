<?php
require_once 'connect.php';


//FIX CỨNG
$taiKhoan = "admin7";
$matKhau = "11111111"; //Khi lấy dữ liệu từ ng dùng thì k phải quan tâm đến việc PHP hiểu là INT
$level = 1;


/**	dấu ? đại diện cho giá trị sẽ được truyền vào sau (giúp tránh SQL injection và tăng hiệu suất*/
$sqlCheck = "SELECT COUNT(*) from thanhVien WHERE taiKhoan = ? ";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([$taiKhoan]);
$count = $stmtCheck->fetchColumn();


//Check taiKhoan đã tồn tại + Validate các dkien khác
if (empty($taiKhoan)) {
    echo "Plase insert account name ";
} else if ($count > 0) {
    echo "Account name exist !";
} else if (strlen($taiKhoan) > 20) {
    echo "Account name too long ! ";
} elseif (empty($matKhau)) {
    echo "Plase insert password !";
} elseif (strlen($matKhau) > 20) {
    echo "Password is too long !";
} elseif (empty($level)) {
    echo "Plase insert level !";
} elseif ($level != 1 && $level != 0) {
    echo "Level can only be 1 or 0  !";
} else {
    try {
        // Mã hóa pass 
        $matKhau = password_hash($matKhau, PASSWORD_DEFAULT);

        //Thực hiện truy vấn 
        $sql = "INSERT INTO thanhVien(taiKhoan,matKhau,level) values
        (?,?,?) 
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$taiKhoan, $matKhau, $level]);
        echo "Add Succes !";
    } catch (PDOException $e) {
        echo "Add Fail ! : " . $e->getMessage();
    }
}
