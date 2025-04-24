<?php
require_once 'connect.php';


try {
    //Chỉ dùng 1 stmtCheck là dủ vì đang là nhập fix cứng
    //Khi làm nhập dữ liệu ng dùng thì sẽ phải gọi và lặp lại nhiều hơn 
    $bien = 1;
    $sqlCheck = "SELECT * FROM thanhVien WHERE id = ? ";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$bien]);



    if ($stmtCheck->rowCount() == 0) {
        echo "ID not exist !";
    } else {



        // Nếu chỉ có một bản ghi thì k cần dùng WHILE 
        while ($row = $stmtCheck->fetch(PDO::FETCH_ASSOC)) {
            echo "ID : " . $row["id"] . "<br>";
            echo "Account : " . $row["taiKhoan"] . "<br>";
            echo "Password : " . $row["matKhau"] . "<br>";
            echo "Level : " . $row["level"] . "<br>";
        }
    }
} catch (PDOException $a) {
    echo "Failed ! : " . $a->getMessage();
}
