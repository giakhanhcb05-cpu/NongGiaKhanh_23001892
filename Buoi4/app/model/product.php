<?php

require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts()
{
    global $connection;

    $sql = "SELECT * FROM products ORDER BY id";
    $result = mysqli_query($connection, $sql);
    $products = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

function getProductById($id)
{
    global $connection;

    $id = (int) $id;
    $stmt = mysqli_prepare($connection, "SELECT * FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    return $product;
}

function addProduct($name, $price, $quantity)
{
    global $connection;

    $price = (float) $price;
    $quantity = (int) $quantity;
    $stmt = mysqli_prepare($connection, "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sdi", $name, $price, $quantity);

    return mysqli_stmt_execute($stmt);
}

function updateProduct($id, $name, $price, $quantity)
{
    global $connection;

    $id = (int) $id;
    $price = (float) $price;
    $quantity = (int) $quantity;
    $stmt = mysqli_prepare($connection, "UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sdii", $name, $price, $quantity, $id);

    return mysqli_stmt_execute($stmt);
}

function deleteProduct($id)
{
    global $connection;

    $id = (int) $id;
    $stmt = mysqli_prepare($connection, "DELETE FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);

    if ($ok) {
        $result = mysqli_query($connection, "SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM products");
        $row = mysqli_fetch_assoc($result);
        mysqli_query($connection, "ALTER TABLE products AUTO_INCREMENT = " . (int) $row['next_id']);
    }

    return $ok;
}
