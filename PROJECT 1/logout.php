<?php


session_start();

// Xóa mọi dữ liệu session
$_SESSION = [];

// Xóa cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],  
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy session
session_destroy();

// Chuyển hướng và DừNG script ngay lập tức
header("Location: login.php");
exit();
