<?php


session_start();
include "constant.php";


// xóa hết mọi dữ liệu session
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
        $params["secure"],
        $params["httponly"]
    );
}

// hủy hẳn session
session_destroy();

// Chuyển hướng và exit ngay lập tức
header("Location: login.php");
exit();
