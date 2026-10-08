<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "shopping_cart";
$port = 3306;

mysqli_report(MYSQLI_REPORT_OFF);
$connection = mysqli_connect($host, $username, $password, $database, $port);

if (!$connection) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($connection, "utf8mb4");
