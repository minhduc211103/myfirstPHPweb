<?php


session_start();
include "constant.php";
if (!isset($_SESSION["name"]) || $_SESSION["name"] !== "user") {
    header("Location: login.php");
    exit();
}

<<<<<<< HEAD
include "constant.php";
if (!isset($_SESSION["name"]) || $_SESSION["name"] !== "user") {
    header("Location: login.php");
    exit();
}


// Xóa mọi dữ liệu session
=======

// xóa hết mọi dữ liệu session
>>>>>>> d87e2b791d5c54eaf36e9e07581b460ecae9c73b
$_SESSION = [];

// xóa cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,


        $params["path"],           // lấy thông tin từ session hiện tại
        $params["domain"],  
>>>>>>> d87e2b791d5c54eaf36e9e07581b460ecae9c73b
        $params["secure"],
        $params["httponly"]
    );
}

// hủy hẳn session
session_destroy();

// Chuyển hướng và exit ngay lập tức
header("Location: login.php");
exit();
