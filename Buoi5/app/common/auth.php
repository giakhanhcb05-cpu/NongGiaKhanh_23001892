<?php
session_start();

// Chưa đăng nhập thì chuyển về trang login
function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
