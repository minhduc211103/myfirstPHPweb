<?php
require_once 'connect.php';


$id = 5;


try {

    $sqlCheck = "SELECT * from thanhVien WHERE id = ? ";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$id]);
    // $ketQua = $stmtCheck->fetchColumn();          
    //Khi lấy dữ liệu thì dùng fetch , còn ktra có tồn tại không thì dùng rowCount , 
    //nên dùng cách nào hơn trong trường hợp này ạ ?


    if ($stmtCheck->rowCount() == 0) {
        echo "ID not exist !";
    } else {

        $sql = "DELETE FROM thanhVien WHERE id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "Delete Success !";
    }
} catch (PDOException $a) {
    echo "Delete Fail ! " . $a->getMessage();
}
