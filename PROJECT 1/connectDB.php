<?php 
$server="localhost";
$dbname="website";        //Tên DB muốn tạo 
$user="root";
$pass = "";


try {
    $pdo = new PDO("mysql:host=$server;charset=utf8",$user,$pass); //Vì chưa tạo nên chỉ kết nối với DB
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Set thuộc tính xử lí lỗi 
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname"); //Query tạo DB đơn giản
    $pdo = new PDO("mysql:host=$server;dbname=$dbname;charset=utf8",$user,$pass); //Kết nối lần này vào thẳng bảng
    // echo "Kết nối thành công !";
} catch (PDOException $a) {
    echo "Kết nối thất bại : " . $a->getMessage();
}




?>