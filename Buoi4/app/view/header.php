<?php

if (!isset($pageTitle)) {
    $pageTitle = 'Quản lý sản phẩm';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <header>
        <h1>Quản lý sản phẩm</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="product_list.php">Danh sách sản phẩm</a>
            <a href="product_add.php">Thêm sản phẩm</a>
        </nav>
    </header>
    <main>
