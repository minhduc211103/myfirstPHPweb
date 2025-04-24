<?php
require_once 'connect.php';


$id = 4;



try {
    $sqlCheck = "SELECT COUNT(*) FROM thanhVien WHERE id = ? ";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$id]);
    $ketqua = $stmtCheck->fetchColumn();

    if ($ketqua == 0) {
        echo " ID not exist ! ";
    } else {

        $sql = "UPDATE thanhVien SET level = 0 WHERE id = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "Fix Success !";
    }
} catch (PDOException $a) {
    echo "Fix Failed ! " . $a->getMessage();
}
