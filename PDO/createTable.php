<?php 
require_once 'connect.php';

try {
    $sql="CREATE TABLE IF NOT EXISTS thanhVien (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    taiKhoan VARCHAR(20) NOT NULL,
    matKhau VARCHAR(20) NOT NULL,
    level INT NOT NULL )";


    
    $pdo->exec($sql);
    echo "Create Success !";
   
} catch (PDOException $e) {
    echo "Create Fail !" . $e->getMessage();
}

?>