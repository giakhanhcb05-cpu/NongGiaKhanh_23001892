<?php

require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername($username)
{
    global $connection;

    $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function addUser($username, $password)
{
    global $connection;

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($connection, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $hash);

    return mysqli_stmt_execute($stmt);
}
