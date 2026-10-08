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
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($connection, $sql);
    $product = mysqli_fetch_assoc($result);

    return $product;
}

function addProduct($name, $price, $quantity)
{
    global $connection;

    $name = mysqli_real_escape_string($connection, $name);
    $price = (float) $price;
    $quantity = (int) $quantity;
    $sql = "INSERT INTO products (name, price, quantity) VALUES ('$name', $price, $quantity)";

    return mysqli_query($connection, $sql);
}

function updateProduct($id, $name, $price, $quantity)
{
    global $connection;

    $id = (int) $id;
    $name = mysqli_real_escape_string($connection, $name);
    $price = (float) $price;
    $quantity = (int) $quantity;
    $sql = "UPDATE products SET name = '$name', price = $price, quantity = $quantity WHERE id = $id";

    return mysqli_query($connection, $sql);
}

function deleteProduct($id)
{
    global $connection;

    $id = (int) $id;
    $sql = "DELETE FROM products WHERE id = $id";

    return mysqli_query($connection, $sql);
}
